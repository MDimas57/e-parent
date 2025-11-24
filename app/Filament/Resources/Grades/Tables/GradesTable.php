<?php

namespace App\Filament\Resources\Grades\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;   // Import Tombol Edit
use Filament\Tables\Actions\DeleteAction; // Import Tombol Hapus

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

                // Ubah label kolom ini jadi Semester
                TextColumn::make('subject')
                    ->label('Semester')
                    ->badge() // Opsional: Biar tampilannya seperti lencana
                    ->color('info')
                    ->searchable(),

                TextColumn::make('score')
                    ->label('Nilai')
                    ->sortable()
                    ->numeric()
                    
            ])
            ->filters([
                //
            ])
            // --- TOMBOL HAPUS DAN EDIT ADA DI SINI ---
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            // -----------------------------------------
            ->bulkActions([
                //
            ]);
    }
}