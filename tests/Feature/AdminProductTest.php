<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        $admin = User::factory()->create(['role' => 'admin']);
        return $admin;
    }

    public function test_non_admin_cannot_access_admin_products()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $this->actingAs($user)
            ->get(route('admin.products.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_products_index()
    {
        $admin = $this->createAdmin();
        Product::factory()->count(3)->create();

        $this->actingAs($admin)
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertViewIs('admin.products.index');
    }

    public function test_admin_can_create_product()
    {
        $admin = $this->createAdmin();
        $category = ProductCategory::factory()->create();

        $productData = [
            'pokemon_name' => 'Pikachu',
            'pokemon_number' => 25,
            'category_id' => $category->id,
            'price' => 100.50,
            'stock' => 10,
            'description' => 'Electric mouse Pokemon',
        ];

        $this->actingAs($admin)
            ->post(route('admin.products.store'), $productData)
            ->assertRedirect();

        $this->assertDatabaseHas('products', [
            'pokemon_name' => 'Pikachu',
            'pokemon_number' => 25,
            'price' => 100.50,
        ]);
    }

    public function test_admin_can_update_product()
    {
        $admin = $this->createAdmin();
        $product = Product::factory()->create(['price' => 50]);

        $this->actingAs($admin)
            ->put(route('admin.products.update', $product), [
                'pokemon_name' => $product->pokemon_name,
                'pokemon_number' => $product->pokemon_number,
                'category_id' => $product->category_id,
                'price' => 75.00,
                'stock' => $product->stock,
                'description' => $product->description,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 75.00,
        ]);
    }
}
