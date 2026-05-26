<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolClassSeeder extends Seeder
{
    public function run()
    {
        // Grade တစ်ခုစီအတွက် Section တွေကို သီးသန့်သတ်မှတ်ပေးခြင်း
        $data = [
            'Grade 1'  => ['A', 'B'],
            'Grade 2'  => ['A', 'B'],
            'Grade 3'  => ['A', 'B'],
            'Grade 4'  => ['A', 'B'],
            'Grade 5'  => ['A', 'B'],
            'Grade 6'  => ['A', 'B'],
            'Grade 7'  => ['A', 'B'],
            'Grade 8'  => ['A', 'B'],
            'Grade 9'  => ['A', 'B'],
            'Grade 10'  => ['A', 'B'],
            'Grade 11'  => ['A', 'B'],
            'Grade 12'  => ['A', 'B']// ဥပမာ - Grade 3 မှာ C ပါမယ်ဆိုရင်
            // ကျန်တဲ့ Grade တွေကိုလည်း ဒီအတိုင်း ဆက်ဖြည့်သွားနိုင်ပါတယ်
        ];

        $classes = [];
        $teacherId = 1;
        $roomId = 1;

        foreach ($data as $gradeName => $sections) {
            foreach ($sections as $section) {
                $classes[] = [
                    'class_name' => "$gradeName ($section)",
                    'teacher_id' => $teacherId,
                    'room_id'    => $roomId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // လိုအပ်ရင် ဒီနေရာမှာ ID ကို တိုးပေးပါ
                $teacherId++;
                $roomId++;
            }
        }

        DB::table('school_classes')->insert($classes);
    }
}