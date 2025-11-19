<?php

namespace App\Filament\Resources\SchoolClasses\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class SchoolClassesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('teacher.name')
                    ->label('Wali Kelas')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}