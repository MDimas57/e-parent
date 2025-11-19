<?php

namespace App\Filament\Resources\SchoolClasses\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class SchoolClassForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Kelas')
                    ->required()
                    ->maxLength(255),

                Select::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->preload(),
            ]);
    }
}