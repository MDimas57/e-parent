<?php

namespace App\Filament\Resources\Messages;

use App\Filament\Resources\Messages\Pages\CreateMessage;
use App\Filament\Resources\Messages\Pages\EditMessage;
use App\Filament\Resources\Messages\Pages\ListMessages;
use App\Filament\Resources\Messages\Schemas\MessageForm;
use App\Filament\Resources\Messages\Tables\MessagesTable;
use App\Models\Message;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    // PERBAIKAN: Ubah menjadi ?string sesuai permintaan error log
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Pesan / Chat';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function ($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'desc');
    }

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return MessageForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return MessagesTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMessages::route('/'),
            'create' => CreateMessage::route('/create'),
            'edit' => EditMessage::route('/{record}/edit'),
        ];
    }
}