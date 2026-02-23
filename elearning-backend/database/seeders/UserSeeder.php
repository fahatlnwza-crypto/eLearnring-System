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
                'role' => 'admin',
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
                'role' => 'student',
                'password' => Hash::make('password123'),
            ]
        );

        // Create teacher user
        User::firstOrCreate(
            ['email' => 'teacher@test.com'],
            [
                'username' => 'teacher',
                'firstname' => 'Teacher',
                'lastname' => 'User',
                'role' => 'teacher',
                'password' => Hash::make('teacher123'),
            ]
        );
    }
}
