<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab; // Import Tab
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\CreateAction;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

     public function getTitle(): string
        {
            return 'Daftar Pengguna';
        }

    public function getBreadcrumb(): string
        {
            return 'Daftar Pengguna';
        }

    protected function getHeaderActions(): array
        {
            return [
                CreateAction::make()
                    ->label('Tambah Pengguna'),
            ];
        }

    // FITUR TABS (Membuat seolah-olah 3 Halaman)
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua User'),
            
            'admin' => Tab::make('Admin')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'admin'))
                ->badge(fn () => \App\Models\User::where('role', 'admin')->count()), // Hitung jumlah

            'teacher' => Tab::make('Guru / Wali Kelas')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'teacher'))
                ->badge(fn () => \App\Models\User::where('role', 'teacher')->count()),

            'parent' => Tab::make('Orang Tua')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'parent'))
                ->badge(fn () => \App\Models\User::where('role', 'parent')->count()),
        ];
    }
}