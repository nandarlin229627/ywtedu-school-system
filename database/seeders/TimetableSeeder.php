<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        $classIds   = DB::table('school_classes')->pluck('id')->toArray();
        $subjectIds = DB::table('subjects')->pluck('id')->toArray();
        $teacherIds = DB::table('teachers')->pluck('id')->toArray();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $times = [
            '08:00 - 09:00',
            '09:00 - 10:00',
            '10:00 - 11:00',
            '11:00 - 12:00',
            '13:00 - 14:00',
        ];

        foreach ($classIds as $classId) {
            foreach ($days as $day) {
                foreach ($times as $time) {

                    // 🔴 pick safe random values
                    $teacherId = $teacherIds[array_rand($teacherIds)];
                    $subjectId  = $subjectIds[array_rand($subjectIds)];
                    $room       = 'Room ' . rand(101, 110);

                    // ❌ CHECK 1: teacher conflict
                    $teacherBusy = DB::table('timetables')
                        ->where('teacher_id', $teacherId)
                        ->where('day', $day)
                        ->where('time', $time)
                        ->exists();

                    // ❌ CHECK 2: class conflict
                    $classBusy = DB::table('timetables')
                        ->where('class_id', $classId)
                        ->where('day', $day)
                        ->where('time', $time)
                        ->exists();

                    // ❌ CHECK 3: room conflict
                    $roomBusy = DB::table('timetables')
                        ->where('room', $room)
                        ->where('day', $day)
                        ->where('time', $time)
                        ->exists();

                    // ✅ ONLY INSERT IF ALL SAFE
                    if (!$teacherBusy && !$classBusy && !$roomBusy) {

                        DB::table('timetables')->insert([
                            'class_id'   => $classId,
                            'subject_id' => $subjectId,
                            'teacher_id' => $teacherId,
                            'day'        => $day,
                            'time'       => $time,
                            'room'       => $room,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        }
    }
}