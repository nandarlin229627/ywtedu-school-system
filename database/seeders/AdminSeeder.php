<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Admin Account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ywtedu.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Teacher Account
        User::create([
            'name' => 'Teacher One',
            'email' => 'teacher@ywtedu.com',
            'password' => Hash::make('password'),
            'role' => 'teacher'
        ]);

        // Student Account
        User::create([
            'name' => 'Student One',
            'email' => 'student@ywtedu.com',
            'password' => Hash::make('password'),
            'role' => 'student'
        ]);
    }
}