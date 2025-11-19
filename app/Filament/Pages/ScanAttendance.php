<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use App\Models\Student;
use App\Models\Attendance;

class ScanAttendance extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    
    protected static ?string $navigationLabel = 'Scan Absensi';

    protected static string $view = 'filament.pages.scan-attendance';

    public static function canAccess(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'teacher']);
    }

    // Variabel ini akan diisi otomatis oleh JavaScript Kamera
    public $nisn_input = '';

    public function save()
    {
        // Validasi: Jika input kosong, stop
        if (empty($this->nisn_input)) {
            return;
        }

        // 1. Cari Siswa
        $student = Student::where('nisn', $this->nisn_input)->first();

        if (!$student) {
            Notification::make()
                ->title('Gagal')
                ->body("NISN {$this->nisn_input} tidak ditemukan.")
                ->danger()
                ->send();
            
            // Reset input
            $this->nisn_input = ''; 
            return;
        }

        // 2. Cek Duplikasi Absen Hari Ini
        $alreadyPresent = Attendance::where('student_id', $student->id)
            ->whereDate('date', now())
            ->exists();

        if ($alreadyPresent) {
            Notification::make()
                ->title('Sudah Absen')
                ->body("{$student->name} sudah absen hari ini.")
                ->warning()
                ->send();
                
            $this->nisn_input = '';
            return;
        }

        // 3. Simpan Absen
        Attendance::create([
            'student_id' => $student->id,
            'date' => now(),
            'time' => now(),
            'status' => 'Hadir',
        ]);

        // 4. Notifikasi Sukses
        Notification::make()
            ->title('Berhasil Hadir')
            ->body("Selamat datang, {$student->name}.")
            ->success()
            ->send();

        // Reset input untuk scan berikutnya
        $this->nisn_input = '';
    }
}