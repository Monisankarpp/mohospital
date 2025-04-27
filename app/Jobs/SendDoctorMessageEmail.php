<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\DoctorMessageMail;

class SendDoctorMessageEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $patient;

    public function __construct(User $patient)
    {
        $this->patient = $patient;
    }

    public function handle(): void
    {
        Mail::to($this->patient->email)->send(new DoctorMessageMail($this->patient));
    }
}

