<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $grades = ['Grade5', 'Grade7', 'Grade10', 'Grade11'];

        for ($i = 1; $i <= 20; $i++) {

            $firstName = 'Student' . $i;
            $lastName = 'Test';

            DB::table('students')->insert([
                'user_id' => 1,
                'student_no' => 'STU-' . str_pad($i, 4, '0', STR_PAD_LEFT),

                'name' => $firstName . ' ' . $lastName,
                'first_name' => $firstName,
                'last_name' => $lastName,

                'email' => 'student' . $i . '@example.com',
                'password' => bcrypt('password'),

                'dob' => Carbon::now()->subYears(rand(10, 18))->subDays(rand(1, 365)),

                'phone' => '09' . rand(100000000, 999999999),
                'address' => 'Magway, Myanmar',

                'gender' => rand(0, 1) ? 'male' : 'female',

                'photo' => null,

                'guardian_name' => 'Guardian ' . $i,
                'relationship' => 'parent',
                'guardian_phone' => '09' . rand(100000000, 999999999),
                'guardian_email' => 'guardian' . $i . '@example.com',

                'grade' => $grades[array_rand($grades)],

                'previous_school' => 'Previous School ' . rand(1, 5),

                'parent_id' => null,

                'status' => 'active',

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}