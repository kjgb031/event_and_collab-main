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
            ->schema(Event::getForm())
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
