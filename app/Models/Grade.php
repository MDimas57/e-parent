<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // --- NEW RELATIONSHIP FOR FIXING THE ERROR ---
    // This connects a Grade to all other Grades of the same Student
    public function studentGrades(): HasMany
    {
        return $this->hasMany(Grade::class, 'student_id', 'student_id');
    }
}