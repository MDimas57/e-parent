<?php

namespace App\Filament\Resources\Grades\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action; // Gunakan Action generik
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\Grades\GradeResource; // Import Resource untuk generate URL
use App\Models\Grade;

class GradesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('student.schoolClass.name')
                    ->label('Kelas')
                    ->sortable(),

                // Menghitung jumlah nilai yang sudah diinput
                // Pastikan relasi 'studentGrades' sudah ada di Model Grade
                TextColumn::make('student_grades_count')
                    ->counts('studentGrades') 
                    ->label('Total Data Nilai')
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // --- TOMBOL BUKA HALAMAN KHUSUS ---
                Action::make('manage')
                    ->label('Kelola Nilai')
                    ->icon('heroicon-m-pencil-square') // Ikon Pensil
                    ->color('primary')
                    // Arahkan ke rute 'manage' yang baru kita daftarkan
                    // Kita kirim 'record' (ID nilai) agar halaman tahu siswa mana yang dimaksud
                    ->url(fn (Grade $record) => GradeResource::getUrl('manage', ['record' => $record])),
                // ----------------------------------

                // Tombol Hapus (Hanya menghapus data nilai terbaru yang tampil di row ini)
                DeleteAction::make()
                    ->label('Hapus')
                    ->color('gray'),
            ])
            ->bulkActions([
                //
            ]);
    }
}