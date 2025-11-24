<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon; 

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
                
                // PERBAIKAN DI SINI: Menggunakan 'birthday' sesuai migration Anda
                // Format password: dmY (Contoh: 25052010)
                $passwordDefault = $student->birthday 
                    ? Carbon::parse($student->birthday)->format('dmY') 
                    : '12345678'; // Password cadangan jika tgl lahir kosong

                $user = User::create([
                    'name' => 'Wali Murid ' . $student->name,
                    // Email otomatis: nisn@orangtua.id
                    'email' => $student->nisn . '@orangtua.id', 
                    // Password otomatis dari tanggal lahir
                    'password' => Hash::make($passwordDefault),
                    'role' => 'parent',
                ]);

                $student->user_id = $user->id;
            }
        });

        // Update nama user jika nama siswa diedit
        static::updating(function ($student) {
            if ($student->user && $student->isDirty('name')) {
                $student->user->update(['name' => 'Wali Murid ' . $student->name]);
            }
            
            // Update email login jika NISN diedit
            if ($student->user && $student->isDirty('nisn')) {
                $student->user->update(['email' => $student->nisn . '@orangtua.id']);
            }
        });
    }
    // -------------------------------------------

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}