<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RescheduleAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $patientName;
    public $slotTime;
    public $doctorName;
    /**
     * Create a new message instance.
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Your Appointment Has Been Cancelled Please Reschedule your slot')
            ->view('emails.reschedule');
    }
}
