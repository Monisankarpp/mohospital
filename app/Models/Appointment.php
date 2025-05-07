<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'slot_id',
        'status',
        'rescheduled_at',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

}

