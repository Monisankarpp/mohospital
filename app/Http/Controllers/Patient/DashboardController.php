<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



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
      ->skip(1)
      ->first();

    return view('patient.dashboard', compact('appointments', 'latestPrescription'));
  }
}
