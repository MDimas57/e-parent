<?php

namespace App\Filament\Resources\Messages\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MessagesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sender.name')
                    ->label('Pengirim')
                    ->description(fn ($record) => $record->sender_id === auth()->id() ? '(Saya)' : '')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('receiver.name')
                    ->label('Penerima')
                    ->description(fn ($record) => $record->receiver_id === auth()->id() ? '(Saya)' : '')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('content')
                    ->label('Isi Pesan')
                    ->limit(50)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}