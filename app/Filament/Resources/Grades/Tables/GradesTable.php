<?php

namespace App\Filament\Resources\Grades\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class GradesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Mata Pelajaran / Keterangan')
                    ->searchable(),

                TextColumn::make('score')
                    ->label('Nilai')
                    ->sortable()
                    ->numeric(),
                    
                TextColumn::make('description')
                    ->label('Catatan')
                    ->limit(30),
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