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
use Filament\Notifications\Notification;

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
        $tempData = $this->form->getState();
        \Log::info($tempData);
        $this->user->update([
            'avatar' => $tempData['avatar'],
            'first_name' => $tempData['first_name'],
            'last_name' => $tempData['last_name'],
            'email' => $tempData['email'],
        ]);
        $this->studentData->update([
            'campus' => $tempData['campus'],
            'college' => $tempData['college'],
            'program' => $tempData['program'],
            'major' => $tempData['major'],
            'guardian_name' => $tempData['guardian_name'],
            'guardian_contact' => $tempData['guardian_contact'],
        ]);

        Notification::make()
            ->success()
            ->title('Profile Updated')
            ->body('Your profile has been updated successfully.')
            ->send();
    }
    
    public function render()
    {
        return view('livewire.student-edit-form');
    }
}
