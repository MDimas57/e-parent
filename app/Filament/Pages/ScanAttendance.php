<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk cek log

class ScanAttendance extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $navigationLabel = 'Scan Absensi';
    protected static string $view = 'filament.pages.scan-attendance';

    public $nisn_input = '';
    
    // Variabel Modal
    public $is_modal_open = false;
    public $scanned_data = [];

    public static function canAccess(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'teacher']);
    }

    // Fungsi Save menerima parameter QR
    public function save($qrCode = null)
    {
        // LOGGING: Cek di storage/logs/laravel.log
        Log::info("Menerima data QR: " . $qrCode);

        $nisn = $qrCode ?? $this->nisn_input;

        if (empty($nisn)) {
            return;
        }

        $this->nisn_input = $nisn;
        
        $student = Student::where('nisn', $nisn)->first();

        if (!$student) {
            $this->openModal('error', 'Gagal', "NISN {$nisn} tidak ditemukan.", 'bg-red-100 text-red-800');
            return;
        }

        $alreadyPresent = Attendance::where('student_id', $student->id)
            ->whereDate('date', now())
            ->exists();

        if ($alreadyPresent) {
            $this->openModal(
                'warning', 
                'Sudah Absen', 
                'Siswa ini sudah absen hari ini.', 
                'bg-yellow-100 text-yellow-800',
                $student
            );
            return;
        }

// --- LOGIKA CEK TERLAMBAT ---
        $setting = \App\Models\SchoolSetting::first();
        
        // Ambil Jam Masuk dari setting, default 07:00 jika belum diset
        $jamMasuk = $setting ? $setting->start_time : '07:00:00';
        
        // Cek apakah Jam Sekarang > Jam Masuk?
        $statusKehadiran = now()->format('H:i:s') > $jamMasuk ? 'Terlambat' : 'Hadir';
        // -----------------------------

        Attendance::create([
            'student_id' => $student->id,
            'date' => now(),
            'time' => now(),
            'status' => $statusKehadiran, // Gunakan status dinamis
        ]);

        // Tentukan warna dan pesan modal berdasarkan status
        $modalTitle = $statusKehadiran == 'Terlambat' ? 'Hadir (Terlambat)' : 'Berhasil Hadir';
        $modalColor = $statusKehadiran == 'Terlambat' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800';

        $this->openModal(
            'success', 
            $modalTitle, 
            'Absensi berhasil dicatat.', 
            $modalColor,
            $student
        );
    }

    // Helper untuk buka modal agar kodingan rapi
    public function openModal($status, $title, $message, $color, $student = null)
    {
        $this->scanned_data = [
            'status' => $status,
            'title' => $title,
            'message' => $message,
            'color' => $color,
            'name' => $student ? $student->name : null,
            'class' => $student ? ($student->schoolClass->name ?? '-') : null,
            'time' => now()->format('H:i'),
        ];
        $this->is_modal_open = true;
    }

    public function resetScan()
    {
        $this->is_modal_open = false;
        $this->nisn_input = '';
        // Kita kirim event ke JS untuk mulai scan lagi
        $this->dispatch('resume-camera'); 
    }
}