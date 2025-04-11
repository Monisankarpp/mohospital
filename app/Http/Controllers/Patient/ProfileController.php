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
      'name' => 'required|string|max:255',
      'phone' => 'nullable|string|max:20',
    ]);

    $user = Auth::user();
    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->save();

    return redirect('patient/dashboard')->with('success', 'Profile updated successfully!');
  }
}
