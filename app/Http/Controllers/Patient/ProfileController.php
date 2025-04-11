<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    return view('patient.profile', compact('user'));
  }

  public function update(Request $request)
  {
    $request->validate([
      'name' => [
        'required',
        'string',
        'max:255',
        'regex:/^[a-zA-Z\s]+$/'
      ],
      'phone' => [
        'nullable',
        'string',
        'max:20',
        'regex:/^[0-9+\-\s\(\)]+$/'
      ],
    ], [
      'name.required' => 'Please enter your full name.',
      'name.regex' => 'Name can only contain letters and spaces.',
      'phone.regex' => 'Phone number format is invalid.',
    ]);

    $user = Auth::user();
    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->save();

    return redirect('patient/dashboard')->with('success', 'Profile updated successfully!');
  }

}
