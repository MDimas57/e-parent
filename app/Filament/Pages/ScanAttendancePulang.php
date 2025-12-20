<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Support\Facades\Log;

class ScanAttendancePulang extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-on-rectangle';
    protected static ?string $navigationLabel = 'Scan Absensi Pulang';
    protected static ?string $navigationGroup = 'Absensi & Laporan';
    protected static string $view = 'filament.pages.scan-attendance-pulang';

    public $nisn_input = '';
    public $is_modal_open = false;
    public $scanned_data = [];

    public static function canAccess(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'teacher']);
    }

    public function save($qrCode = null)
    {
        Log::info("QR Pulang: " . $qrCode);

        $nisn = $qrCode ?? $this->nisn_input;
        if (!$nisn) return;

        $this->nisn_input = $nisn;

        $student = Student::where('nisn', $nisn)->first();

        if (!$student) {
            $this->openModal(
                'error',
                'Gagal',
                "NISN {$nisn} tidak ditemukan.",
                'bg-red-100 text-red-800'
            );
            return;
        }

        // Cari absensi MASUK hari ini
        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', now())
            ->first();

        if (!$attendance) {
            $this->openModal(
                'warning',
                'Belum Absen Masuk',
                'Siswa belum melakukan absensi masuk hari ini.',
                'bg-yellow-100 text-yellow-800',
                $student
            );
            return;
        }

        if ($attendance->time_out) {
            $this->openModal(
                'warning',
                'Sudah Absen Pulang',
                'Siswa ini sudah melakukan absensi pulang.',
                'bg-yellow-100 text-yellow-800',
                $student
            );
            return;
        }

        // Simpan jam pulang
        $attendance->update([
            'time_out' => now(),
            'status_pulang' => 'Pulang',
        ]);

        $this->openModal(
            'success',
            'Berhasil Pulang',
            'Absensi pulang berhasil dicatat.',
            'bg-green-100 text-green-800',
            $student
        );
    }

    public function openModal($status, $title, $message, $color, $student = null)
    {
        $this->scanned_data = [
            'status' => $status,
            'title' => $title,
            'message' => $message,
            'color' => $color,
            'name' => $student?->name,
            'class' => $student?->schoolClass->name ?? '-',
            'time' => now()->format('H:i'),
        ];

        $this->is_modal_open = true;
    }

    public function resetScan()
    {
        $this->is_modal_open = false;
        $this->nisn_input = '';
        $this->dispatch('resume-camera');
    }
}
