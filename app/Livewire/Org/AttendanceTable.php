<?php

namespace App\Livewire\Org;

use App\Models\Event;
use App\Models\EventRegistration;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
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
                        'attended' => 'success',
                        'registered' => 'warning',
                        default => 'gray',
                    })
            ])
            ->heading('Attendance Confirmations')
            ->filters([
                // with attended status
                SelectFilter::make('status')
                    ->options([
                        'attended' => 'Attended',
                        'registered' => 'Registered',
                    ])
            ])
            ->persistFiltersInSession()
            ->actions([
                Action::make('mark_as_attended')
                    ->label('Mark as Attended')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle')
                    ->action(fn(EventRegistration $record) => $record->markAsAttended())
                    ->visible(fn(EventRegistration $record) => $record->status === 'registered'),
            ]);
    }

    public function render()
    {
        return view('livewire.org.attendance-table');
    }
}
