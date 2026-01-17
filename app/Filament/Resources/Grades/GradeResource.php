<?php

namespace App\Filament\Resources\Grades;

use App\Filament\Resources\Grades\Pages\CreateGrade;
use App\Filament\Resources\Grades\Pages\EditGrade;
use App\Filament\Resources\Grades\Pages\ListGrades;
use App\Filament\Resources\Grades\Pages\ManageStudentGrades; // <--- PENTING: Import Halaman Baru
use App\Filament\Resources\Grades\Schemas\GradeForm;
use App\Filament\Resources\Grades\Tables\GradesTable;
use App\Models\Grade;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationGroup = 'Absensi & Laporan';
    
    protected static ?string $navigationLabel = 'Nilai Siswa';
    protected static ?string $pluralLabel = 'Nilai Siswa';
    protected static ?string $modelLabel = 'Nilai Siswa';

    // Filter Query: Agar 1 Siswa hanya muncul 1 kali di tabel (Grouping)
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                      ->from('grades')
                      ->groupBy('student_id');
            });
    }

    public static function form(Form $form): Form
    {
        return GradeForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return GradesTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGrades::route('/'),
            'create' => CreateGrade::route('/create'),
            'edit' => EditGrade::route('/{record}/edit'),

            
            // --- RUTE BARU: HALAMAN KELOLA NILAI ---
            // {record} akan membawa ID nilai untuk mengidentifikasi siswa
            'manage' => ManageStudentGrades::route('/{record}/manage'),
            // ---------------------------------------
        ];
    }
}