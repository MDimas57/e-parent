<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

// PERBAIKAN: Nama Class harus sama dengan nama file (AttendanceTable)
class AttendanceTable 
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date')
                    ->date('d F Y')
                    ->label('Tanggal')
                    ->sortable(),

                TextColumn::make('time')
                    ->time('H:i')
                    ->label('Jam'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Hadir' => 'success',
                        'Izin' => 'warning',
                        'Sakit' => 'info',
                        'Alpha' => 'danger',
                    }),
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