<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\UpdateProfileRequest;
use App\Services\Doctor\DoctorProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
  protected DoctorProfileService $profileService;

  public function __construct(DoctorProfileService $profileService)
  {
    $this->profileService = $profileService;
  }

  public function index()
  {
    return view('doctor.profile', [
      'user' => Auth::user(),
    ]);
  }

  public function update(UpdateProfileRequest $request)
  {
    $this->profileService->update($request->validated());

    return redirect()
      ->route('doctor.dashboard')
      ->with('success', 'Profile updated successfully!');
  }
}
