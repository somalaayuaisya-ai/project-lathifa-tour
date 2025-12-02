<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@lathifatour.com',
            'password' => Hash::make('password'),
            'phone' => '6285219022248',
            'role' => UserRole::ADMIN,
            'avatar_url' => 'https://i.pinimg.com/736x/89/b1/14/89b1140185155c86309e594317bf331b.jpg',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Create Regular User
        User::create([
            'name' => 'Jamaah Biasa',
            'email' => 'user@lathifatour.com',
            'password' => Hash::make('password'),
            'phone' => '6285810975143',
            'role' => UserRole::USER,
            'avatar_url' => 'https://i.pinimg.com/736x/11/e7/2b/11e72b6be32afd51e3ce6e1bb7e0b233.jpg',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // You can add more users using User::factory() if needed
        // User::factory(10)->create();
    }
}