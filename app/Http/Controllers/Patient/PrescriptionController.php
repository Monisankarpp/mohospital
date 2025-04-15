<?php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
  public function index()
  {
    return view('patient.prescriptions');
  }

}
