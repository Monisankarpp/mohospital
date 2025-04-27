<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Services\SlotGeneratorService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateDoctorSlots extends Command
{
    protected $signature = 'slots:generate {--date=}';
    protected $description = 'Generate available slots for doctors based on their schedules';

    public function __construct(protected SlotGeneratorService $slotGenerator)
    {
        parent::__construct();
    }

    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::tomorrow();

        $this->info("Generating slots for date: {$date->format('Y-m-d')}");

        $doctors = Doctor::with('schedules')->get();

        foreach ($doctors as $doctor) {
            $this->slotGenerator->generateSlotsForDoctor($doctor, $date);
        }

        $this->info('Slot generation completed successfully.');
    }
}