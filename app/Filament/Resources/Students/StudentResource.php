<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\CreateStudent;
use App\Filament\Resources\Students\Pages\EditStudent;
use App\Filament\Resources\Students\Pages\ListStudents;
use App\Filament\Resources\Students\Schemas\StudentForm;
use App\Filament\Resources\Students\Tables\StudentsTable;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Forms\Form; // PENTING: Gunakan Form (V3)
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    // PERBAIKAN 1: Gunakan ?string dan icon biasa
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Data Siswa';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Logika: Jika yang login adalah GURU
        if ($user && $user->role === 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();
            
            if ($teacher && $teacher->schoolClass) {
                return $query->where('school_class_id', $teacher->schoolClass->id);
            }
            
            // Jika guru belum punya kelas, tidak tampilkan apa-apa
            return $query->where('id', 0);
        }

        return $query;
    }

    // PERBAIKAN 2: Gunakan Form $form, bukan Schema
    public static function form(Form $form): Form
    {
        // PERBAIKAN 3: Gunakan make(), bukan configure()
        return StudentForm::make($form);
    }

    public static function table(Table $table): Table
    {
        // PERBAIKAN 4: Gunakan make(), bukan configure()
        return StudentsTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}