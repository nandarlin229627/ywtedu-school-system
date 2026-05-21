<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [

            // Primary
            [
                'class_name' => 'Year 1',
                'section' => 'A',
            ],

            [
                'class_name' => 'Year 2',
                'section' => 'A',
            ],

            [
                'class_name' => 'Year 3',
                'section' => 'A',
            ],

            [
                'class_name' => 'Year 4',
                'section' => 'A',
            ],

            // Middle
            [
                'class_name' => 'Year 5',
                'section' => 'A',
            ],

            [
                'class_name' => 'Year 6',
                'section' => 'A',
            ],

            [
                'class_name' => 'Year 7',
                'section' => 'A',
            ],

            [
                'class_name' => 'Year 8',
                'section' => 'A',
            ],

            // High School
            [
                'class_name' => 'Year 9',
                'section' => 'A',
            ],

            [
                'class_name' => 'Year 10',
                'section' => 'A',
            ],

        ];

        foreach ($classes as $class) {

            SchoolClass::create([
                'class_name' => $class['class_name'],
                'section' => $class['section'],
                'teacher_id' => null,
            ]);
        }
    }
}