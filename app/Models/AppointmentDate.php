<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'capacity',
        'status',
        'event_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

   

    public function getCurrentCapacityAttribute()
    {
        return $this->appointmentReservations->where('status', '!=', 'cancelled')->count();
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function appointmentReservations()
    {
        return $this->hasMany(AppointmentReservation::class);
    }
}
