<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class TeachersTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Guru')
                    ->searchable()
                    ->sortable(),

                // Logika Badge Wali Kelas sesuai permintaan Anda
                TextColumn::make('schoolClass.name') 
                    ->label('Wali Kelas')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->default('Bukan Wali Kelas'),
            ])
            ->filters([
                //
            ])
   
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
   
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}