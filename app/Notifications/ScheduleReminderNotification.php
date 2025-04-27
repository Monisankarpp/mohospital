<?php

namespace App\Notifications;

use App\Models\Notification as NotificationModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class ScheduleReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public NotificationModel $notification,
        public bool $isWeekly,
        public Carbon $date
    ) {
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $type = $this->isWeekly ? 'weekly' : 'daily';
        $dateString = $this->isWeekly ?
            $this->date->format('Y-m-d') . ' (next week)' :
            $this->date->format('Y-m-d');

        return (new MailMessage)
            ->subject("Schedule Update Required for $dateString")
            ->greeting("Hello Dr. {$notifiable->name},")
            ->line("You don't have any $type schedule for $dateString.")
            ->line('Please update your schedule to ensure patients can book appointments.')
            ->action('Update Your Schedule', route('doctor.slots.index'))
            ->line('If you do nothing, your previous schedule will be used automatically.');
    }

    public function toArray($notifiable)
    {
        return [
            'notification_id' => $this->notification->id,
            'message' => $this->notification->message,
            'is_weekly' => $this->isWeekly,
            'date' => $this->date->format('Y-m-d'),
        ];
    }
}