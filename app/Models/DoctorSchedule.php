<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorSchedule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'doctor_id',
        'start_time',
        'end_time',
        'lunch_start',
        'lunch_end',
        'working_days',
        'breaks',
        'is_recurring',
        'valid_from',
        'valid_to',
    ];

    protected $casts = [
        'working_days' => 'array',
        'breaks' => 'array',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'lunch_start' => 'datetime:H:i',
        'lunch_end' => 'datetime:H:i',
        'valid_from' => 'date',
        'valid_to' => 'date',
        'is_recurring' => 'boolean',
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
