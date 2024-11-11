<?php

namespace App\Livewire\Org;

use App\Models\Event;
use App\Models\Feedback;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Livewire\Component;

class FeedbackTable extends Component implements HasForms, HasTable
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
                Feedback::query()
                    ->where('event_id', $this->event->id)
            )
            ->heading('Feedbacks')
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                TextColumn::make('event.name')
                    ->label('Event')
                    ->sortable(),
                TextColumn::make('question_01')
                    ->label(Feedback::QUESTIONS['question_01']),
                TextColumn::make('question_02')
                    ->label(Feedback::QUESTIONS['question_02']),
                TextColumn::make('question_03')
                    ->label(Feedback::QUESTIONS['question_03']),
                TextColumn::make('question_04')
                    ->label(Feedback::QUESTIONS['question_04']),
                TextColumn::make('question_05')
                    ->label(Feedback::QUESTIONS['question_05']),
                TextColumn::make('comment')
                    ->label('Comment'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ViewAction::make()
                    ->form([
                        TextInput::make('user.name')
                            ->label('User'),
                        TextInput::make('event.name')
                            ->label('Event'),
                        TextInput::make('question_01')
                            ->label(Feedback::QUESTIONS['question_01']),
                        TextInput::make('question_02')
                            ->label(Feedback::QUESTIONS['question_02']),
                        TextInput::make('question_03')
                            ->label(Feedback::QUESTIONS['question_03']),
                        TextInput::make('question_04')
                            ->label(Feedback::QUESTIONS['question_04']),
                        TextInput::make('question_05')
                            ->label(Feedback::QUESTIONS['question_05']),
                        Textarea::make('comment')
                            ->label('Comment')

                    ])
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.org.feedback-table');
    }
}
