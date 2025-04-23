<?php
// app/Http/Controllers/Doctor/ScheduleController.php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use App\Services\SlotGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Slot;

class ScheduleController extends Controller
{
  use AuthorizesRequests;

  protected $slotGenerator;

  public function __construct(SlotGeneratorService $slotGenerator)
  {
    // $this->middleware('auth');
    // $this->middleware('role:doctor');
    $this->slotGenerator = $slotGenerator;
  }

  public function index()
  {
    $doctor = auth()->user()->doctor;
    $currentSchedule = $doctor->currentSchedule();
    $slots = $currentSchedule
      ? $currentSchedule->slots()->with('appointment')->orderBy('date')->orderBy('start_time')->get()
      : collect();
    return view('doctor.slots.index', compact('currentSchedule', 'slots'));
  }

  public function edit(Slot $slot)
  {
    $this->authorize('update', $slot);

    if (!$slot->isEditable()) {
      return redirect()->back()
        ->with('error', 'Slot cannot be modified as it is either booked or within 24 hours');
    }

    return view('doctor.slots.edit', compact('slot'));
  }

  public function update(Request $request, Slot $slot)
  {
    $this->authorize('update', $slot);

    if (!$slot->isEditable()) {
      return redirect()->back()
        ->with('error', 'Slot cannot be modified as it is either booked or within 24 hours');
    }

    $validated = $request->validate([
      'start_time' => 'required|date_format:H:i',
      'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    $slot->update([
      'start_time' => $slot->date->format('Y-m-d') . ' ' . $validated['start_time'],
      'end_time' => $slot->date->format('Y-m-d') . ' ' . $validated['end_time'],
    ]);

    return redirect()->route('doctor.schedule.index')
      ->with('success', 'Slot updated successfully!');
  }

  public function destroy(Slot $slot)
  {
    $this->authorize('delete', $slot);

    if (!$slot->isEditable()) {
      return redirect()->back()
        ->with('error', 'Slot cannot be deleted as it is either booked or within 24 hours');
    }

    $slot->delete();

    return redirect()->route('doctor.schedule.index')
      ->with('success', 'Slot deleted successfully!');
  }

  public function confirmReuseSchedule(Request $request)
  {
    $doctor = auth()->user()->doctor;
    $currentSchedule = $doctor->currentSchedule();

    if ($request->reuse_schedule) {
      $this->slotGenerator->duplicateScheduleForNextWeek($currentSchedule);

      return redirect()->route('doctor.dashboard')
        ->with('success', 'Schedule reused for next week!');
    }

    return redirect()->route('doctor.slots.setup')
      ->with('info', 'Please set up your new schedule for next week');
  }
}