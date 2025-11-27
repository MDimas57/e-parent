<?php

namespace App\Filament\Resources\Grades\Pages;

// --- PERBAIKAN DI SINI (Tambahkan \Grades\) ---
use App\Filament\Resources\Grades\GradeResource;
// ----------------------------------------------

use App\Models\Grade;
use App\Models\Student;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ManageStudentGrades extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = GradeResource::class;

    protected static string $view = 'filament.resources.grades.pages.manage-student-grades';

    public $record; 
    public $student_id; 
    public $student_name; 
    public ?array $data = []; 

    public function mount($record): void
    {
        $grade = Grade::findOrFail($record);
        
        $this->student_id = $grade->student_id;
        $this->student_name = $grade->student->name;

        $this->heading = 'Kelola Nilai: ' . $this->student_name;

        $existingGrades = Grade::where('student_id', $this->student_id)->get()->toArray();

        $this->form->fill([
            'grades_data' => $existingGrades,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Daftar Nilai Siswa')
                    ->description('Silakan input atau edit nilai untuk setiap semester.')
                    ->schema([
                        Repeater::make('grades_data')
                            ->label('')
                            ->schema([
                                Hidden::make('id'),
                                
                                Select::make('subject')
                                    ->label('Semester')
                                    ->options([
                                        'Semester 1' => 'Semester 1',
                                        'Semester 2' => 'Semester 2',
                                        'Semester 3' => 'Semester 3',
                                        'Semester 4' => 'Semester 4',
                                        'Semester 5' => 'Semester 5',
                                    ])
                                    ->required()
                                    ->columnSpan(1),
                                
                                TextInput::make('score')
                                    ->label('Nilai')
                                    ->numeric()
                                    ->maxValue(100)
                                    ->required()
                                    ->columnSpan(1),
                                
                                Textarea::make('description')
                                    ->label('Catatan')
                                    ->rows(1)
                                    ->columnSpan(2),
                            ])
                            ->columns(4)
                            ->addActionLabel('Tambah Semester')
                            ->reorderable(false)
                            ->defaultItems(1)
                    ])
            ])
            ->statePath('data');
    }

    public function save()
    {
        $state = $this->form->getState();

        foreach ($state['grades_data'] as $item) {
            if (isset($item['id']) && $item['id']) {
                Grade::where('id', $item['id'])->update([
                    'subject' => $item['subject'],
                    'score' => $item['score'],
                    'description' => $item['description'],
                ]);
            } else {
                Grade::create([
                    'student_id' => $this->student_id,
                    'subject' => $item['subject'],
                    'score' => $item['score'],
                    'description' => $item['description'],
                ]);
            }
        }

        Notification::make()
            ->title('Data Nilai Berhasil Disimpan')
            ->success()
            ->send();
            
        return redirect()->to(GradeResource::getUrl('index'));
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
        ];
    }
}