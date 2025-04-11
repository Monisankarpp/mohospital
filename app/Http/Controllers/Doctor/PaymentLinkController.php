<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentLinkController extends Controller
{
  public function index()
  {
    return view('doctor.payment.link');
  }
}