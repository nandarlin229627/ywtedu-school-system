<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '1111111111',
                'address' => 'Main Office',
            ],
            [
                'name' => 'Teacher One',
                'email' => 'teacher@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'phone' => '2222222222',
                'address' => 'Staff Room',
            ],
            [
                'name' => 'Student One',
                'email' => 'student@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'phone' => '3333333333',
                'address' => 'Dormitory',
            ],
        ]);
    }
}