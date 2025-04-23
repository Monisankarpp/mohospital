<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $slots = Slot::with('doctor')->where('is_booked', false)->get();
        return view('bookings.index', compact('slots'));
    }

    public function store(Request $request, Slot $slot)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'time_slot' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        $slot->is_booked = true;
        $slot->save();

        Appointment::create([
            'slot_id' => $slot->id,
            'doctor_id' => $request->doctor_id,
            'user_id' => auth()->id(),
            'appointment_date' => $request->appointment_date,
            'time_slot' => $request->time_slot,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }



}

