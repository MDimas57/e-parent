<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput; // Import TextInput untuk Tahun Ajaran
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use App\Models\SchoolSetting;

class ManageSchoolSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Jam & Tahun Ajaran';
    protected static ?string $navigationGroup = 'Pengaturan Sekolah';
    protected static ?int $navigationSort = 100; // Paling bawah di sidebar

    protected static string $view = 'filament.pages.manage-school-settings';

    // Hanya Admin yang boleh mengakses halaman ini
    public static function canAccess(): bool
    {
        return auth()->user() && auth()->user()->role === 'admin';
    }

    public ?array $data = [];

    public function mount(): void
    {
        // Ambil data setting pertama, atau buat instance baru jika kosong
        $setting = SchoolSetting::firstOrNew();
        
        // Isi form dengan data dari database
        $this->form->fill([
            'school_year' => $setting->school_year ?? '2024/2025', // Default value
            'start_time' => $setting->start_time ?? '07:00:00',
            'end_time' => $setting->end_time ?? '14:00:00',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas & Waktu Operasional')
                    ->description('Atur tahun ajaran aktif dan jam masuk/pulang sekolah.')
                    ->schema([
                        // --- INPUT TAHUN AJARAN ---
                        TextInput::make('school_year')
                            ->label('Tahun Ajaran')
                            ->placeholder('Contoh: 2024/2025 Genap')
                            ->required()
                            ->columnSpanFull(), // Agar memanjang penuh
                        // --------------------------

                        // --- INPUT JAM ---
                        TimePicker::make('start_time')
                            ->label('Jam Masuk (Batas Terlambat)')
                            ->seconds(false) // Hapus detik agar lebih simpel
                            ->required(),
                        
                        TimePicker::make('end_time')
                            ->label('Jam Pulang')
                            ->seconds(false)
                            ->required(),
                    ])->columns(2), // Tata letak 2 kolom
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Simpan ke database (Update record pertama atau Create baru)
        $setting = SchoolSetting::first();
        if ($setting) {
            $setting->update($data);
        } else {
            SchoolSetting::create($data);
        }

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->success()
            ->send();
    }
}