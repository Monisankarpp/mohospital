<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['hospital_id', 'name', 'status'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function doctorDepartments()
    {
        return $this->hasMany(DoctorDepartment::class);
    }
}

