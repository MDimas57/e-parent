<?php

namespace App\Filament\Resources\Attendances\Pages;

use App\Filament\Resources\Attendances\AttendanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    public function getTitle(): string
    {
        return 'Daftar Absensi';
    }

    public function getBreadcrumb(): string
    {
        return 'Daftar Absensi';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Absensi'),
        ];
    }
}
