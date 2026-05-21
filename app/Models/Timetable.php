<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;

class Timetable extends Model
{
    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
        'day',
        'time',
        'room',
    ];

    // ✅ Check teacher availability
    public static function isTeacherAvailable($teacherId, $day, $time, $ignoreId = null)
    {
        return !self::where('teacher_id', $teacherId)
            ->where('day', $day)
            ->where('time', $time)
            ->when($ignoreId, function ($q) use ($ignoreId) {
                $q->where('id', '!=', $ignoreId);
            })
            ->exists();
    }

    // ✅ Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // ✅ Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // ✅ Class (IMPORTANT: THIS is your correct relationship name)
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}