<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
  public function index()
  {
    $appointments = Appointment::with(['patient', 'slot'])
      ->whereHas('slot', function ($query) {
        $query->where('doctor_id', Auth::id());
      })
      ->orderByDesc('slot_id')
      ->paginate(10);

    return view('doctor.appointments', compact('appointments'));
  }


  /**
   * Display the specified appointment details.
   */
  public function show($id)
  {
    $appointment = Appointment::with(['patient', 'slot'])
      ->whereHas('slot', function ($query) {
        $query->where('doctor_id', Auth::id());
      })
      ->findOrFail($id);

    return view('doctor.appointments.show', compact('appointment'));
  }

}
