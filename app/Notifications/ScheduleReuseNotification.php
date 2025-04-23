<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ScheduleReuseNotification extends Notification implements ShouldQueue
{
  use Queueable;

  public function via($notifiable)
  {
    return ['database', 'mail'];
  }

  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->subject('Schedule Reuse Confirmation')
      ->line('Your current schedule is about to expire.')
      ->line('Would you like to reuse the same schedule for next week?')
      ->action('Confirm Schedule', route('doctor.schedule.confirm', ['reuse_schedule' => true]))
      ->line('Or click below to set up a new schedule:')
      ->action('Set New Schedule', route('doctor.slots.setup'));
  }

  public function toArray($notifiable)
  {
    return [
      'title' => 'Schedule Reuse Confirmation',
      'message' => 'Would you like to reuse the same schedule for next week?',
      'action_url' => route('doctor.schedule.confirm'),
      'action_text' => 'Respond',
    ];
  }
}

