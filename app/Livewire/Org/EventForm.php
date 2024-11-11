<?php

namespace App\Livewire\Org;

use App\Models\Event;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Component;

class EventForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Event $event;

    public function mount(Event $event)
    {
        $this->form->fill($event->toArray());
        $this->event = $event;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->required(),
                Forms\Components\Datepicker::make('date')
                    ->required(),
                Forms\Components\Timepicker::make('start_time')
                    ->required(),
                Forms\Components\Timepicker::make('end_time')
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function update(): void
    {
        $data = $this->form->getState();

        $event = Event::find($this->event->id);
        $event->update($data);

        Notification::make()
            ->title('Event Updated')
            ->success()
            ->body("{$this->event->name} has been updated.")
            ->sendToDatabase($this->event->user)
            ->send();
    }

    public function render()
    {
        return view('livewire.org.event-form');
    }
}
