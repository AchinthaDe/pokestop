<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class GuestPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_landing_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('PokéStop', false);
    }

    public function test_guest_can_view_product_page()
    {
        $product = Product::factory()->create(['stock' => 5]);
        $response = $this->get(route('products.show', $product));
        $response->assertStatus(200);
        $response->assertSeeText((string) $product->pokemon_name);
    }

    public function test_guest_can_view_browse()
    {
        $response = $this->get(route('products.browse'));
        $response->assertStatus(200);
    }
}
