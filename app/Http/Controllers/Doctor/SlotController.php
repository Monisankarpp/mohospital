<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Slot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SlotController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$slots = Slot::where('doctor_id', auth()->user()->doctor->id)
			->latest()
			->paginate(8);

		return view('doctor.slots.index', compact('slots'));
	}

	public function create()
	{
		return view('doctor.slots.create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'doctor_id' => 'required|integer',
			'start_time' => 'required|date',
			'end_time' => 'required|date|after:start_time',
		]);

		Slot::create([
			'doctor_id' => auth()->user()->doctor->id,
			'start_time' => $request->start_time,
			'end_time' => $request->end_time,
			'is_booked' => false,
		]);

		return redirect()->route('doctor.slots.index')->with('success', 'Slot created successfully.');
	}

	public function edit($id)
	{
		$slot = Slot::findOrFail($id);

		if ($slot->doctor_id !== auth()->user()->doctor->id) {
			abort(403, 'Unauthorized action.');
		}

		return view('doctor.slots.edit', compact('slot'));
	}
	public function update(Request $request, Slot $slot)
	{
		$request->validate([
			'start_time' => 'required|date',
			'end_time' => 'required|date|after:start_time',
		]);

		$slot->update([
			'start_time' => $request->start_time,
			'end_time' => $request->end_time,
		]);

		return redirect()->route('doctor.slots.index')->with('success', 'Slot updated successfully.');
	}

	public function destroy(Slot $slot)
	{
		$slot->delete();

		return redirect()->route('doctor.slots.index')->with('success', 'Slot deleted.');
	}
}
