<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | Admins
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Main Admin',
            'email' => 'admin1@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Second Admin',
            'email' => 'admin2@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Parents
        |--------------------------------------------------------------------------
        */
        $parentUser1 = User::create([
            'name' => 'Parent One',
            'email' => 'parent1@school.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
        ]);

        $parent1 = ParentModel::create([
            'user_id' => $parentUser1->id,
            'phone' => '0911111111',
            'address' => 'Taunggyi',
        ]);

        $parentUser2 = User::create([
            'name' => 'Parent Two',
            'email' => 'parent2@school.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
        ]);

        $parent2 = ParentModel::create([
            'user_id' => $parentUser2->id,
            'phone' => '0922222222',
            'address' => 'Kalaw',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Students
        |--------------------------------------------------------------------------
        */
        $studentUser1 = User::create([
            'name' => 'Student One',
            'email' => 'student1@school.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $studentUser1->id,
            'student_no' => 'STU001',
            'dob' => '2010-01-01',
            'address' => 'Taunggyi',
            'parent_id' => $parent1->id,
        ]);

        $studentUser2 = User::create([
            'name' => 'Student Two',
            'email' => 'student2@school.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $studentUser2->id,
            'student_no' => 'STU002',
            'dob' => '2011-02-15',
            'address' => 'Kalaw',
            'parent_id' => $parent2->id,
        ]);

        $studentUser3 = User::create([
            'name' => 'Student Three',
            'email' => 'student3@school.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $studentUser3->id,
            'student_no' => 'STU003',
            'dob' => '2012-03-20',
            'address' => 'Aungban',
            'parent_id' => $parent1->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Teachers
        |--------------------------------------------------------------------------
        */
        // $teacherUser1 = User::create([
        //     'name' => 'Teacher One',
        //     'email' => 'teacher1@school.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'teacher',
        // ]);

        // Teacher::create([
        //     'user_id' => $teacherUser1->id,
        //     'teacher_no' => 'TCH001',
        //     'qualification' => 'B.Ed Mathematics',
        //     'hire_date' => '2023-01-10',
        //     'salary' => 500000,
        //     'status' => 'active', // Added status
        // ]);

        // $teacherUser2 = User::create([
        //     'name' => 'Teacher Two',
        //     'email' => 'teacher2@school.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'teacher',
        // ]);

        // Teacher::create([
        //     'user_id' => $teacherUser2->id,
        //     'teacher_no' => 'TCH002',
        //     'qualification' => 'M.Sc Physics',
        //     'hire_date' => '2022-06-15',
        //     'salary' => 650000,
        //     'status' => 'leave', // Example: on leave
        // ]);

        // $teacher->subjects()->attach([1,2]); // attach subjects with IDs 1 and 2
    }
}