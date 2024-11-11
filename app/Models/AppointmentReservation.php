<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_date_id',
        'user_id',
        'event_id',
        'payment_status',
        'year_and_section',
        'proof_of_payment',
        'mode_of_payment',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($appointmentReservation) {
            Notification::make()
                ->title('Appointment Reservation Created')
                ->success()
                ->body("Appointment Reservation for {$appointmentReservation->event->name} has been created.")
                ->sendToDatabase(collect([$appointmentReservation->event->user, $appointmentReservation->user]))
                ->send();
        });
    }
 


    public function markAsPaid()
    {
        $this->payment_status = 'paid';
        $this->save();

        EventRegistration::create([
            'event_id' => $this->event_id,
            'user_id' => $this->user->id,
            'status' => 'registered',
        ]);
        
    }

   

    public function appointmentDate()
    {
        return $this->belongsTo(AppointmentDate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // get event_id 
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
