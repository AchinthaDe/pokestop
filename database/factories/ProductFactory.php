<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => \App\Models\ProductCategory::factory(),
            'pokemon_name' => $this->faker->word(),
            'pokemon_number' => $this->faker->numberBetween(1, 1000),
            'card_name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'stock' => $this->faker->numberBetween(0, 10),
            'image_url' => null,
            'description' => $this->faker->sentence(),
        ];
    }
}
