<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SchoolClass;

// --- IMPORT BARU UNTUK EXCEL ---
use Filament\Tables\Actions\Action; 
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
// -------------------------------

class AttendanceTable 
{
    public static function make(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(function (Builder $query) {
                $query->whereDate('date', now());
            })
            ->columns([
                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('student.schoolClass.name')
                    ->label('Kelas')
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
                        'Hadir' => 'success',      // Hijau
                        'Terlambat' => 'warning',  // Oranye (BARU)
                        'Izin' => 'info',          // Biru
                        'Sakit' => 'info',
                        'Alpha' => 'danger',       // Merah
                        default => 'gray',
                    }),
                TextColumn::make('status_pulang')
                    ->label('Status Pulang')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Pulang' => 'success',        // Hijau
                        null, '' => 'gray',           // Belum pulang
                        default => 'warning',
                    }),

            ])
            ->filters([
                SelectFilter::make('school_class_id')
                    ->label('Filter Kelas')
                    ->options(fn () => SchoolClass::all()->pluck('name', 'id'))
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('student', function ($q) use ($data) {
                                $q->where('school_class_id', $data['value']);
                            });
                        }
                    }),
            ])
            // --- TOMBOL EXPORT ADA DI SINI ---
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export Laporan Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Dari Tanggal')
                            ->default(now()->startOfMonth()) // Default awal bulan
                            ->required(),
                        
                        DatePicker::make('end_date')
                            ->label('Sampai Tanggal')
                            ->default(now()) // Default hari ini
                            ->required(),

                        Select::make('class_id')
                            ->label('Filter Kelas (Opsional)')
                            ->options(SchoolClass::all()->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('Semua Kelas'),
                    ])
                    ->action(function (array $data) {
                        // Format Nama File: Laporan_Absensi_TGL_WAKTU.xlsx
                        $filename = 'Laporan_Absensi_' . Carbon::now()->format('Ymd_His') . '.xlsx';
                        
                        return Excel::download(
                            new AttendanceExport(
                                $data['start_date'], 
                                $data['end_date'], 
                                $data['class_id']
                            ), 
                            $filename
                        );
                    }),
            ])
            // ---------------------------------
            ->actions([
                // Action edit/delete bisa ditambahkan di sini jika mau
            ])
            ->bulkActions([
                //
            ]);
    }
}