<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [

        'user_id',
        'staff_no',

        'name',
        'email',
        'phone',

        'role',
        'department',

        'experience',

        'salary',

        'status',

        'attendance',

        'address',

        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}