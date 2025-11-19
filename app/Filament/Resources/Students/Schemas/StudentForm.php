<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Form; // Import Wajib V3
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class StudentForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nisn')
                    ->label('NISN')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->numeric(),

                TextInput::make('name')
                    ->label('Nama Siswa')
                    ->required(),

                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),

                DatePicker::make('birthday')
                    ->label('Tanggal Lahir')
                    ->required(),

                Select::make('school_class_id')
                    ->label('Kelas')
                    ->relationship('schoolClass', 'name') // Pastikan Model Student punya relasi schoolClass()
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}