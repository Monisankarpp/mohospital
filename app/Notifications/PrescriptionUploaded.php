<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PrescriptionUploaded extends Notification
{
    protected $prescription;

    public function __construct($prescription)
    {
        $this->prescription = $prescription;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Prescription Available',
            'message' => 'Your doctor has uploaded a new prescription. Click to view or download.',
            'prescription_id' => $this->prescription->id,
            'doctor_id' => $this->prescription->doctor_id,
            'patient_id' => $this->prescription->patient_id,
        ];
    }
}

