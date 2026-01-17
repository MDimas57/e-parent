<?php

namespace App\Filament\Resources\UserResource\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class UserTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',   // Merah
                        'teacher' => 'info',   // Biru
                        'parent' => 'success', // Hijau
                    }),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Kita kosongkan filter di sini karena kita pakai TABS
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                ->before(fn ($record) =>
                    \DB::table('messages')
                        ->where('receiver_id', $record->id)
                        ->delete()
        ),
            ]);
    }
}