<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            ['subject_name' => 'Mathematics', 'created_at' => now(), 'updated_at' => now()],
            ['subject_name' => 'English', 'created_at' => now(), 'updated_at' => now()],
            ['subject_name' => 'Physics', 'created_at' => now(), 'updated_at' => now()],
            ['subject_name' => 'Chemistry', 'created_at' => now(), 'updated_at' => now()],
            ['subject_name' => 'Biology', 'created_at' => now(), 'updated_at' => now()],
            ['subject_name' => 'History', 'created_at' => now(), 'updated_at' => now()],
            ['subject_name' => 'Geography', 'created_at' => now(), 'updated_at' => now()],
            ['subject_name' => 'Computer Science', 'created_at' => now(), 'updated_at' => now()],
            ['subject_name' => 'Physical Education', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('subjects')->insert($subjects);
    }
}