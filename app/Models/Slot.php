<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'doctor_department_id',
        'start_time',
        'end_time',
        'is_booked',
    ];

    public function doctorDepartment()
    {
        return $this->belongsTo(DoctorDepartment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

}

