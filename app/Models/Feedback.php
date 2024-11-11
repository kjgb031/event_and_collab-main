<?php

namespace App\Models;

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

        static::created(function ($feedback) {
            Notification::make()
                ->body('Feedback received for ' . $feedback->event->name)
                ->title('Feedback Received')
                ->info()
                ->send()
                ->sendToDatabase(collect([$feedback->event->user, $feedback->user]));
        });
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
