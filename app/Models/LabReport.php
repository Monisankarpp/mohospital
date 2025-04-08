<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prescription_id',
        'user_id',
        'file_url',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

