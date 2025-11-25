<?php

namespace App\Filament\Resources\Grades;

use App\Filament\Resources\Grades\Pages\CreateGrade;
use App\Filament\Resources\Grades\Pages\EditGrade;
use App\Filament\Resources\Grades\Pages\ListGrades;
use App\Filament\Resources\Grades\Schemas\GradeForm;
use App\Filament\Resources\Grades\Tables\GradesTable;
use App\Models\Grade;
use Filament\Forms\Form; // PENTING: Gunakan Form, bukan Schema
use Filament\Resources\Resource;
use Filament\Tables\Table;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    // Gunakan string biasa agar aman dan tidak error tipe data
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Absensi & Laporan';
    protected static ?string $navigationLabel = 'Nilai Siswa';

    // PERBAIKAN 1: Gunakan (Form $form): Form
    public static function form(Form $form): Form
    {
        // PERBAIKAN 2: Gunakan make(), bukan configure()
        return GradeForm::make($form);
    }

    public static function table(Table $table): Table
    {
        // PERBAIKAN 3: Gunakan make(), bukan configure()
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
        ];
    }
}