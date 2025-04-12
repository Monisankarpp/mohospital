<?php

namespace App\Services\Doctor;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DoctorProfileService
{
  public function update(array $data): void
  {
    $user = Auth::user();

    if (!empty($data['password'])) {
      if (!Hash::check($data['current_password'], $user->password)) {
        throw ValidationException::withMessages([
          'current_password' => 'The current password is incorrect.',
        ]);
      }

      $user->password = Hash::make($data['password']);
    }

    $user->name = $data['name'];
    $user->phone = $data['phone'];
    $user->save();
  }
}
