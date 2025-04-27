<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Doctor;
use App\Notifications\ScheduleReuseNotification;
use App\Notifications\DailyScheduleNotification;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Weekly schedule reuse notification (Sunday at 11 PM)
Schedule::call(function () {
    $doctors = Doctor::with([
        'schedules' => function ($query) {
            $query->where('valid_to', '=', now()->endOfWeek());
        }
    ])->get();

    foreach ($doctors as $doctor) {
        if ($doctor->schedules->isNotEmpty()) {
            $doctor->user->notify(new ScheduleReuseNotification());
        }
    }
})->weekly()->sundays()->at('23:00');

// Daily schedule notification (every day at 11 PM)
Schedule::call(function () {
    $tomorrow = now()->addDay();
    $doctors = Doctor::with([
        'schedules' => function ($query) use ($tomorrow) {
            $query->where('valid_from', '<=', $tomorrow)
                ->where('valid_to', '>=', $tomorrow);
        }
    ])->get();

    foreach ($doctors as $doctor) {
        if ($doctor->schedules->isNotEmpty()) {
            $doctor->user->notify(new DailyScheduleNotification($doctor->schedules->first()));
        }
    }
})->dailyAt('23:00');


Schedule::command('appointments:cleanup')->everyFiveMinutes();
