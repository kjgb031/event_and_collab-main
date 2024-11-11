<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentData extends Model
{
    use HasFactory;

    protected $table = 'student_data';
    protected $fillable = [
        'campus',
        'college',
        'program',
        'major',
        'user_id',
        'guardian_name',
        'guardian_contact',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
