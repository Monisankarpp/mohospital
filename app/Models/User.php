<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function hospital()
    {
        return $this->hasOne(Hospital::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function medicalStore()
    {
        return $this->hasOne(MedicalStore::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function labReports()
    {
        return $this->hasMany(LabReport::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function medicineOrders()
    {
        return $this->hasMany(MedicineOrder::class, 'patient_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
