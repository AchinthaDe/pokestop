<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_orders_relationship()
    {
        $user = User::factory()->create();
        $order1 = Order::factory()->create(['user_id' => $user->id]);
        $order2 = Order::factory()->create(['user_id' => $user->id]);

        $orders = $user->orders;
        $this->assertCount(2, $orders);
        $this->assertTrue($orders->contains($order1));
        $this->assertTrue($orders->contains($order2));
    }

    public function test_user_has_cart_relationship()
    {
        $user = User::factory()->create();
        $cart = Cart::create(['user_id' => $user->id]);

        $this->assertInstanceOf(Cart::class, $user->cart);
        $this->assertEquals($cart->id, $user->cart->id);
    }

    public function test_is_banned_returns_true_for_banned_user()
    {
        $user = User::factory()->create(['banned' => true]);
        $this->assertTrue($user->isBanned());
    }

    public function test_is_banned_returns_false_for_active_user()
    {
        $user = User::factory()->create(['banned' => false]);
        $this->assertFalse($user->isBanned());
    }

    public function test_user_can_be_banned()
    {
        $user = User::factory()->create(['banned' => false]);
        
        $user->banned = true;
        $user->ban_reason = 'Test reason';
        $user->save();

        $this->assertTrue($user->isBanned());
        $this->assertEquals('Test reason', $user->ban_reason);
    }

    public function test_user_can_be_unbanned()
    {
        $user = User::factory()->create([
            'banned' => true,
            'ban_reason' => 'Some reason',
        ]);

        $user->banned = false;
        $user->ban_reason = null;
        $user->save();

        $this->assertFalse($user->isBanned());
        $this->assertNull($user->ban_reason);
    }
}
