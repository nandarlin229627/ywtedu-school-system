<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
        'teacher_id',
        'room_id'
    ];

    /**
     * Students relationship (Cleaned: No pivot data tracking)
     */
  
   public function students(): BelongsToMany
{
    return $this->belongsToMany(
        Student::class,
        'student_class',
        'class_id',   // Ensure this matches your pivot table column
        'student_id'  // Ensure this matches your pivot table column
    )->withTimestamps();
}


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
