<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\MessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMessages extends ListRecords
{
    protected static string $resource = MessageResource::class;

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
