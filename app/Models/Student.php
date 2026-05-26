<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_no',
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'dob',
        'phone',
        'address',
        'guardian_name',
        'relationship',
        'guardian_phone',
        'guardian_email',
        'grade',
        'previous_school',
        'status',
        'photo',
        'parent_id'
    ];

    protected $hidden = ['password'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Classes relationship (Cleaned: No pivot data tracking)
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(
            SchoolClass::class,
            'student_class',
            'student_id',
            'class_id'
        )->withTimestamps();
    }
    
    // belongsToMany ကို ဖျက်ပြီး ဒါကို ထည့်ပါ
public function schoolClass(): BelongsTo
{
    return $this->belongsTo(SchoolClass::class, 'class_id');
}
}