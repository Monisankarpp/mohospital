<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Slot;
use App\Mail\PrescriptionWithThankYou;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
  public function index()
  {

    $doctorId = auth()->user()->doctor->id;

    $upcomingAppointmentsCount = Appointment::whereHas('slot', function ($query) use ($doctorId) {
      $query->where('doctor_id', $doctorId)
        ->where('start_time', '>=', now());
    })
      ->count();

    $totalPatientsCount = Appointment::whereHas('slot', function ($query) use ($doctorId) {
      $query->where('doctor_id', $doctorId);
    })
      ->distinct('patient_id')
      ->count('patient_id');

    $doctorId = auth()->user()->doctor->id;

    $totalAvailableSlots = Slot::where('doctor_id', $doctorId)
      ->where('is_booked', false)
      ->count();

    $today = Carbon::today();

    $appointmentsToday = Appointment::with(['patient', 'slot'])
      ->join('slots', 'appointments.slot_id', '=', 'slots.id')
      ->whereDate('slots.start_time', $today)
      ->where('slots.doctor_id', auth()->user()->doctor->id)
      ->orderBy('slots.start_time', 'asc')
      ->select('appointments.*')
      ->take(3)
      ->get();

    $recentPatients = Appointment::with('patient')
      ->whereHas('slot', function ($query) use ($doctorId) {
        $query->where('doctor_id', $doctorId);
      })
      ->orderByDesc('created_at')
      ->get()
      ->unique('patient_id')
      ->take(1);

    return view('doctor.dashboard', compact('appointmentsToday', 'recentPatients', 'totalPatientsCount', 'upcomingAppointmentsCount', 'totalAvailableSlots'));

  }

  public function complete(Request $request, Appointment $appointment)
  {
    if ($appointment->status === 'completed') {
      return response()->json([
        'success' => false,
        'message' => 'Appointment is already completed.'
      ], 400);
    }

    // Update status
    $appointment->status = 'completed';
    $appointment->save();

    $appointment->load(['patient', 'slot.doctor.user']);

    Mail::to($appointment->patient->email)->send(new PrescriptionWithThankYou($appointment));

    return response()->json([
      'success' => true,
      'message' => 'Appointment completed and email sent.'
    ]);
  }

}