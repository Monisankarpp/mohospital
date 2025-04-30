<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
  public function index()
  {
    $doctorUserId = Auth::id();

    $appointments = Appointment::with(['patient', 'slot.doctor.user']) // eager load relationships
      ->whereHas('slot.doctor', function ($query) use ($doctorUserId) {
        $query->where('user_id', $doctorUserId);
      })
      ->latest()
      ->paginate(9);


    return view('doctor.appointments', compact('appointments'));
  }
}
