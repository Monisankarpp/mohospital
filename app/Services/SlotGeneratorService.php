<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Slot;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SlotGeneratorService
{
	public function generateSlotsForDoctor(Doctor $doctor, string $date): void
	{
		$date = Carbon::parse($date);
		$dayOfWeek = strtolower($date->englishDayOfWeek);

		$schedule = $doctor->getScheduleForDay($dayOfWeek);

		if (!$schedule || !$schedule->is_working) {
			return;
		}

		// Delete any existing available slots for this date
		Slot::where('doctor_id', $doctor->id)
			->where('date', $date->format('Y-m-d'))
			->where('status', 'available')
			->delete();

		$this->generateDailySlots($doctor, $schedule, $date);
	}

	protected function generateDailySlots(Doctor $doctor, DoctorSchedule $schedule, Carbon $date): void
	{
		$startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->start_time->format('H:i'));
		$endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->end_time->format('H:i'));

		$slotDuration = $schedule->slot_duration;
		$breakBetweenSlots = $schedule->break_between_slots;

		// Generate regular slots
		$this->generateTimeSlots($doctor, $date, $startTime, $endTime, $slotDuration, $breakBetweenSlots, $schedule);
	}

	protected function generateTimeSlots(Doctor $doctor, Carbon $date, Carbon $startTime, Carbon $endTime, int $slotDuration, int $breakBetweenSlots, DoctorSchedule $schedule): void
	{
		$currentSlotStart = $startTime->copy();

		// Handle lunch break if exists
		if ($schedule->lunch_start && $schedule->lunch_end) {
			$lunchStart = Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->lunch_start->format('H:i'));
			$lunchEnd = Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->lunch_end->format('H:i'));

			// Generate slots before lunch
			$this->createSlotsBetween($doctor, $currentSlotStart, $lunchStart, $slotDuration, $breakBetweenSlots, $date);

			// Create lunch break slot
			Slot::create([
				'doctor_id' => $doctor->id,
				'date' => $date,
				'start_time' => $lunchStart,
				'end_time' => $lunchEnd,
				'status' => 'break',
				'is_lunch_break' => true,
				'can_edit_until' => $lunchStart->copy()->subDay(),
			]);

			$currentSlotStart = $lunchEnd->copy();
		}

		// Generate slots after lunch (or all day if no lunch)
		$this->createSlotsBetween($doctor, $currentSlotStart, $endTime, $slotDuration, $breakBetweenSlots, $date);
	}

	protected function createSlotsBetween(Doctor $doctor, Carbon $start, Carbon $end, int $duration, int $break, Carbon $date): void
	{
		$period = CarbonPeriod::create($start, $duration + $break . ' minutes', $end);

		foreach ($period as $slotStart) {
			$slotEnd = $slotStart->copy()->addMinutes($duration);

			if ($slotEnd > $end) {
				break;
			}

			Slot::create([
				'doctor_id' => $doctor->id,
				'date' => $date,
				'start_time' => $slotStart,
				'end_time' => $slotEnd,
				'status' => 'available',
				'can_edit_until' => $slotStart->copy()->subDay(),
			]);
		}
	}
}