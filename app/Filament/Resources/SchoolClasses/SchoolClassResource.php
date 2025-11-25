<?php

namespace App\Filament\Resources\SchoolClasses;

use App\Filament\Resources\SchoolClasses\Pages\CreateSchoolClass;
use App\Filament\Resources\SchoolClasses\Pages\EditSchoolClass;
use App\Filament\Resources\SchoolClasses\Pages\ListSchoolClasses;
use App\Filament\Resources\SchoolClasses\Schemas\SchoolClassForm;
use App\Filament\Resources\SchoolClasses\Tables\SchoolClassesTable;
use App\Models\SchoolClass;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form; // WAJIB: Gunakan Form (V3)

class SchoolClassResource extends Resource
{
    protected static ?string $model = SchoolClass::class;

    // PERBAIKAN 1: Ubah tipe jadi ?string dan gunakan string icon biasa
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Sekolah';
    // PERBAIKAN 2: Tambahkan Label Navigasi (Opsional, biar rapi)
    protected static ?string $navigationLabel = 'Data Kelas';

    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin';
    }

    // PERBAIKAN 3: Gunakan Form $form, bukan Schema
    public static function form(Form $form): Form
    {
        // PERBAIKAN 4: Gunakan make(), bukan configure()
        return SchoolClassForm::make($form);
    }

    public static function table(Table $table): Table
    {
        // PERBAIKAN 5: Gunakan make(), bukan configure()
        return SchoolClassesTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchoolClasses::route('/'),
            'create' => CreateSchoolClass::route('/create'),
            'edit' => EditSchoolClass::route('/{record}/edit'),
        ];
    }
}