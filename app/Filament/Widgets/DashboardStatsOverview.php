<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\SchoolClass; // <--- Import Model Kelas
use Illuminate\Support\Facades\Auth;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '15s';

    public static function canView(): bool
    {
        return in_array(Auth::user()->role, ['admin', 'teacher']);
    }

    protected function getStats(): array
    {
        $user = Auth::user();

        // ==========================================
        // LOGIKA UNTUK GURU (Wali Kelas)
        // ==========================================
        if ($user->role === 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();
            
            if (!$teacher || !$teacher->schoolClass) {
                return [
                    Stat::make('Status', 'Belum Ada Kelas')
                        ->description('Hubungi Admin')
                        ->color('gray'),
                ];
            }

            $classId = $teacher->schoolClass->id;

            $totalSiswaKelas = Student::where('school_class_id', $classId)->count();
            
            $hadirKelas = Attendance::whereDate('date', now())
                ->whereHas('student', fn($q) => $q->where('school_class_id', $classId))
                ->whereIn('status', ['Hadir', 'Terlambat'])
                ->count();

            $absenKelas = Attendance::whereDate('date', now())
                ->whereHas('student', fn($q) => $q->where('school_class_id', $classId))
                ->whereIn('status', ['Sakit', 'Izin', 'Alpha'])
                ->count();

            return [
                Stat::make('Kelas Saya', $teacher->schoolClass->name)
                    ->description('Wali Kelas')
                    ->icon('heroicon-m-home')
                    ->color('primary'),

                Stat::make('Siswa Saya', $totalSiswaKelas)
                    ->description('Total Murid')
                    ->icon('heroicon-m-users')
                    ->color('info'),

                Stat::make('Hadir Hari Ini', $hadirKelas)
                    ->description('Murid Masuk')
                    ->icon('heroicon-m-check-circle')
                    ->color('success'),

                Stat::make('Tidak Hadir', $absenKelas)
                    ->description('Sakit / Izin / Alpha')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger'),
            ];
        }

        // ==========================================
        // LOGIKA UNTUK ADMIN (Global)
        // ==========================================
        
        $totalSiswa = Student::count();
        $hadirGlobal = Attendance::whereDate('date', now())
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->count();
        
        $persentase = $totalSiswa > 0 ? round(($hadirGlobal / $totalSiswa) * 100) : 0;

        return [
            Stat::make('Total Siswa', $totalSiswa)
                ->description('Seluruh Sekolah')
                ->icon('heroicon-m-academic-cap')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->color('primary'),

            Stat::make('Kehadiran Total', $hadirGlobal)
                ->description("{$persentase}% Kehadiran Hari Ini")
                ->icon('heroicon-m-chart-bar')
                ->chart([10, 10, 5, 2, 10, 15, 20])
                ->color($persentase > 80 ? 'success' : 'warning'),

            Stat::make('Total Guru', Teacher::count())
                ->description('Tenaga Pengajar')
                ->icon('heroicon-m-briefcase')
                ->color('info'),

            // --- WIDGET BARU: TOTAL KELAS ---
            Stat::make('Total Kelas', SchoolClass::count())
                ->description('Jumlah Kelas Terdaftar')
                ->icon('heroicon-m-building-library') // Icon gedung sekolah
                ->color('warning'),
        ];
    }
}