<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\SchoolClass;

class StudentClassSeeder extends Seeder
{
    public function run(): void
    {
        // get all students and classes
        $students = Student::all();
        $classes = SchoolClass::all();

        if ($students->isEmpty() || $classes->isEmpty()) {
            return;
        }

        foreach ($students as $student) {

            // assign random 1 or 2 classes per student
            $randomClasses = $classes->random(rand(1, 2));

            foreach ($randomClasses as $class) {

                DB::table('student_class')->insert([
                    'student_id' => $student->id,
                    'class_id'   => $class->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}