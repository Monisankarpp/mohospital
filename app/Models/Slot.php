<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'start_time',
        'end_time',
        'is_booked',
        'date',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'date' => 'date',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
    public function schedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }
    public function isEditable()
    {
        return !$this->is_booked && $this->start_time->diffInHours(now()) < 24;
    }

}

