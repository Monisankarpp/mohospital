<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'store_id',
        'prescription_id',
        'total_amount',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function store()
    {
        return $this->belongsTo(MedicalStore::class, 'store_id');
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function items()
    {
        return $this->hasMany(MedicineOrderItem::class, 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}

