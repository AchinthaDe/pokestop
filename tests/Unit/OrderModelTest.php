<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_belongs_to_user()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
    }

    public function test_order_has_many_items()
    {
        $order = Order::factory()->create();
        $item1 = OrderItem::factory()->create(['order_id' => $order->id]);
        $item2 = OrderItem::factory()->create(['order_id' => $order->id]);

        $this->assertCount(2, $order->items);
        $this->assertTrue($order->items->contains($item1));
        $this->assertTrue($order->items->contains($item2));
    }

    public function test_order_total_is_stored_correctly()
    {
        $order = Order::factory()->create(['total' => 150.75]);

        $this->assertEquals(150.75, $order->total);
    }

    public function test_order_status_can_be_updated()
    {
        $order = Order::factory()->create(['status' => 'paid']);

        $order->status = 'shipped';
        $order->save();

        $this->assertEquals('shipped', $order->fresh()->status);
    }
}
