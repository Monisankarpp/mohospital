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

		// Update user fields
		$user->update([
			'name' => $data['name'],
			'phone' => $data['phone'],
			'address' => $data['address'],
		]);

		// Check if doctor record exists
		if ($user->doctor) {
			$user->doctor->update([
				'specialization' => $data['specialization'] ?? $user->doctor->specialization,
				'status' => isset($data['status']) ? $data['status'] : $user->doctor->status,
			]);
		} else {
			// Create doctor record if it doesn't exist
			$user->doctor()->create([
				'specialization' => $data['specialization'] ?? '',
				'status' => isset($data['status']),
			]);
		}

		if (!empty($data['password'])) {
			$user->update([
				'password' => bcrypt($data['password']),
			]);
		}
	}

}
