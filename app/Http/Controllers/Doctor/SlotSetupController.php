<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreScheduleRequest;
use App\Services\SlotGeneratorService;
use Illuminate\Http\Request;

class SlotSetupController extends Controller
{
  protected $slotGenerator;

  public function __construct(SlotGeneratorService $slotGenerator)
  {
    // $this->middleware('auth');
    // $this->middleware('role:doctor');
    // $this->middleware('doctor.first.login')->only(['create', 'store']);

    $this->slotGenerator = $slotGenerator;
  }

  public function create()
  {
    return view('doctor.slots.setup');
  }

  public function store(StoreScheduleRequest $request)
  {
    $doctor = auth()->user()->doctor;

    $this->slotGenerator->generateSlots($doctor, $request->validated());

    return redirect()->route('doctor.dashboard')
      ->with('success', 'Schedule created successfully!');
  }
}