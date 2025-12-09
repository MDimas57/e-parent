<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    public function getTitle(): string
        {
            return 'Daftar Siswa';
        }

    public function getBreadcrumb(): string
        {
            return 'Daftar Siswa';
        }

    protected function getHeaderActions(): array
        {
            return [
                CreateAction::make()
                    ->label('Tambah Siswa'),
            ];
        }
}
