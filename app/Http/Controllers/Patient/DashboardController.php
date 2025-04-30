<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Slot;




class DashboardController extends Controller
{
  public function index()
  {
    $appointments = Appointment::with(['slot.doctor.user'])
      ->where('patient_id', Auth::id())
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

    return view('patient.dashboard', compact('appointments', 'latestPrescription', 'availableSlots'));
  }

  public function update(Request $request, $id)
  {
    $appointment = Appointment::findOrFail($id);

    // Ensure at least 24 hours difference
    $current = Carbon::now()->addHours(24);
    $appointmentTime = Carbon::parse($request->date . ' ' . $appointment->slot->start_time);

    if ($current->gt($appointmentTime)) {
      return back()->with('error', 'Appointments can only be edited at least 24 hours in advance.');
    }

    $appointment->date = $request->date;
    $appointment->slot_id = $request->slot_id;
    $appointment->save();

    return redirect()->back()->with('success', 'Appointment updated successfully!');
  }
}
