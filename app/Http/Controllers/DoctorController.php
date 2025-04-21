<?php
namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Slot;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        // Get doctors with their user information
        $doctors = Doctor::join('users', 'doctors.user_id', '=', 'users.id')
            ->where('users.role', 'doctor')
            ->when($request->search, function ($query) use ($request) {
                return $query->where('users.name', 'like', '%' . $request->search . '%')
                    ->orWhere('doctors.specialization', 'like', '%' . $request->search . '%');
            })
            ->when($request->specialization, function ($query) use ($request) {
                return $query->where('doctors.specialization', $request->specialization);
            })
            ->when($request->status !== null, function ($query) use ($request) {
                return $query->where('doctors.status', $request->status);
            })
            ->select('users.*', 'doctors.*', 'doctors.id as doctor_id')
            ->paginate(9);

        // Get all unique specializations for the filter dropdown
        $specializations = Doctor::distinct()->pluck('specialization')->toArray();
        $slots = Slot::with('doctor')->where('is_booked', false)->get();


        return view('welcome', compact('doctors', 'specializations', 'slots'));
    }

    public function show($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);
        return view('welcome', compact('doctor'));
    }

    public function getAvailableDates(Doctor $doctor)
    {
        $slots = $doctor->slots()
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($slot) {
                return Carbon::parse($slot->start_time)->toDateString(); // Group by date
            });

        $dates = $slots->keys()->values();

        $slotsByDate = [];

        foreach ($slots as $date => $dateSlots) {
            $slotsByDate[$date] = $dateSlots->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
                    'status' => $slot->is_booked, //'status' indicates if the slot is booked
                ];
            });
        }

        return response()->json([
            'dates' => $dates,
            'slots' => $slotsByDate,
        ]);
    }
    public function book(Request $request)
    {
        // Validate the request data
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'slot_id' => 'required|exists:slots,id',
        ]);

        // Ensure the slot belongs to the selected doctor and is available
        $slot = Slot::where('id', $request->slot_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('is_booked', 0)
            ->first();

        if (!$slot) {
            return back()->withErrors('Selected slot is no longer available.');
        }

        // Create the appointment
        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'slot_id' => $request->slot_id,
            'status' => 'accepted',
        ]);

        // Mark the slot as booked
        $slot->update(['is_booked' => 1]);

        // Return success message
        return redirect()->back()->with('success', 'Appointment booked successfully.');
    }

}