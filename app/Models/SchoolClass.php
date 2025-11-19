<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke Wali Kelas (Guru)
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relasi ke Siswa (Satu kelas punya banyak siswa)
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}