<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_add_to_cart_and_checkout_creates_order_and_reduces_stock()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 3, 'price' => 10]);

        $this->actingAs($user)
            ->post(route('cart.add', $product))
            ->assertRedirect();

        // Checkout
        $response = $this->actingAs($user)
            ->post(route('cart.checkout'));

        $this->assertDatabaseHas('orders', ['user_id' => $user->id]);
        
        $order = Order::where('user_id', $user->id)->first();
        $response->assertRedirect(route('orders.confirmation', $order->id));
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id, 'quantity' => 1]);

        $product->refresh();
        $this->assertEquals(2, $product->stock);
    }

    public function test_checkout_with_empty_cart_is_prevented()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('cart.checkout'))
            ->assertSessionHasErrors();

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_checkout_with_multiple_items_creates_order_with_all_items_and_decrements_stock()
    {
        $user = User::factory()->create();
        $p1 = Product::factory()->create(['stock' => 5, 'price' => 10]);
        $p2 = Product::factory()->create(['stock' => 2, 'price' => 5]);

        // add first product twice
        $this->actingAs($user)->post(route('cart.add', $p1));
        $this->actingAs($user)->post(route('cart.add', $p1));

        // add second product once
        $this->actingAs($user)->post(route('cart.add', $p2));

        // Checkout
        $response = $this->actingAs($user)->post(route('cart.checkout'));

        $this->assertDatabaseHas('orders', ['user_id' => $user->id]);
        $order = Order::where('user_id', $user->id)->first();
        $response->assertRedirect(route('orders.confirmation', $order->id));
        $this->assertNotNull($order);

        $this->assertDatabaseHas('order_items', ['order_id' => $order->id, 'product_id' => $p1->id, 'quantity' => 2]);
        $this->assertDatabaseHas('order_items', ['order_id' => $order->id, 'product_id' => $p2->id, 'quantity' => 1]);

        $p1->refresh(); $p2->refresh();
        $this->assertEquals(3, $p1->stock);
        $this->assertEquals(1, $p2->stock);
    }
}
