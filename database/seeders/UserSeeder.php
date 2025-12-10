<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin kullanıcı
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '05551234567',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Normal kullanıcı
        User::create([
            'name' => 'Muhammed Ali',
            'email' => 'ali@example.com',
            'phone' => '05559876543',
            'password' => Hash::make('123456'),
            'role' => 'user',
            'is_active' => true,
        ]);

        // Test kullanıcısı
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '05551112233',
            'password' => Hash::make('123456'),
            'role' => 'user',
            'is_active' => true,
        ]);
    }
}
