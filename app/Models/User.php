<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'first_name',
        'last_name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function lastNameFirst(): string
    {
        return $this->last_name . ', ' . $this->first_name;
    }

    public function getOrganizationNameAttribute(): string
    {
        if ($this->role !== 'organization') {
            throw new \Exception('This user is not an organization.');
        }

        return $this->first_name;
    }

    public function isReserved(Event $event): bool
    {
        if ($this->role !== 'student') {
            throw new \Exception('This user is not a student.');
        }

       
        return $this->appointmentReservations()
            ->where('event_id', $event->id)
            ->exists();
    }

    public function isReservationConfirmed(Event $event): bool
    {
        if ($this->role !== 'student') {
            throw new \Exception('This user is not a student.');
        }

        return $this->appointmentReservations()
            ->where('event_id', $event->id)
            ->where('payment_status', 'paid')
            ->exists();
    }

    public function hasAttended(Event $event): bool
    {
        if ($this->role !== 'student') {
            throw new \Exception('This user is not a student.');
        }

        return $this->eventRegistrations()
            ->where('event_id', $event->id)
            ->where('status', 'attended')
            ->exists();
    }

    public function hasGivenFeedback(Event $event): bool
    {
        if ($this->role !== 'student') {
            throw new \Exception('This user is not a student.');
        }

        return $this->feedbacks()
            ->where('event_id', $event->id)
            ->exists();
    }


    // Relations
    public function studentData()
    {
        if ($this->role !== 'student') {
            throw new \Exception('This user is not a student.');
        }

        return $this->hasOne(StudentData::class);
    }

    public function appointmentReservations()
    {
        if ($this->role !== 'student') {
            throw new \Exception('This user is not a student.');
        }

        return $this->hasMany(AppointmentReservation::class);
    }

    public function eventRegistrations()
    {
        if ($this->role !== 'student') {
            throw new \Exception('This user is not a student.');
        }

        return $this->hasMany(EventRegistration::class);
    }

    public function feedbacks()
    {
        if ($this->role !== 'student') {
            throw new \Exception('This user is not a student.');
        }

        return $this->hasMany(Feedback::class);
    }

    public function events()
    {
        if ($this->role !== 'organization') {
            throw new \Exception('This user is not an organization.');
        }

        return $this->hasMany(Event::class);
    }
}
