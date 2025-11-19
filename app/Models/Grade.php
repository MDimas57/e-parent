<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import ini

class Grade extends Model
{
    use HasFactory;

    // Izinkan input data (Mass Assignment)
    protected $guarded = [];

    // Definisi Relasi ke Student
    // Inilah fungsi yang dicari oleh Filament
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}