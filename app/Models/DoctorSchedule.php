<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorSchedule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'is_working',
        'start_time',
        'end_time',
        'lunch_start',
        'lunch_end',
        'slot_duration',
        'break_between_slots',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'lunch_start' => 'datetime:H:i',
        'lunch_end' => 'datetime:H:i',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}
