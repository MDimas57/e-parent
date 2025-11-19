<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;

class TeacherForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->unique(ignoreRecord: true) // Cek unik kecuali punya sendiri saat edit
                    ->numeric(),
            
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}