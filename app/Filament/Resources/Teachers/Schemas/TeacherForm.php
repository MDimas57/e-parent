<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class TeacherForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->numeric(),
            
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                // --- INPUT PHONE SAJA ---
                TextInput::make('phone')
                    ->label('No. Telepon / WA')
                    ->tel()
                    ->required(),
                // ------------------------
            ]);
    }
}