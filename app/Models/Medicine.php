<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'name',
        'description',
        'price',
        'stock',
    ];

    public function store()
    {
        return $this->belongsTo(MedicalStore::class, 'store_id');
    }

    public function orderItems()
    {
        return $this->hasMany(MedicineOrderItem::class);
    }
}

