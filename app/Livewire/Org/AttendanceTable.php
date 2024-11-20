<?php

namespace App\Livewire\Org;

use App\Models\Event;
use App\Models\EventRegistration;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class AttendanceTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(
                EventRegistration::query()
                    ->where('event_id', $this->event->id)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                TextColumn::make('uid')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        EventRegistration::STATUSES['rejected'] => 'danger',
                        EventRegistration::STATUSES['pending'] => 'warning',
                        EventRegistration::STATUSES['reserved'] => 'success',
                        EventRegistration::STATUSES['attended'] => 'secondary',
                        default => 'primary',
                    })
            ])
            ->heading('Registrations')
            ->filters([
                // with attended status
                SelectFilter::make('status')
                    ->options(EventRegistration::STATUSES)
            ])
            ->persistFiltersInSession()
            ->actions([
                ActionGroup::make([
                    // if online show proof of payment
                    Action::make('proof_of_payment')
                        ->icon('heroicon-o-document')
                        ->visible(fn($record) => $this->event->is_paid)
                        ->url(fn($record) => Storage::url($record->proof_of_payment), true),
                    //  show consent form
                    Action::make('consent_form')
                        ->icon('heroicon-o-document')
                        ->url(fn($record) => Storage::url($record->consent_form), true),
                    // mark as paid
                    Action::make('mark_as_paid')
                        ->requiresConfirmation()
                        ->action(fn($record) => $record->markAsPaid())
                        ->icon('heroicon-o-check-circle')
                        ->visible(fn($record) => $record->status === EventRegistration::STATUSES['pending']),
                    Action::make('mark_as_attended')
                        ->label('Mark as Attended')
                        ->requiresConfirmation()
                        ->icon('heroicon-o-check-circle')
                        ->action(fn(EventRegistration $record) => $record->markAsAttended())
                        ->visible(fn(EventRegistration $record) => $record->status === EventRegistration::STATUSES['reserved']),
                    // show proof of attendance if not null
                    Action::make('proof_of_attendance')
                        ->icon('heroicon-o-document')
                        ->visible(fn($record) => $record-> proof_of_attendance !== null)
                        ->url(fn($record) => Storage::url($record->proof_of_attendance), true),
                ]),
            ]);
    }

    public function render()
    {
        return view('livewire.org.attendance-table');
    }
}
