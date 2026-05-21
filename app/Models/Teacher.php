<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_no',
        'phone',
        'qualification',
        'hire_date',
        'salary',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher');
    }

        public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}