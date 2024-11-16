<?php

namespace App\Livewire;

use App\Models\AppointmentDate;
use App\Models\AppointmentReservation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Feedback;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Livewire\Component;

class EventActionButtons extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Event $event;

    public function mount($event)
    {
        $this->event = $event;
    }

    public function showTicketAction(): Action
    {
        return Action::make('showTicket')
            ->label('Show Ticket ID')
            ->modalSubmitAction(false)
            ->disabled(fn() => !auth()->user()->isReservationConfirmed($this->event))
            ->icon('heroicon-o-ticket')
            ->modalContent(view('modal.show-ticket', ['uid' => optional(auth()->user()->eventRegistrations->where('event_id', $this->event->id)->first())->uid ?? 0]));
    }

    public function giveFeedbackAction(): Action
    {
        return Action::make('giveFeedback')
            ->label('Give Feedback')
            ->icon('heroicon-o-chat-bubble-bottom-center-text')
            ->disabled(fn() => !auth()->user()->hasAttended($this->event) || auth()->user()->hasGivenFeedback($this->event))
            ->form(Feedback::getForm())
            ->action(function ($data) {
                $data['user_id'] = auth()->id();
                $data['event_id'] = $this->event->id;
                Feedback::create($data);
            })
            ->model(Feedback::class);
    }

    public function reserveAction(): Action
    {
        return Action::make('reserve')
            ->label($this->event->getEventButtonLabel())
            ->disabled(fn() => User::find(auth()->id())->isReserved($this->event) || $this->event->isFull())
            ->icon('heroicon-o-calendar')
            ->form([
                FileUpload::make('proof_of_payment')
                    ->label('Proof of Payment')
                    ->image()
                    ->visible(fn() => $this->event->is_paid)
                    ->required(),
                FileUpload::make('consent_form')
                    ->label('Consent Form')
                    ->acceptedFileTypes(
                        ['application/pdf', 'image/*']
                    )
                    ->required(),
            ])
            ->action(function ($data) {
                $data['user_id'] = auth()->id();
                $data['event_id'] = $this->event->id;
                $data['status'] = $this->event->is_paid ? EventRegistration::STATUSES['pending'] : EventRegistration::STATUSES['reserved'];
                EventRegistration::create($data);
            })
            ->model(EventRegistration::class);
    }


    public function render()
    {
        return view('livewire.event-action-buttons');
    }
}
