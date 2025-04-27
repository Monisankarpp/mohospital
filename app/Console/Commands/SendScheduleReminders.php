<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Models\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\ScheduleReminderNotification;


class SendScheduleReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reminders to doctors to update their schedules';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow();
        $nextWeekStart = Carbon::tomorrow()->addWeek()->startOfWeek();

        $doctors = Doctor::with(['schedules', 'user'])->get();

        foreach ($doctors as $doctor) {
            // Check if doctor has any slots for tomorrow
            $hasSlotsForTomorrow = $doctor->slots()
                ->where('date', $tomorrow->format('Y-m-d'))
                ->exists();

            if (!$hasSlotsForTomorrow) {
                $this->sendReminder($doctor, $tomorrow);
            }

            // Check if doctor has any schedules for next week
            if ($tomorrow->isMonday()) {
                $hasScheduleForNextWeek = $doctor->schedules()
                    ->whereIn('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
                    ->where('is_working', true)
                    ->exists();

                if (!$hasScheduleForNextWeek) {
                    $this->sendReminder($doctor, $nextWeekStart, true);
                }
            }
        }
    }

    protected function sendReminder(Doctor $doctor, Carbon $date, bool $isWeekly = false)
    {
        $type = $isWeekly ? 'weekly' : 'daily';
        $dateString = $isWeekly ? $date->format('Y-m-d') . ' (next week)' : $date->format('Y-m-d');

        $notification = Notification::create([
            'user_id' => $doctor->user_id,
            'title' => 'Schedule Update Required',
            'message' => "You don't have any $type schedule for $dateString. Please update your schedule.",
            'is_read' => false,
        ]);

        $doctor->user->notify(new ScheduleReminderNotification(
            notification: $notification,
            isWeekly: $isWeekly,
            date: $date
        ));

        $this->info("Sent reminder to Dr. {$doctor->user->name} for $dateString");
    }
}