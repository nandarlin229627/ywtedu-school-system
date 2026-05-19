<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ywt.edu',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Teacher One',
            'email' => 'teacher@ywt.edu',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Student One',
            'email' => 'student@ywt.edu',
            'password' => Hash::make('password123'),
        ]);
    }
}