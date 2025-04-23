<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Models\DoctorSchedule;
use App\Models\Slot;
use App\Services\SlotGeneratorService;
use App\Jobs\ProcessSlotGeneration;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SlotController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		if (auth()->user()->doctor->schedules()->doesntExist()) {
			return redirect()->route('doctor.slots.first-time-setup');
		}

		$slots = auth()->user()->doctor->slots()
			->where('start_time', '>=', now())
			->latest()
			->paginate(10);

		return view('doctor.slots.index', compact('slots'));
	}

	public function firstTimeSetup()
	{
		return view('doctor.slots.first-time-setup');
	}

	public function storeFirstTimeSetup(StoreScheduleRequest $request)
	{
		$doctor = auth()->user()->doctor;

		foreach ($request->days as $day) {
			$doctor->schedules()->create([
				'day' => $day,
				'start_time' => $request->start_time,
				'end_time' => $request->end_time,
				'lunch_start' => $request->lunch_start,
				'lunch_end' => $request->lunch_end,
				'slot_duration' => $request->slot_duration,
				'break_between_slots' => $request->break_between_slots,
				'is_active' => true,
				'is_recurring' => true,
			]);
		}

		// Replace direct generation with queued job
		ProcessSlotGeneration::dispatch($doctor, true)
			->onQueue('slot-generation');

		return redirect()->route('doctor.slots.index')
			->with('success', 'Slot generation started. You will receive a notification when complete.');
	}

	public function confirmRecurrence(Request $request)
	{
		$request->validate([
			'recurrence' => 'required|in:same,new',
		]);

		if ($request->recurrence === 'same') {
			// Replace direct generation with queued job
			ProcessSlotGeneration::dispatch(auth()->user()->doctor)
				->onQueue('slot-generation');

			return redirect()->route('doctor.slots.index')
				->with('success', 'Your slots are being regenerated. You will be notified when complete.');
		}

		return redirect()->route('doctor.slots.first-time-setup');
	}

	public function edit(Slot $slot)
	{
		$this->authorize('update', $slot);

		return view('doctor.slots.edit', compact('slot'));
	}

	public function update(Request $request, Slot $slot)
	{
		$this->authorize('update', $slot);

		$validated = $request->validate([
			'start_time' => 'required|date',
			'end_time' => 'required|date|after:start_time',
		]);

		$slot->update($validated);

		return redirect()->route('doctor.slots.index')
			->with('success', 'Slot updated successfully.');
	}

	public function destroy(Slot $slot)
	{
		$this->authorize('delete', $slot);

		$slot->delete();

		return redirect()->route('doctor.slots.index')
			->with('success', 'Slot deleted successfully.');
	}
}