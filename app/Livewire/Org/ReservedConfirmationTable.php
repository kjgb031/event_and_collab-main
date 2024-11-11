<?php

namespace App\Livewire\Org;

use App\Models\AppointmentReservation;
use App\Models\Event;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ReservedConfirmationTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function table($table)
    {
        return $table
            ->query(
                AppointmentReservation::query()
                    ->where('event_id', $this->event->id)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mode_of_payment')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'online' => 'success',
                        'onsite' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('appointmentDate.date')
                    ->default("Not Set")
                    ->formatStateUsing(fn($record) => $record->appointmentDate ? $record->appointmentDate->date->format('M d, Y') : 'Not Set')
            ])
            ->filters([
                SelectFilter::make('mode_of_payment')
                    ->options([
                        'online' => 'Online',
                        'onsite' => 'Onsite',
                    ]),
                SelectFilter::make('payment_status')
                    ->options([
                        'paid' => 'Paid',
                        'pending' => 'Pending',
                    ]),
                SelectFilter::make('appointmentDate')
                    ->relationship('appointmentDate', 'date')
                    
            ])
            ->persistFiltersInSession()
            ->heading(
                "Reservations"
            )
            ->actions([
                ActionGroup::make([
                    // if online show proof of payment
                    Action::make('proof_of_payment')
                        ->url(fn($record) => Storage::url($record->proof_of_payment), true)
                        ->visible(fn($record) => $record->mode_of_payment === 'online'),
                    // mark as paid
                    Action::make('mark_as_paid')
                        ->requiresConfirmation()
                        ->action(fn($record) => $record->markAsPaid())
                        ->visible(fn($record) => $record->payment_status === 'pending')
                ])
            ]);
    }


    public function render()
    {
        return view('livewire.org.reserved-confirmation-table');
    }
}
