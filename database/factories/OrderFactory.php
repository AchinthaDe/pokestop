<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total' => $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->randomElement(['paid', 'shipped', 'delivered', 'cancelled']),
            'meta' => ['payment' => 'dummy'],
        ];
    }
}
