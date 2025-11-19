<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Logika Otomatisasi Pembuatan Akun
    protected static function booted(): void
    {
        static::creating(function ($teacher) {
            // 1. Buat Akun User baru secara otomatis
            $user = User::create([
                'name' => $teacher->name,
                // Email otomatis: nip@sekolah.id
                'email' => $teacher->nip . '@sekolah.id', 
                'password' => Hash::make('password123'), // Password default
                'role' => 'teacher', // Set role sebagai guru
            ]);

            // 2. Sambungkan ID User yang baru dibuat ke data Guru
            $teacher->user_id = $user->id;
        });
        
        // Update nama user jika nama guru diedit
        static::updating(function ($teacher) {
            if ($teacher->user && $teacher->isDirty('name')) {
                $teacher->user->update(['name' => $teacher->name]);
            }
        });
    }

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kelas
    public function schoolClass(): HasOne
    {
        return $this->hasOne(SchoolClass::class);
    }
}