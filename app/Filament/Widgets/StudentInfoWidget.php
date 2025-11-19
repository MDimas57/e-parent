<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Grade;

class StudentInfoWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    // PERBAIKAN: Tambahkan "static" sesuai permintaan error log
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $user = auth()->user();

        if ($user->role !== 'parent') {
            return [];
        }

        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return [
                Stat::make('Status Akun', 'Belum Terhubung')
                    ->description('Hubungi Admin Sekolah')
                    ->color('danger'),
            ];
        }

        $todayAbsence = Attendance::where('student_id', $student->id)
                        ->whereDate('date', now())
                        ->first();
        
        $statusHadir = $todayAbsence ? $todayAbsence->status : 'Belum Absen';
        
        $colorHadir = match($statusHadir) {
            'Hadir' => 'success',
            'Izin' => 'warning',
            'Sakit' => 'info', 
            default => 'danger',
        };

        $lastGrade = Grade::where('student_id', $student->id)->latest()->first();
        $nilaiScore = $lastGrade ? $lastGrade->score : 0;
        $nilaiMapel = $lastGrade ? $lastGrade->subject : 'Belum ada data';

        return [
            Stat::make('Nama Siswa', $student->name)
                ->description('NISN: ' . $student->nisn)
                ->icon('heroicon-m-user')
                ->color('primary'),

            Stat::make('Absensi Hari Ini', $statusHadir)
                ->description($todayAbsence ? substr($todayAbsence->time, 0, 5) : '--:--')
                ->icon('heroicon-m-clock')
                ->color($colorHadir),

            Stat::make('Nilai Terakhir', $nilaiScore)
                ->description($nilaiMapel)
                ->icon('heroicon-m-academic-cap')
                ->color('warning'),
        ];
    }
}