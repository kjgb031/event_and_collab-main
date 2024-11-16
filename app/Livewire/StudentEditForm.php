<?php

namespace App\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Forms\Components\FileUpload;
use App\Models\User;
use App\Models\StudentData;

class StudentEditForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $user;
    public $studentData;

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->studentData = $this->user->studentData;
        $this->form->fill([
            'avatar' => $this->user->avatar,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'campus' => $this->studentData->campus,
            'college' => $this->studentData->college,
            'program' => $this->studentData->program,
            'major' => $this->studentData->major,
            'guardian_name' => $this->studentData->guardian_name,
            'guardian_contact' => $this->studentData->guardian_contact,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('avatar'),
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('campus')->required(),
                TextInput::make('college')->required(),
                TextInput::make('program')->required(),
                TextInput::make('major')->required(),
                TextInput::make('guardian_name')->required(),
                TextInput::make('guardian_contact')->required(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function create(): void
    {
        $this->validate();
        $this->user->update([
            'avatar' => $this->data['avatar'],
            'first_name' => $this->data['first_name'],
            'last_name' => $this->data['last_name'],
            'email' => $this->data['email'],
        ]);
        $this->studentData->update([
            'campus' => $this->data['campus'],
            'college' => $this->data['college'],
            'program' => $this->data['program'],
            'major' => $this->data['major'],
            'guardian_name' => $this->data['guardian_name'],
            'guardian_contact' => $this->data['guardian_contact'],
        ]);
    }
    
    public function render()
    {
        return view('livewire.student-edit-form');
    }
}
