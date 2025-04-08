<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'specialization', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctorDepartments()
    {
        return $this->hasMany(DoctorDepartment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}

