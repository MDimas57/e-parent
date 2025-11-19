<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;

class MessageForm
{
    public static function make(Form $form): Form
    {
        return $form->schema([
            // 1. Pengirim (Otomatis User yang Login)
            Hidden::make('sender_id')
                ->default(auth()->id()),

            // 2. Penerima (Logika Filter Guru <-> Ortu)
            Select::make('receiver_id')
                ->label('Kirim Kepada')
                ->options(function () {
                    $user = auth()->user();

                    // SKENARIO 1: Jika ORANG TUA -> Hanya bisa ke Wali Kelas
                    if ($user->role === 'parent') {
                        $student = Student::where('user_id', $user->id)->first();
                        if ($student && $student->schoolClass && $student->schoolClass->teacher) {
                            $teacherUser = $student->schoolClass->teacher->user;
                            return [$teacherUser->id => 'Wali Kelas: ' . $teacherUser->name];
                        }
                        return [];
                    }

                    // SKENARIO 2: Jika GURU -> Hanya bisa ke Wali Murid di kelasnya
                    if ($user->role === 'teacher') {
                        $teacher = Teacher::where('user_id', $user->id)->first();
                        if ($teacher && $teacher->schoolClass) {
                            return Student::where('school_class_id', $teacher->schoolClass->id)
                                ->whereNotNull('user_id')
                                ->with('user')
                                ->get()
                                ->pluck('user.name', 'user.id');
                        }
                    }

                    // SKENARIO 3: Admin -> Bebas ke siapa saja
                    return User::where('id', '!=', auth()->id())->pluck('name', 'id');
                })
                ->searchable()
                ->required(),

            // 3. Isi Pesan
            Textarea::make('content')
                ->label('Isi Pesan')
                ->required()
                ->rows(5)
                ->columnSpanFull(),
        ]);
    }
}