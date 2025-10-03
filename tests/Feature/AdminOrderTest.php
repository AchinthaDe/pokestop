<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_orders_index()
    {
        $admin = $this->createAdmin();
        Order::factory()->count(3)->create();

        $this->actingAs($admin)
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertViewIs('admin.orders.index');
    }

    public function test_admin_can_view_order_details()
    {
        $admin = $this->createAdmin();
        $order = Order::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertViewIs('admin.orders.show');
    }

    public function test_admin_can_update_order_status()
    {
        $admin = $this->createAdmin();
        $order = Order::factory()->create(['status' => 'paid']);

        $this->actingAs($admin)
            ->put(route('admin.orders.updateStatus', $order), [
                'status' => 'shipped',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'shipped',
        ]);
    }

    public function test_non_admin_cannot_update_order_status()
    {
        $user = User::factory()->create(['role' => 'user']);
        $order = Order::factory()->create(['status' => 'paid']);

        $this->actingAs($user)
            ->put(route('admin.orders.updateStatus', $order), [
                'status' => 'shipped',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
        ]);
    }
}
