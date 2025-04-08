<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'address', 'contact_number', 'status'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}

