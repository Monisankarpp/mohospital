<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Doctor;
use App\Models\Slot;
use App\Models\DoctorDepartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class SlotController extends Controller
{
	use AuthorizesRequests;
	public function index()
	{
		$slots = Slot::with('doctorDepartment.department', 'doctorDepartment.doctor')
			->whereHas('doctorDepartment', fn($q) => $q->where('doctor_id', auth()->user()->doctor->id))
			->latest()->paginate(10);

		return view('doctor.slots.index', compact('slots'));
	}

	public function create()
	{
		$departments = Doctor::with('specialization')
			->where('user_id', auth()->user()->doctor->id)
			->get();

		return view('doctor.slots.create', compact('departments'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'doctor_department_id' => 'required|exists:doctor_departments,id',
			'start_time' => 'required|date',
			'end_time' => 'required|date|after:start_time',
		]);

		Slot::create([
			...$request->only(['doctor_department_id', 'start_time', 'end_time']),
			'is_booked' => false,
		]);

		return redirect()->route('doctor.slots.index')->with('success', 'Slot created successfully.');
	}

	public function edit(Slot $slot)
	{
		$this->authorize('update', $slot); // Optional: policy check

		$departments = DoctorDepartment::where('doctor_id', auth()->user()->doctor->id)->get();

		return view('doctor.slots.edit', compact('slot', 'departments'));
	}

	public function update(Request $request, Slot $slot)
	{
		$request->validate([
			'doctor_department_id' => 'required|exists:doctor_departments,id',
			'start_time' => 'required|date',
			'end_time' => 'required|date|after:start_time',
		]);

		$slot->update($request->only(['doctor_department_id', 'start_time', 'end_time']));

		return redirect()->route('doctor.slots.index')->with('success', 'Slot updated successfully.');
	}

	public function destroy(Slot $slot)
	{
		$slot->delete();

		return redirect()->route('doctor.slots.index')->with('success', 'Slot deleted.');
	}
}