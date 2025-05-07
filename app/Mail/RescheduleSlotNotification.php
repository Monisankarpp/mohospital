<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RescheduleSlotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $slot;

    public function __construct($slot)
    {
        $this->slot = $slot;
    }

    public function build()
    {
        return $this->subject('Your Appointment Slot Was Cancelled')
            ->view('emails.reschedule_slot_notification')
            ->with([
                'slot' => $this->slot,
                'patient' => $this->slot->appointment->user,
            ]);
    }
}
