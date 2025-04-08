<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineOrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'medicine_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(MedicineOrder::class, 'order_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}

