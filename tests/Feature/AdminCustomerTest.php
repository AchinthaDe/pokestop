<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminCustomerTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_customers_index()
    {
        $admin = $this->createAdmin();
        User::factory()->count(5)->create();

        $this->actingAs($admin)
            ->get(route('admin.customers.index'))
            ->assertOk()
            ->assertViewIs('admin.customers.index');
    }

    public function test_admin_can_ban_customer()
    {
        $admin = $this->createAdmin();
        $customer = User::factory()->create(['banned' => false]);

        $this->actingAs($admin)
            ->post(route('admin.customers.ban', $customer), [
                'ban_reason' => 'Violated terms of service',
            ])
            ->assertRedirect();

        $customer->refresh();
        $this->assertTrue($customer->banned);
        $this->assertEquals('Violated terms of service', $customer->ban_reason);
    }

    public function test_admin_can_unban_customer()
    {
        $admin = $this->createAdmin();
        $customer = User::factory()->create([
            'banned' => true,
            'ban_reason' => 'Test ban',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.customers.unban', $customer))
            ->assertRedirect();

        $customer->refresh();
        $this->assertFalse($customer->banned);
        $this->assertNull($customer->ban_reason);
    }

    public function test_banned_customer_is_redirected_on_login()
    {
        $customer = User::factory()->create([
            'banned' => true,
            'ban_reason' => 'Spam',
        ]);

        $response = $this->actingAs($customer)
            ->get(route('products.browse'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_non_admin_cannot_ban_customer()
    {
        $user = User::factory()->create(['role' => 'user']);
        $customer = User::factory()->create(['banned' => false]);

        $this->actingAs($user)
            ->post(route('admin.customers.ban', $customer), [
                'ban_reason' => 'Should not work',
            ])
            ->assertForbidden();

        $customer->refresh();
        $this->assertFalse($customer->banned);
    }
}
