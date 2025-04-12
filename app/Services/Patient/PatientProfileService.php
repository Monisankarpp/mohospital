<?php

namespace App\Services\Patient;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PatientProfileService
{
  /**
   * Update patient profile
   *
   * @param \App\Http\Requests\Patient\UpdateProfileRequest $request
   * @return void
   */
  public function updateProfile($request)
  {
    $user = Auth::user();

    // If password is provided, validate the current password and update it
    if ($request->filled('password')) {
      if (!Hash::check($request->current_password, $user->password)) {
        throw new \Exception('The current password is incorrect.');
      }
      $user->password = bcrypt($request->password);
    }

    // Update the user details
    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->save();
  }
}
