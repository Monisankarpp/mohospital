<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'first_login' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'specialization',
        'status',
        'first_login'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function appointments()
    {
        return $this->hasManyThrough(Appointment::class, Slot::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
    public function currentSchedule()
    {
        return $this->schedules()
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->first();
    }
}

