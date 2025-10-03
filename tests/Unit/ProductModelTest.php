<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_category()
    {
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(ProductCategory::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_product_has_order_items_relationship()
    {
        $product = Product::factory()->create();
        $orderItem1 = OrderItem::factory()->create(['product_id' => $product->id]);
        $orderItem2 = OrderItem::factory()->create(['product_id' => $product->id]);

        $this->assertCount(2, $product->orderItems);
    }

    public function test_product_stock_can_be_decremented()
    {
        $product = Product::factory()->create(['stock' => 10]);
        
        $product->decrement('stock', 3);

        $this->assertEquals(7, $product->fresh()->stock);
    }

    public function test_product_price_is_cast_to_float()
    {
        $product = Product::factory()->create(['price' => '99.99']);
        
        $this->assertIsFloat($product->price);
        $this->assertEquals(99.99, $product->price);
    }
}
