<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'event_type',
        'start_time',
        'end_time',
        'location',
        'status',
        'cover_image',
        'user_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function approve()
    {
        Notification::make()
            ->title('Event Approved')
            ->success()
            ->body("{$this->name} has been approved.")
            ->sendToDatabase($this->user)
            ->send();

        

        $this->update([
            'status' => 'approved',
        ]);
    }

    public function reject()
    {
        Notification::make()
            ->title('Event Rejected')
            ->danger()
            ->body("{$this->name} has been rejected.")
            ->sendToDatabase($this->user)
            ->send();

        $this->update([
            'status' => 'rejected',
        ]);
    }

    public static function propose($data){
        // make a data with pending status
        $data['status'] = 'pending';
        $data['user_id'] = auth()->id();
        // save the data
        $event = Event::create($data);
        // send notification to admin
        Notification::make()
            ->title('Event Proposed')
            ->info()
            ->body("{$event->name} has been proposed.")
            ->sendToDatabase(User::where('role', 'admin')->get())
            ->send();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointmentDates()
    {
        return $this->hasMany(AppointmentDate::class);
    }
  
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function appointmentReservations()
    {
        return $this->hasMany(AppointmentReservation::class);
    }
}
