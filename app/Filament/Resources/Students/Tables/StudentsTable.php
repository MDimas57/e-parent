<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentsTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Siswa')
                    ->searchable(),

                TextColumn::make('schoolClass.name')
                    ->label('Kelas')
                    ->sortable(),

                // Preview QR di Tabel
                TextColumn::make('qr_code')
                    ->label('QR Code')
                    ->html()
                    ->alignCenter()
                    ->state(function ($record) {
                        if (!$record->nisn) {
                            return '-';
                        }
                        $qrData = QrCode::format('svg')->size(60)->generate($record->nisn);
                        $base64 = base64_encode($qrData);
                        
                        return '
                            <a href="data:image/svg+xml;base64,'.$base64.'" download="QR-'.$record->name.'.svg" title="Klik untuk download">
                                <img src="data:image/svg+xml;base64,' . $base64 . '" width="60" height="60" alt="QR" />
                            </a>
                        ';
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                // --- PERBAIKAN DI SINI (UBAH KE SVG) ---
                Action::make('download_qr')
                    ->label('Download QR')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($record) {
                        // Kita ubah format ke 'svg' agar tidak butuh Imagick
                        return response()->streamDownload(function () use ($record) {
                            echo QrCode::format('svg')
                                ->size(300) // Ukuran default (SVG bisa diskala sesuka hati)
                                ->generate($record->nisn);
                        }, 'QR-' . $record->name . '.svg'); // Ekstensi file .svg
                    }),
                // ---------------------------------------

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}