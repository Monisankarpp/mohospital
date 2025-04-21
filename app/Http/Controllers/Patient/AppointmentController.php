<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class AppointmentController extends Controller
{
  public function index()
  {
    $appointments = Appointment::with(['slot.doctor.user'])
      ->where('patient_id', Auth::id())
      ->orderBy('date', 'desc')
      ->paginate(10);

    return view('patient.appointments', compact('appointments'));
  }

  public function show($id)
  {
    $appointment = Appointment::with(['slot.doctor.user'])
      ->findOrFail($id);

    return view('patient.appointments', compact('appointment'));
  }
}
