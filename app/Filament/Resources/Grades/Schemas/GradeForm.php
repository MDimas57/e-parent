<?php

namespace App\Filament\Resources\Grades\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class GradeForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->label('Siswa')
                    ->searchable()
                    ->preload()
                    ->required(),

                // --- PERUBAHAN DI SINI ---
                // Mengubah input teks biasa menjadi Dropdown Semester
                // Kita tetap gunakan kolom database 'subject' agar tidak perlu migrasi ulang
                Select::make('subject')
                    ->label('Semester')
                    ->options([
                        'Semester 1' => 'Semester 1',
                        'Semester 2' => 'Semester 2',
                        'Semester 3' => 'Semester 3',
                        'Semester 4' => 'Semester 4',
                        'Semester 5' => 'Semester 5',
                    ])
                    ->required(),
                // -------------------------

                TextInput::make('score')
                    ->label('Nilai Rata-rata')
                    ->numeric()
                    ->maxValue(100)
                    ->minValue(0)
                    ->required(),
            ]);
    }
}