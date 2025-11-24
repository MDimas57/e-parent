<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Section;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Models\SchoolSetting;

class ManageSchoolSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Sekolah';
    protected static ?int $navigationSort = 100; // Paling bawah

    protected static string $view = 'filament.pages.manage-school-settings';
    public static function canAccess(): bool
    {
        // Hanya tampil jika user login DAN role-nya 'admin'
        return auth()->user() && auth()->user()->role === 'admin';
    }
    public ?array $data = [];

    public function mount(): void
    {
        // Ambil data pertama, jika tidak ada buat baru
        $setting = SchoolSetting::firstOrNew();
        $this->form->fill([
            'start_time' => $setting->start_time ?? '07:00:00',
            'end_time' => $setting->end_time ?? '14:00:00',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Aturan Jam Sekolah')
                    ->description('Tentukan batas jam masuk dan jam pulang.')
                    ->schema([
                        TimePicker::make('start_time')
                            ->label('Jam Masuk (Batas Terlambat)')
                            ->seconds(false)
                            ->required(),

                        TimePicker::make('end_time')
                            ->label('Jam Pulang')
                            ->seconds(false)
                            ->required(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Simpan ke database (Update record pertama)
        $setting = SchoolSetting::first();
        if ($setting) {
            $setting->update($data);
        } else {
            SchoolSetting::create($data);
        }

        Notification::make()
            ->title('Pengaturan Disimpan')
            ->success()
            ->send();
    }
}