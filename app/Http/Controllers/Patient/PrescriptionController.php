<?php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Prescription;


class PrescriptionController extends Controller
{
  public function index()
  {
    $prescriptions = Prescription::where('patient_id', auth()->id())->orderByDesc('created_at')->get();

    return view('patient.prescriptions', compact('prescriptions'));
  }

  public function showPrescription()
  {
    // Fetch the latest prescription for the patient (assuming it's related to the authenticated user)
    $latestPrescription = Prescription::where('user_id', auth()->id())
      ->orderBy('created_at', 'desc')
      ->first();

    // If no prescription is found, set to null
    if (!$latestPrescription) {
      $latestPrescription = null;
    }

    // Pass the latest prescription to the view
    return view('patient.prescription', compact('latestPrescription'));
  }

}
