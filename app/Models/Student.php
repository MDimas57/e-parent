<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    // --- LOGIKA OTOMATIS BUAT AKUN ORANG TUA ---
    protected static function booted(): void
    {
        static::creating(function ($student) {
            // Hanya buat user jika user_id belum diisi
            if (empty($student->user_id)) {
                $user = User::create([
                    'name' => 'Wali Murid ' . $student->name,
                    // Email otomatis: nisn@orangtua.id
                    'email' => $student->nisn . '@orangtua.id', 
                    'password' => Hash::make('password123'),
                    'role' => 'parent',
                ]);

                $student->user_id = $user->id;
            }
        });

        // Opsional: Update nama Wali Murid jika nama siswa diedit
        static::updating(function ($student) {
            if ($student->user && $student->isDirty('name')) {
                $student->user->update(['name' => 'Wali Murid ' . $student->name]);
            }
        });
    }
    // -------------------------------------------

    // Relasi ke Kelas
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    // Relasi ke Akun Orang Tua
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Absensi (PENTING: Jangan dihapus agar fitur Scan QR jalan)
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    // Relasi ke Nilai (PENTING: Agar fitur Nilai jalan)
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}