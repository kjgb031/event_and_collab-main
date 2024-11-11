<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'uid',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($eventRegistration) {
            $eventRegistration->uid = uniqid();
        });
    }

    public function markAsAttended()
    {
        $this->status = 'attended';
        $this->save();

        Notification::make()
            ->title('Event Registration Marked as Attended')
            ->success()
            ->body("Event Registration for {$this->event->name} has been marked as attended.")
            ->sendToDatabase($this->user)
            ->send();
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
