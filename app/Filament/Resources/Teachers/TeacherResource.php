<?php

namespace App\Filament\Resources\Teachers;

use App\Filament\Resources\Teachers\Pages\CreateTeacher;
use App\Filament\Resources\Teachers\Pages\EditTeacher;
use App\Filament\Resources\Teachers\Pages\ListTeachers;
use App\Filament\Resources\Teachers\Schemas\TeacherForm;
use App\Filament\Resources\Teachers\Tables\TeachersTable;
use App\Models\Teacher;
use Filament\Forms\Form; // PENTING: Gunakan Form (V3)
use Filament\Resources\Resource;
use Filament\Tables\Table;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    // PERBAIKAN 1: Gunakan ?string dan nama icon biasa (V3 Style)
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Data Guru';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewAny(): bool
    {
        // Hanya admin yang boleh lihat
        return auth()->user()->role === 'admin';
    }

    // PERBAIKAN 2: Gunakan (Form $form): Form
    public static function form(Form $form): Form
    {
        // PERBAIKAN 3: Gunakan make(), bukan configure()
        return TeacherForm::make($form);
    }

    public static function table(Table $table): Table
    {
        // PERBAIKAN 4: Gunakan make(), bukan configure()
        return TeachersTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeachers::route('/'),
            'create' => CreateTeacher::route('/create'),
            'edit' => EditTeacher::route('/{record}/edit'),
        ];
    }
}