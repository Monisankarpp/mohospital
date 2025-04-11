<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
  public function index()
  {
    return view('doctor.prescription.upload');
  }
}