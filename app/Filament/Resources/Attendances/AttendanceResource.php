<?php

namespace App\Filament\Resources\Attendances;

use App\Filament\Resources\Attendances\Pages;
use App\Filament\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Resources\Attendances\Tables\AttendanceTable; // Pastikan Tanpa 's'
use App\Models\Attendance;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Absensi';

    public static function form(Form $form): Form
    {
        return AttendanceForm::make($form);
    }

    public static function table(Table $table): Table
    {
        // Pastikan memanggil AttendanceTable (Tanpa 's')
        return AttendanceTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}