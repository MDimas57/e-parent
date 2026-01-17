<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Models\Teacher;

class StudentForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nisn')
                    ->label('NIS')
                    ->required()
                    ->numeric()
                    // --- VALIDASI UNIK ---
                    // Cek tabel 'students', kolom 'nisn'. 
                    // ignoreRecord: true artinya saat Edit, NISN milik sendiri tidak dianggap duplikat.
                    ->unique(table: 'students', column: 'nisn', ignoreRecord: true)
                    // Pesan error khusus (Opsional, biar lebih ramah)
                    ->validationMessages([
                        'unique' => 'NISN ini sudah terdaftar. Mohon cek kembali data siswa lain.',
                    ]),
                // ---------------------

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

                // --- LOGIKA OTOMATIS KELAS (Yang tadi) ---
                Select::make('school_class_id')
                    ->label('Kelas')
                    ->relationship('schoolClass', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->default(function () {
                        $user = auth()->user();
                        if ($user->role === 'teacher') {
                            $teacher = Teacher::where('user_id', $user->id)->first();
                            return $teacher?->schoolClass?->id;
                        }
                        return null;
                    })
                    ->disabled(fn () => auth()->user()->role === 'teacher')
                    ->dehydrated(), 
                // -----------------------------------------
            ]);
    }
}