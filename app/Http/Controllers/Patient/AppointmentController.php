<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
	public function index()
	{
		$appointments = Appointment::with(['slot.doctor.user'])
			->where('patient_id', Auth::id())
			->whereHas('slot', function ($query) {
				$query->where('start_time', '>=', Carbon::now());
			})
			->get()
			->sortBy([
				fn($a, $b) => $a->slot->start_time <=> $b->slot->start_time,
			]);

		return view('patient.appointments', compact('appointments'));
	}

	public function show($id)
	{
		$appointment = Appointment::with(['slot.doctor.user'])
			->findOrFail($id);

		return view('patient.appointments', compact('appointment'));
	}


	public function reschedule(Request $request, $id)
	{
		$request->validate([
			'new_date' => 'required|date',
			'new_time' => 'required'
		]);

		$appointment = Appointment::findOrFail($id);
		$appointment->date = $request->input('new_date');
		$appointment->slot->start_time = $request->input('new_time');
		$appointment->save();

		return response()->json(['message' => 'Appointment rescheduled']);
	}

}
