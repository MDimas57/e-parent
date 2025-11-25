<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\MessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMessage extends CreateRecord
{
    protected static string $resource = MessageResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); 
    }
}
