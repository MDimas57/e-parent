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

                TextInput::make('subject')
                    ->label('Mata Pelajaran')
                    ->placeholder('Contoh: Matematika / Rata-rata')
                    ->required(),

                TextInput::make('score')
                    ->label('Nilai (Angka)')
                    ->numeric()
                    ->maxValue(100)
                    ->minValue(0)
                    ->required(),

                Textarea::make('description')
                    ->label('Catatan Guru')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}