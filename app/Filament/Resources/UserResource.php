<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Schemas\UserForm;
use App\Filament\Resources\UserResource\Tables\UserTable;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Manajemen User';

    // Agar menu ini muncul paling bawah
    protected static ?int $navigationSort = 99; 

    public static function form(Form $form): Form
    {
        return UserForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return UserTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}