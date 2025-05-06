<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentRescheduled;
use App\Models\Slot;
use App\Jobs\SendRescheduleEmail;

class AppointmentController extends Controller
{
  public function index()
  {
    $doctorUserId = Auth::id();

    $appointments = Appointment::with(['patient', 'slot.doctor.user'])
      ->where('status', '!=', 'completed')
      ->whereHas('slot.doctor', function ($query) use ($doctorUserId) {
        $query->where('user_id', $doctorUserId);
      })
      ->latest()
      ->paginate(5, ['*'], 'upcoming_page');


    $completedAppointments = Appointment::with(['patient', 'slot.doctor.user'])
      ->where('status', 'completed')
      ->whereHas('slot.doctor', function ($query) use ($doctorUserId) {
        $query->where('user_id', $doctorUserId);
      })
      ->latest()
      ->paginate(5, ['*'], 'completed_page');



    return view('doctor.appointments', compact('appointments', 'completedAppointments'));
  }

  public function getAvailableSlots($appointmentId)
  {
    $appointment = Appointment::findOrFail($appointmentId);
    $doctorId = $appointment->slot->doctor_id;

    $availableSlots = Slot::where('doctor_id', $doctorId)
      ->whereDoesntHave('appointment')
      ->where('start_time', '>', now())
      ->get(['id', 'start_time']);

    // Format the available slots for the frontend
    $slots = $availableSlots->map(function ($slot) {
      return [
        'id' => $slot->id,
        'date' => $slot->start_time->format('M j, Y'),
        'time' => $slot->start_time->format('h:i A'),
      ];
    });

    return response()->json(['success' => true, 'slots' => $slots]);
  }


  public function reschedule(Request $request, Appointment $appointment)
  {
    $request->validate([
      'slot_id' => 'required|exists:slots,id',
    ]);

    $newSlot = Slot::where('id', $request->slot_id)
      ->where('doctor_id', $appointment->slot->doctor_id)
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
