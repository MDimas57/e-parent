<?php

namespace App\Filament\Resources\Grades\Pages;

use App\Filament\Resources\Grades\GradeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGrades extends ListRecords
{
    protected static string $resource = GradeResource::class;

    public function getTitle(): string
    {
        return 'Daftar Nilai';
    }

    public function getBreadcrumb(): string
    {
        return 'Daftar Nilai';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Nilai'),
        ];
    }
}
