<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Attendance;
use App\Models\Teacher;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\Auth;

class AttendanceChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    // Judul Grafik Dinamis
    public function getHeading(): string
    {
        return Auth::user()->role === 'teacher' 
            ? 'Tren Kehadiran Kelas Saya (7 Hari)' 
            : 'Tren Kehadiran Sekolah (7 Hari)';
    }

    public static function canView(): bool
    {
        return in_array(Auth::user()->role, ['admin', 'teacher']);
    }

    protected function getData(): array
    {
        $user = Auth::user();
        $query = Attendance::query()->whereIn('status', ['Hadir', 'Terlambat']);

        // --- FILTER KHUSUS GURU ---
        if ($user->role === 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if ($teacher && $teacher->schoolClass) {
                // Filter hanya siswa di kelas guru tersebut
                $query->whereHas('student', function ($q) use ($teacher) {
                    $q->where('school_class_id', $teacher->schoolClass->id);
                });
            } else {
                // Guru tanpa kelas, return data kosong agar tidak error
                return ['datasets' => [], 'labels' => []];
            }
        }

        // Ambil Data Tren
        $data = Trend::query($query)
            ->dateColumn('date') // <--- PERBAIKAN: Gunakan kolom 'date' asli, bukan created_at
            ->between(
                start: now()->subDays(6),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Siswa Hadir',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => $user->role === 'teacher' ? '#3b82f6' : '#10b981', // Biru utk Guru, Hijau utk Admin
                    'backgroundColor' => $user->role === 'teacher' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}