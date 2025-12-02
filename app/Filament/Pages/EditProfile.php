<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard; 
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends BaseEditProfile
{
    // --- LOGIKA PEMBATASAN AKSES ---
    // Hanya Admin dan Guru yang bisa mengakses halaman ini.
    // Orang Tua akan otomatis tidak melihat menu "Profile".
    public static function canAccess(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'teacher']);
    }
    // -------------------------------

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email Login')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Password Baru')
                    ->password()
                    ->revealable()
                    ->rule(Password::default())
                    ->autocomplete('new-password')
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->same('passwordConfirmation')
                    ->helperText('Kosongkan jika tidak ingin mengubah password.'),

                TextInput::make('passwordConfirmation')
                    ->label('Ulangi Password Baru')
                    ->password()
                    ->revealable()
                    ->dehydrated(false),
            ]);
    }

    protected function getRedirectUrl(): ?string
    {
        return Dashboard::getUrl();
    }
}