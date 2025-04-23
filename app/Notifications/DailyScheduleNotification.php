<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailyScheduleNotification extends Notification implements ShouldQueue
{
  use Queueable;

  protected $schedule;

  public function __construct($schedule)
  {
    $this->schedule = $schedule;
  }

  public function via($notifiable)
  {
    return ['database'];
  }

  public function toArray($notifiable)
  {
    return [
      'title' => 'Tomorrow\'s Schedule',
      'message' => 'You have ' . $this->schedule->slots->count() . ' slots scheduled for tomorrow.',
      'action_url' => route('doctor.schedule.index'),
      'action_text' => 'View Schedule',
    ];
  }
}