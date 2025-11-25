<?php

namespace App\Filament\Resources\Attendances;

use App\Filament\Resources\Attendances\Pages;
use App\Filament\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Resources\Attendances\Tables\AttendanceTable;
use App\Models\Attendance;
use App\Models\Teacher; // Import Model Guru
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder; // Import Builder

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Absensi & Laporan';
    protected static ?string $navigationLabel = 'Laporan Absensi';

    // LOGIKA PEMBATASAN DATA (QUERY SCOPE)
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Jika yang login adalah GURU
        if ($user->role === 'teacher') {
            // Cari data Guru berdasarkan user login
            $teacher = Teacher::where('user_id', $user->id)->first();
            
            // Jika Guru punya kelas (Wali Kelas)
            if ($teacher && $teacher->schoolClass) {
                // Tampilkan HANYA absensi milik siswa di kelas guru tersebut
                return $query->whereHas('student', function ($q) use ($teacher) {
                    $q->where('school_class_id', $teacher->schoolClass->id);
                });
            }
            
            // Jika guru belum diset sebagai wali kelas, jangan tampilkan apapun
            return $query->whereRaw('1 = 0');
        }

        // Jika Admin, tampilkan semua (termasuk sorting default)
        return $query->orderBy('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return AttendanceForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return AttendanceTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}