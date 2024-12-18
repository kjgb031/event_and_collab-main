<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    const QUESTIONS = [
        'question_01' => 'How did you hear about this event?',
        'question_02' => 'What did you like about this event?',
        'question_03' => 'What did you dislike about this event?',
        'question_04' => 'What would you like to see in future events?',
        'question_05' => 'Would you recommend this event to a friend?',
    ];

    protected $fillable = [
        'user_id',
        'event_id',
        'question_01',
        'question_02',
        'question_03',
        'question_04',
        'question_05',
        'comment',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($feedback) {
            $feedback->comment = \ConsoleTVs\Profanity\Builder::blocker($feedback->comment)->filter();
            // filter all questions
            foreach (self::QUESTIONS as $key => $question) {
                $feedback->$key = \ConsoleTVs\Profanity\Builder::blocker($feedback->$key)->filter();
            }
        });

        static::created(function ($feedback) {
            Notification::make()
                ->body('Feedback received for ' . $feedback->event->name)
                ->title('Feedback Received')
                ->info()
                ->send()
                ->sendToDatabase(collect([$feedback->event->user, $feedback->user]));
        });
    }

    public static function getForm(): array
    {
        return [
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
        ];
    }

    public function getQuestion($question)
    {
        return self::QUESTIONS[$question];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
