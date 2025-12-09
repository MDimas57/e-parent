<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    public function getTitle(): string
        {
            return 'Daftar Guru';
        }

    public function getBreadcrumb(): string
        {
            return 'Daftar Guru';
        }

    protected function getHeaderActions(): array
        {
            return [
                CreateAction::make()
                    ->label('Tambah Guru'),
            ];
        }
}
