<?php

namespace App\Livewire;

use App\Models\AppointmentDate;
use App\Models\AppointmentReservation;
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

    public $event;

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
            ->modalContent(view('modal.show-ticket', ['uid' => auth()->user()->eventRegistrations->where('event_id', $this->event->id)->first()->uid]));
    }

    public function giveFeedbackAction(): Action
    {
        return Action::make('giveFeedback')
            ->label('Give Feedback')
            ->icon('heroicon-o-chat-bubble-bottom-center-text')
            ->disabled(fn() => !auth()->user()->hasAttended($this->event) || auth()->user()->hasGivenFeedback($this->event))
            ->form([
                TextInput::make('question_01')
                    ->label(Feedback::QUESTIONS['question_01'])
                    ->required(),
                TextInput::make('question_02')
                    ->label(Feedback::QUESTIONS['question_02'])
                    ->required(),
                TextInput::make('question_03')
                    ->label(Feedback::QUESTIONS['question_03'])
                    ->required(),
                TextInput::make('question_04')
                    ->label(Feedback::QUESTIONS['question_04'])
                    ->required(),
                Select::make('question_05')
                    ->label(Feedback::QUESTIONS['question_05'])
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',
                    ])
                    ->required(),
                TextInput::make('comment')
                    ->label('Additional Comments')
            ])
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
            ->label('Reserve')
            ->disabled(fn() => auth()->user()->isReserved($this->event))
            ->icon('heroicon-o-calendar')
            ->form([
                Select::make('mode_of_payment')
                    ->label('Mode of Payment')
                    ->options([
                        'online' => 'Online',
                        'onsite' => 'Onsite',
                    ])
                    ->live()
                    ->required(),
                Select::make('appointment_date_id')
                    ->label('Appointment Date')
                    ->relationship(name: 'appointmentDate', modifyQueryUsing: function ($query) {
                        return $query->where('status', 'pending');
                    })
                    ->getOptionLabelFromRecordUsing(
                        function (AppointmentDate $record) {
                            return $record->date->format('M d, Y') . ' ' . $record->start_time . ' - ' . $record->end_time;
                        }
                    )
                    ->required()
                    ->visible(fn(Get $get) => $get('mode_of_payment') === 'onsite'),
                TextInput::make('year_and_section')
                    ->label('Year and Section')
                    ->required(),
                FileUpload::make('proof_of_payment')
                    ->label('Proof of Payment')
                    ->visible(fn(Get $get) => $get('mode_of_payment') === 'online')
                    ->required(),
            ])
            ->action(function ($data) {
                $data['user_id'] = auth()->id();
                $data['event_id'] = $this->event->id;
                $data['payment_status'] = 'pending';
                AppointmentReservation::create($data);
            })
            ->model(AppointmentReservation::class);
    }


    public function render()
    {
        return view('livewire.event-action-buttons');
    }
}
