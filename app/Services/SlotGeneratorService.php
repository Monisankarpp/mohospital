<?php
namespace App\Services;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Slot;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SlotGeneratorService
{
	public function generateSlots(Doctor $doctor, array $data, bool $isRecurring = false)
	{
		// Validate working days count
		$workingDays = $data['working_days'];
		if (count($workingDays) < 3 || count($workingDays) > 6) {
			throw new \InvalidArgumentException('Doctor must work between 3 to 6 days a week');
		}

		// Create or update schedule
		$schedule = $doctor->schedules()->create([
			'start_time' => $data['start_time'],
			'end_time' => $data['end_time'],
			'lunch_start' => $data['lunch_start'],
			'lunch_end' => $data['lunch_end'],
			'breaks' => $data['breaks'] ?? null,
			'working_days' => $workingDays,
			'is_recurring' => $isRecurring,
			'valid_from' => now()->startOfWeek(),
			'valid_to' => now()->endOfWeek(),
		]);

		// Generate slots for each working day
		foreach ($workingDays as $day) {
			$this->generateDaySlots($schedule, $day);
		}

		return $schedule;
	}

	protected function generateDaySlots(DoctorSchedule $schedule, string $day)
	{
		$date = $this->getNextDateForDay($day);

		// Create time slots excluding breaks
		$slots = $this->calculateAvailableSlots($schedule);

		foreach ($slots as $slot) {
			$startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $slot['start']);
			$endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $slot['end']);

			$schedule->slots()->create([
				'doctor_id' => $schedule->doctor_id,
				'date' => $date,
				'start_time' => $startTime,
				'end_time' => $endTime,
				'is_booked' => false,
			]);
		}
	}

	protected function calculateAvailableSlots(DoctorSchedule $schedule): array
	{
		$slots = [];
		$slotDuration = 30; // minutes

		$start = Carbon::parse($schedule->start_time);
		$end = Carbon::parse($schedule->end_time);

		// Handle lunch break
		$lunchStart = Carbon::parse($schedule->lunch_start);
		$lunchEnd = Carbon::parse($schedule->lunch_end);

		// Handle additional breaks
		$breaks = collect($schedule->breaks ?? [])->map(function ($break) {
			return [
				'start' => Carbon::parse($break['start']),
				'end' => Carbon::parse($break['end']),
			];
		});

		$current = $start->copy();

		while ($current->addMinutes($slotDuration) <= $end) {
			$slotEnd = $current->copy()->addMinutes($slotDuration);

			// Skip if during lunch
			if (
				$lunchStart && $lunchEnd &&
				$current->between($lunchStart, $lunchEnd)
			) {
				$current = $lunchEnd->copy();
				continue;
			}

			// Skip if during any break
			$duringBreak = $breaks->first(function ($break) use ($current, $slotEnd) {
				return $current->between($break['start'], $break['end']) ||
					$slotEnd->between($break['start'], $break['end']);
			});

			if ($duringBreak) {
				$current = $duringBreak['end']->copy();
				continue;
			}

			// Add valid slot
			$slots[] = [
				'start' => $current->format('H:i'),
				'end' => $slotEnd->format('H:i'),
			];

			$current = $slotEnd->copy();
		}

		return $slots;
	}

	protected function getNextDateForDay(string $day): Carbon
	{
		$date = now()->startOfWeek();

		while (strtolower($date->format('l')) !== strtolower($day)) {
			$date->addDay();
		}

		return $date;
	}

	public function duplicateScheduleForNextWeek(DoctorSchedule $currentSchedule)
	{
		$newSchedule = $currentSchedule->replicate();
		$newSchedule->valid_from = $currentSchedule->valid_from->addWeek();
		$newSchedule->valid_to = $currentSchedule->valid_to->addWeek();
		$newSchedule->save();

		// Duplicate slots
		foreach ($currentSchedule->slots as $slot) {
			$newSlot = $slot->replicate();
			$newSlot->date = $slot->date->addWeek();
			$newSlot->start_time = $slot->start_time->addWeek();
			$newSlot->end_time = $slot->end_time->addWeek();
			$newSlot->schedule_id = $newSchedule->id;
			$newSlot->save();
		}

		return $newSchedule;
	}
}