<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSlotRequest;
use App\Http\Requests\UpdateSlotRequest;
use App\Jobs\SendRescheduleEmailToPatient;
use App\Models\DoctorSchedule;
use App\Models\Slot;
use App\Services\SlotGeneratorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Appointment;

class SlotController extends Controller
{
	use AuthorizesRequests;
	public function __construct(protected SlotGeneratorService $slotGenerator)
	{
		// $this->middleware('auth');
		// $this->middleware('role:doctor');
	}

	public function index()
	{
		$doctor = auth()->user()->doctor;
		$schedules = $doctor->schedules()->get();

		// Get slots grouped by date
		$slots = Slot::where('doctor_id', $doctor->id)
			->where('date', '>=', now()->format('Y-m-d'))
			->orderBy('date')
			->orderBy('start_time')
			->get()
			->groupBy('date');

		return view('doctor.slots.index', compact('schedules', 'slots'));
	}

	public function create()
	{
		$doctor = auth()->user()->doctor;
		$defaultSchedule = $doctor->default_schedule ?? [];

		return view('doctor.slots.create', compact('defaultSchedule'));
	}

	public function store(Request $request)
	{
		$doctor = auth()->user()->doctor;
		$days = $request->input('days', []);
		$isDefault = $request->boolean('set_as_default');

		// Delete existing schedules for these days
		DoctorSchedule::where('doctor_id', $doctor->id)
			->whereIn('day_of_week', array_keys($days))
			->delete();

		$schedules = [];
		foreach ($days as $day => $schedule) {
			if ($schedule['is_working'] ?? false) {
				$schedules[] = DoctorSchedule::create([
					'doctor_id' => $doctor->id,
					'day_of_week' => $day,
					'is_working' => true,
					'start_time' => $schedule['start_time'],
					'end_time' => $schedule['end_time'],
					'lunch_start' => $schedule['lunch_start'] ?? null,
					'lunch_end' => $schedule['lunch_end'] ?? null,
					'slot_duration' => $schedule['slot_duration'],
					'break_between_slots' => $schedule['break_between_slots'],
				]);
			} else {
				$schedules[] = DoctorSchedule::create([
					'doctor_id' => $doctor->id,
					'day_of_week' => $day,
					'is_working' => false,

				]);
			}
		}

		if ($isDefault) {
			$doctor->update([
				'default_schedule' => $request->input('days'),
				'last_schedule_update' => now(),
			]);
		}

		// Generate slots for next 7 days
		for ($i = 1; $i <= 7; $i++) {
			$this->slotGenerator->generateSlotsForDoctor($doctor, now()->addDays($i));
		}

		return redirect()->route('doctor.slots.index')->with('success', 'Schedule updated successfully');
	}

	public function edit(Slot $slot)
	{
		// $this->authorize('update', $slot);

		if (!$slot->isEditable()) {
			return redirect()->back()->with('error', 'This slot can no longer be edited');
		}

		return view('doctor.slots.edit', compact('slot'));
	}

	public function update(UpdateSlotRequest $request, Slot $slot)
	{
		// Verify ownership
		if ($slot->doctor_id !== auth()->user()->doctor->id) {
			abort(403, 'You do not own this slot');
		}

		// Check editability
		if (!$slot->isEditable()) {
			return redirect()->back()
				->with('error', 'Editing window has expired (24 hour rule)');
		}

		// Proceed with update
		$data = $request->validated();
		$start = Carbon::parse($data['start_time']);

		$slot->update([
			'start_time' => $start,
			'end_time' => Carbon::parse($data['end_time']),
			'can_edit_until' => $start->copy()->subDay()
		]);

		return redirect()->route('doctor.slots.index')
			->with('success', 'Slot updated successfully');
	}

	public function destroy(Slot $slot)
	{

		if (!$slot->isEditable()) {
			return redirect()->back()->with('error', 'This slot can no longer be deleted');
		}

		$slot->delete();

		return redirect()->route('doctor.slots.index')->with('success', 'Slot deleted successfully');
	}

	public function applyDefaultSchedule()
	{
		$doctor = auth()->user()->doctor;

		if (!$doctor->default_schedule) {
			return redirect()->back()->with('error', 'No default schedule found');
		}

		// Delete all existing schedules
		DoctorSchedule::where('doctor_id', $doctor->id)->delete();

		// Create new schedules from default
		foreach ($doctor->default_schedule as $day => $schedule) {
			DoctorSchedule::create([
				'doctor_id' => $doctor->id,
				'day_of_week' => $day,
				'is_working' => $schedule['is_working'] ?? false,
				'start_time' => $schedule['start_time'] ?? null,
				'end_time' => $schedule['end_time'] ?? null,
				'lunch_start' => $schedule['lunch_start'] ?? null,
				'lunch_end' => $schedule['lunch_end'] ?? null,
				'slot_duration' => $schedule['slot_duration'] ?? 30,
				'break_between_slots' => $schedule['break_between_slots'] ?? 5,
			]);
		}

		// Generate slots for next 7 days
		for ($i = 1; $i <= 7; $i++) {
			$this->slotGenerator->generateSlotsForDoctor($doctor, now()->addDays($i));
		}

		return redirect()->route('doctor.slots.index')->with('success', 'Default schedule applied successfully');
	}

	public function markUnavailableDay(Request $request)
	{
		$request->validate([
			'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
		]);

		$doctor = auth()->user()->doctor;
		$day = strtolower($request->day);
		$dayNumber = Carbon::createFromFormat('l', ucfirst($day))->dayOfWeek;

		$schedule = DoctorSchedule::where('doctor_id', $doctor->id)
			->where('day_of_week', $day)
			->first();

		if ($schedule) {
			$schedule->is_working = false;
			$schedule->save();
		}

		$slotsToDelete = Slot::where('doctor_id', $doctor->id)
			->where('start_time', '>=', now())
			->whereRaw('WEEKDAY(start_time) = ?', [$dayNumber === 0 ? 6 : $dayNumber - 1])
			->get();

		$notifiedCount = 0;

		foreach ($slotsToDelete as $slot) {
			$appointments = Appointment::with(['patient', 'slot.doctor.user'])
				->where('slot_id', $slot->id)
				->get();

			foreach ($appointments as $appointment) {
				if ($appointment->patient && $appointment->patient->email) {
					SendRescheduleEmailToPatient::dispatch($appointment);
					$notifiedCount++;
				}
			}

			$slot->delete();
		}


		return back()->with('success', "All $day slots deleted. all patient's are notified.");

	}


}