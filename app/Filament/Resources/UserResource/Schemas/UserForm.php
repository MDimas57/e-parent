<?php

namespace App\Filament\Resources\UserResource\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama User')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email Login')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Select::make('role')
                    ->label('Role / Jabatan')
                    ->options([
                        'admin' => 'Admin',
                        'teacher' => 'Guru / Wali Kelas',
                        'parent' => 'Orang Tua / Wali Murid',
                    ])
                    ->required(),

                // Field Password dengan logika khusus:
                // Hanya di-hash jika diisi. Jika kosong saat edit, password tidak berubah.
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state)) // Hanya simpan jika diisi
                    ->required(fn (string $context): bool => $context === 'create') // Wajib hanya saat create
                    ->maxLength(255),
            ]);
    }
}