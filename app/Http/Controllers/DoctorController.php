<?php
namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Slot;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DoctorMessageMail;
use App\Jobs\SendDoctorMessageEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


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
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'slot_id' => 'required|exists:slots,id',
            'patient_notes' => 'nullable|string'
        ]);

        // Check slot availability
        $slot = Slot::where('id', $validated['slot_id'])
            ->where('doctor_id', $validated['doctor_id'])
            ->where('date', $validated['date'])
            ->where('status', 'available')
            ->first();

        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Selected slot is no longer available.'
            ], 400);
        }
        $appointment = DB::transaction(function () use ($validated, $slot) {
            $appointment = Appointment::create([
                'patient_id' => auth()->id(),
                'doctor_id' => $validated['doctor_id'],
                'slot_id' => $validated['slot_id'],
                'patient_notes' => $validated['patient_notes'] ?? null,
                'status' => 'pending',
                // 'fee' => $slot->fee,
                // 'expires_at' => now()->addMinutes(30)
            ]);

            $slot->update(['status' => 'booked']);
            return $appointment;
        });


        return response()->json([
            'success' => true,
            'appointment_id' => $appointment->id
        ]);
    }

    public function messagePatient($patient_id)
    {
        $patient = User::findOrFail($patient_id);

        SendDoctorMessageEmail::dispatch($patient); // Queued job

        return redirect()->back()->with('success', 'Message is being sent to the patient.');
    }


}