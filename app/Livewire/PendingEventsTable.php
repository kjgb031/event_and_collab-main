<?php

namespace App\Livewire;

use App\Models\Event;
use Faker\Core\File;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Contracts\View\View;

class PendingEventsTable  extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;




    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                    ->where('status', 'pending')
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
                ])
            ])
            ->emptyStateHeading('No pending events found')
            ->filters([
                // ...
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    ViewAction::make()
                        ->form([
                            FileUpload::make('cover_image')
                                ->image(),
                            TextInput::make('name'),
                            TextInput::make('description'),
                            TextInput::make('date'),
                            TextInput::make('start_time'),
                            TextInput::make('end_time'),
                            TextInput::make('location'),
                        ]),



                    Tables\Actions\Action::make('approve')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Event $record) {
                            $record->approve();
                            $this->resetTable();
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\Action::make('reject')
                        ->icon('heroicon-o-x-circle')
                        ->action(function (Event $record) {
                            $record->reject();
                            $this->resetTable();
                        })
                        ->requiresConfirmation(),
                ])
            ])
            ->bulkActions([
                // ...
            ]);
    }


    public function render()
    {
        return view('livewire.pending-events-table');
    }
}
