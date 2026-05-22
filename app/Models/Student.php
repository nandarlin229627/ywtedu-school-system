<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_no',
        'dob',
        'address',
        'parent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // public function marks()
    // {
    //     return $this->hasMany(Mark::class);
    // }

        public function results()
    {
        return $this->hasMany(\App\Models\Result::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // ✅ FIXED RELATION (IMPORTANT)
    public function classes()
    {
        return $this->belongsToMany(
            SchoolClass::class,
            'student_class',
            'student_id',
            'class_id'
        );
    }
}