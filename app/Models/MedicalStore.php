<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalStore extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'contact_number',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function orders()
    {
        return $this->hasMany(MedicineOrder::class, 'store_id');
    }
}

