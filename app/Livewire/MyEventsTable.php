<?php

namespace App\Livewire;

use App\Models\Event;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class MyEventsTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                ->where("user_id",auth()->id())
            )
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('cover_image')
                        ->square()
                        ->grow(false),
                    Tables\Columns\TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->searchable(),


                    Tables\Columns\TextColumn::make('date')
                        ->sortable(query: function ($query, $direction) {
                            $query->orderBy('date', $direction);
                        })
                        ->date('F j, Y'),
                    Tables\Columns\TextColumn::make('status')
                        ->badge()
                        ->colors([
                            'approved' => 'success',
                            'pending' => 'warning',
                            'rejected' => 'danger',
                        ])
                ])
            ])
            ->emptyStateHeading('No pending events found')
            ->filters([
                // filter by status
                SelectFilter::make('status')
                    ->options([
                        'approved' => 'Approved',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn($record) => route('organization.event.show', $record)),

            ])
            ->headerActions([
                CreateAction::make()
                    ->action(fn($data) => Event::propose($data))
                    ->form(Event::getForm()),
            ]);
    }
    public function render()
    {
        return view('livewire.my-events-table');
    }
}
