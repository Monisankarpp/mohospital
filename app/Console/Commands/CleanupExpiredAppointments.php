<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Slot;
use Carbon\Carbon;

class CleanupExpiredAppointments extends Command
{
    protected $signature = 'appointments:cleanup';
    protected $description = 'Clean up expired unpaid appointments';

    public function handle()
    {
        $expired = Appointment::where('status', 'pending_payment')
            ->where('expires_at', '<', now())
            ->get();

        foreach ($expired as $appointment) {
            Slot::where('id', $appointment->slot_id)->update(['is_booked' => 0]);
            $appointment->delete();
        }

        $this->info('Cleaned up ' . $expired->count() . ' expired appointments');
    }
}