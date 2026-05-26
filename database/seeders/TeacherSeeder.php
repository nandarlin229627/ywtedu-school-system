<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        // Teacher One
        // $teacherUser1 = User::create([
        //     'name' => 'Teacher One',
        //     'email' => 'teacher1@school.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'teacher',
        // ]);

        // $teacher1 = Teacher::create([
        //     'user_id' => $teacherUser1->id,
        //     // 'teacher_no' => 'TCH001',
        //     'qualification' => 'B.Ed Mathematics',
        //     'hire_date' => '2023-01-10',
        //     'salary' => 500000,
        //     'status' => 'active',
        //     'phone' => '09123456789', // ✅ added phone number
        // ]);

        // // Attach subjects (make sure subjects exist first!)
        // $teacher1->subjects()->attach([1, 2]);


        // Teacher Two
        $teacherUser2 = User::create([
            'name' => 'Teacher Two',
            'email' => 'teacher2@school.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        $teacher2 = Teacher::create([
            'user_id' => $teacherUser2->id,
            // 'teacher_no' => 'TCH002',
            'qualification' => 'M.Sc Physics',
            'hire_date' => '2022-06-15',
            'salary' => 650000,
            'status' => 'leave',
            'phone' => '09876543210', // ✅ added phone number
        ]);

        $teacher2->subjects()->attach([2, 3]);
    }
}