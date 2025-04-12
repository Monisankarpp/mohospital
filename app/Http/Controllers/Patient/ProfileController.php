<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\UpdateProfileRequest;
use App\Services\Patient\PatientProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
  protected $profileService;

  public function __construct(PatientProfileService $profileService)
  {
    $this->profileService = $profileService;
  }

  public function index()
  {
    $user = Auth::user();
    return view('patient.profile', compact('user'));
  }

  public function update(UpdateProfileRequest $request)
  {
    try {
      $this->profileService->updateProfile($request);
      return redirect()->route('patient.dashboard')->with('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
      return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
    }
  }
}
