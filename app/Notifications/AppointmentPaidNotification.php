<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentPaidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Appointment $appointment)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Appointment Confirmed')
            ->greeting('Hello ' . $notifiable->name)
            ->line('The payment for your appointment has been successfully processed.')
            ->action('View Appointment', url('/appointments/' . $this->appointment->id))
            ->line('Thank you for choosing us!');
    }
}

