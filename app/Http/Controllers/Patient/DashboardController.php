<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Slot;
use App\Models\Doctor;
use App\Jobs\SendRescheduleEmail;


class DashboardController extends Controller
{
  public function index()
  {
    $appointments = Appointment::with(['slot.doctor.user'])
      ->where('patient_id', Auth::id())
      ->where('status', '!=', 'completed')
      ->whereNull('deleted_at')
      ->whereHas('slot', function ($query) {
        $query->where('start_time', '>=', Carbon::now());
      })
      ->take(3)
      ->get()
      ->sortBy([
        fn($a, $b) => $a->slot->start_time <=> $b->slot->start_time,
      ]);

    $latestPrescription = Prescription::with(['doctor.user']) // assuming doctor has 'user' relation
      ->where('patient_id', auth()->id())
      ->latest()
      // ->skip(1)
      ->first();
    $availableSlots = Slot::with('doctor.user')
      ->where('start_time', '>=', Carbon::now())
      ->get();

    $messageCount = Notification::where('user_id', auth()->id())->count();


    return view('patient.dashboard', compact('appointments', 'latestPrescription', 'availableSlots', 'messageCount'));
  }

  public function getAvailableSlots(Doctor $doctor)
  {
    $slots = $doctor->slots()
      ->whereDoesntHave('appointment')
      ->where('date', '>=', now()->toDateString())
      ->orderBy('start_time')
      ->get(['id', 'start_time', 'end_time']);

    return response()->json($slots);
  }

  public function reschedule(Request $request, Appointment $appointment)
  {
    $request->validate([
      'slot_id' => 'required|exists:slots,id',
    ]);

    $newSlot = Slot::where('id', $request->slot_id)
      ->where('doctor_id', $appointment->slot->doctor_id)
      ->whereNull('deleted_at')
      ->whereDoesntHave('appointment')
      ->first();

    if (!$newSlot) {
      return response()->json(['success' => false, 'message' => 'The selected slot is not available.']);
    }

    $oldSlot = $appointment->slot;
    if ($oldSlot) {
      $oldSlot->update([
        'is_booked' => 0,
        'status' => 'available',
      ]);
    }

    $appointment->update([
      'slot_id' => $newSlot->id,
      'status' => 'rescheduled',
    ]);

    $newSlot->update([
      'is_booked' => 1,
      'status' => 'booked',

    ]);

    $appointment->load(['patient', 'slot.doctor.user']);
    SendRescheduleEmail::dispatch($appointment);

    return response()->json(['success' => true, 'message' => 'Appointment successfully rescheduled.']);
  }


}
