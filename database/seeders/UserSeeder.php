<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'role' => 'Admin',
            'email' => 'admin@email.com',
            'email_verified_at' => now(),
            'phone_number' => '1234567890',
            'password' => Hash::make('password'),
        ]);
    }
}
