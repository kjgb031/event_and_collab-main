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
use Filament\Notifications\Notification;
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
            ->disabled(fn() => !auth()->user()->canSeeTicket($this->event))
            ->icon('heroicon-o-ticket')
            ->modalContent(view('modal.show-ticket', ['uid' => optional(auth()->user()->eventRegistrations->where('event_id', $this->event->id)->first())->uid ?? 0]));
    }

    public function giveFeedbackAction(): Action
    {
        return Action::make('giveFeedback')
            ->label('Give Feedback')
            ->icon('heroicon-o-chat-bubble-bottom-center-text')
            ->disabled(fn() => !$this->event->userCanFeedback(auth()->user()))
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
            ->disabled(fn() => User::find(auth()->id())->isReserved($this->event) || $this->event->isFull() || $this->event->isOver())
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

    public function uploadProofOfAttendance(): Action
    {
        return Action::make('uploadProofOfAttendance')
            ->label('Upload Proof of Attendance')
            ->icon('heroicon-o-document')
            ->form([
                FileUpload::make('proof_of_attendance')
                    ->label('Proof of Attendance')
                    ->image()
                    ->required(),
            ])
            ->disabled(fn() => !auth()->user()->hasAttended($this->event) || auth()->user()->haveProofOfAttendance($this->event))
            ->action(function ($data) {
                $eventRegistration = EventRegistration::where('user_id', auth()->id())->where('event_id', $this->event->id)->first();
                $eventRegistration->proof_of_attendance = $data['proof_of_attendance'];
                $eventRegistration->save();

                Notification::make()
                    ->title('Proof of Attendance Uploaded')
                    ->success()
                    ->body("Proof of Attendance for {$this->event->name} has been uploaded.")
                    ->sendToDatabase(auth()->user())
                    ->send();
            })
            ->fillForm(function () {
                return [
                    'proof_of_attendance' => $this->event->proof_of_attendance,
                ];
            })
            ->model(EventRegistration::class);
    }

    public function render()
    {
        return view('livewire.event-action-buttons');
    }
}
