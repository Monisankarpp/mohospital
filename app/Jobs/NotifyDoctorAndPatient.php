<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Notifications\AppointmentPaidNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyDoctorAndPatient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(public Appointment $appointment)
    {

    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->appointment->doctor->user->notify(new AppointmentPaidNotification($this->appointment));
        $this->appointment->patient->notify(new AppointmentPaidNotification($this->appointment));
    }
}