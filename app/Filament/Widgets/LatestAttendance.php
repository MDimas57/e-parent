<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Attendance;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class LatestAttendance extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return in_array(Auth::user()->role, ['admin', 'teacher']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Attendance::query()
                    ->with(['student', 'student.schoolClass'])
                    ->whereDate('date', now())
                    // Filter Guru
                    ->when(Auth::user()->role === 'teacher', function ($query) {
                        $teacher = Teacher::where('user_id', Auth::id())->first();
                        if ($teacher && $teacher->schoolClass) {
                            $query->whereHas('student', fn($q) => $q->where('school_class_id', $teacher->schoolClass->id));
                        } else {
                            $query->whereRaw('1 = 0'); // Kosongkan jika guru tidak punya kelas
                        }
                    })
                    ->latest('created_at')
                    ->take(5)
            )
            ->heading('Siswa Baru Saja Absen')
            ->columns([
                Tables\Columns\TextColumn::make('time')->label('Jam')->time('H:i')->badge(),
                Tables\Columns\TextColumn::make('student.name')->label('Nama')->weight('bold'),
                Tables\Columns\TextColumn::make('student.schoolClass.name')->label('Kelas'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Hadir' => 'success',
                        'Terlambat' => 'warning',
                        'Izin' => 'info',
                        'Sakit' => 'info',
                        'Alpha' => 'danger',
                    }),
            ])
            ->paginated(false);
    }
}