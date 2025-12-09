<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;

class AttendanceForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('date')
                    ->label('Tanggal')
                    ->default(now())
                    ->required(),

                TimePicker::make('time')
                    ->label('Jam')
                    ->default(now())
                    ->required(),

                Select::make('status')
                    ->label('Status Kehadiran')
                    ->options([
                        'Izin' => 'Izin',
                        'Sakit' => 'Sakit',
                        'Alpha' => 'Alpha',
                    ])
                    ->default('Sakit')
                    ->required(),
            ]);
    }
}