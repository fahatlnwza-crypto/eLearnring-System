<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'username' => 'admin',
                'firstname' => 'Admin',
                'lastname' => 'User',
                'password' => Hash::make('admin123'),
            ]
        );

        // Create test user
        User::firstOrCreate(
            ['email' => 'test@test.com'],
            [
                'username' => 'testuser',
                'firstname' => 'Test',
                'lastname' => 'User',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
