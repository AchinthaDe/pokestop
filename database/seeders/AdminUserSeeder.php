<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Only create if not exists
        if (!User::where('email', 'admin@pokestop.test')->exists()) {
            User::create([
                'name' => 'Site Admin',
                'email' => 'admin@pokestop.test',
                'password' => Hash::make('AdminPassword123!'),
                'role' => 'admin',
                'banned' => false,
            ]);
        }
    }
}
