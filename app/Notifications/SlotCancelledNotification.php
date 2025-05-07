<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class SlotCancelledNotification extends Notification
{
    protected $slot;

    public function __construct($slot)
    {
        $this->slot = $slot;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Appointment Slot Has Been Cancelled')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Unfortunately, your booked slot has been cancelled by the doctor.')
            ->line('Date: ' . $this->slot->start_time->format('Y-m-d'))
            ->line('Time: ' . $this->slot->start_time->format('h:i A') . ' - ' . $this->slot->end_time->format('h:i A'))
            ->action('Reschedule Now', url('/appointments/reschedule'))
            ->line('We apologize for the inconvenience.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Slot Cancelled',
            'message' => 'Your appointment slot on ' . $this->slot->start_time->format('Y-m-d H:i') . ' was cancelled. Please reschedule.',
            'url' => url('/appointments/reschedule')
        ];
    }
}

