<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Subject;

class ResultSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $subjects = Subject::all();

        if ($students->isEmpty() || $subjects->isEmpty()) {
            return;
        }

        foreach ($students as $student) {

            foreach ($subjects as $subject) {

                // random marks
                $marks = rand(35, 100);

                // grade logic
                if ($marks >= 80) {
                    $grade = 'A';
                } elseif ($marks >= 70) {
                    $grade = 'B';
                } elseif ($marks >= 60) {
                    $grade = 'C';
                } elseif ($marks >= 50) {
                    $grade = 'D';
                } else {
                    $grade = 'F';
                }

                DB::table('results')->insert([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'marks'      => $marks,
                    'grade'      => $grade,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}