<?php

namespace App\Livewire\Org;

use App\Models\AppointmentDate;
use App\Models\Event;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\SelectColumn;
use Livewire\Component;

class AppointmentsTable extends Component implements HasForms, HasTable
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
                AppointmentDate::query()
                    ->where('event_id', $this->event->id)
            )
            ->columns([
                Split::make([
                    TextColumn::make('date')
                        ->label('Date')
                        ->sortable()
                        ->date('F j, Y'),
                    Stack::make([
                        TextColumn::make('start_time')
                            ->label('Start Time')
                            ->date('h:i A'),
                        TextColumn::make('end_time')
                            ->label('End Time')
                            ->date('h:i A'),
                    ]),
                    SelectColumn::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'closed' => 'Closed',
                        ])

                ])
            ])
            ->filters([
                // ...
            ])
            ->actions([

                DeleteAction::make()
                    ->modalDescription('Are you sure you want to delete this appointment date? Reservation records will also be deleted.')

            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        Forms\Components\Datepicker::make('date')
                            ->required(),
                        Forms\Components\Timepicker::make('start_time')
                            ->required(),
                        Forms\Components\Timepicker::make('end_time')
                            ->required(),
                        Forms\Components\TextInput::make('capacity')
                            ->required()
                            ->numeric(),
                    ])
                    ->action(function ($data) {
                        $data['event_id'] = $this->event->id;
                        $data['status'] = 'pending';
                        AppointmentDate::create($data);
                    })
            ])
            ->heading(
                'Appointment Dates'
            )
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.org.appointments-table');
    }
}
