<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $this->call([\Database\Seeders\AdminUserSeeder::class]);

        // Create test user (if not exists)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        // Seed Pokemon cards from pocketslabs.com
        $this->call([\Database\Seeders\PokemonCardsSeeder::class]);
    }
}
