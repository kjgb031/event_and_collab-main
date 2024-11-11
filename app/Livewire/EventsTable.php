<?php

namespace App\Livewire;

use App\Models\Event;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
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
use Filament\Tables\Table;

class EventsTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()

            )
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->weight(FontWeight::Bold)
                            ->searchable(),
                        Tables\Columns\TextColumn::make('user.organization_name')
                            ->searchable(),
                    ]),
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
                // ...
            ])
            ->actions([
                ViewAction::make()
                    ->form([
                        FileUpload::make('cover_image')
                            ->image()
                            ->required(),
                        TextInput::make('name')
                            ->required(),
                        RichEditor::make('description')
                            ->required(),
                        TextInput::make('date')
                            ->required(),
                        TextInput::make('start_time')
                            ->required(),
                        TextInput::make('end_time')
                            ->required(),
                        TextInput::make('location')
                            ->required(),
                    ]),

            ])
          
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.events-table');
    }
}
