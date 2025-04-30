<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Slot;
use Illuminate\Support\Facades\Auth;

class AppointmentControllerForID extends Controller
{

    public function prepare(Request $request)
    {
        $validated = $request->validate([
            'slot_id' => 'required|exists:slots,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $slot = Slot::findOrFail($validated['slot_id']);

        if ($slot->status === 1) {
            return response()->json(['message' => 'Slot already booked'], 409);
        }

        // Create a new appointment with pending status
        $appointment = Appointment::create([
            'patient_id' => Auth::id(),
            'slot_id' => $slot->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'appointment_id' => $appointment->id
        ]);
    }

}
