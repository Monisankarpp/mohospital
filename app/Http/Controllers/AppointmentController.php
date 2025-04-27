<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Appointment;
use App\Notifications\PaymentReceipt;
use App\Notifications\NewAppointmentNotification;
use App\Models\Doctor;
use App\Services\StripeService;


// class AppointmentController extends Controller
// {
//     public function index()
//     {
//         $slots = Slot::with('doctor')->where('is_booked', false)->get();
//         return view('bookings.index', compact('slots'));
//     }

//     // public function store(Request $request, Slot $slot)
//     // {
//     //     $request->validate([
//     //         'doctor_id' => 'required|exists:doctors,id',
//     //         'appointment_date' => 'required|date',
//     //         'time_slot' => 'required|string',
//     //         'reason' => 'nullable|string',
//     //     ]);

//     //     $slot->is_booked = true;
//     //     $slot->save();

//     //     $appointment = Appointment::create([
//     //         'slot_id' => $slot->id,
//     //         'doctor_id' => $request->doctor_id,
//     //         'user_id' => auth()->id(),
//     //         'appointment_date' => $request->appointment_date,
//     //         'time_slot' => $request->time_slot,
//     //         'reason' => $request->reason,
//     //         'status' => 'pending',
//     //     ]);

//     //     return redirect()->route('appointments.show', $appointment)
//     //         ->with('success', 'Appointment booked successfully!');
//     // }


//     // app/Http/Controllers/AppointmentController.php


//     protected $stripe;

//     public function __construct(StripeService $stripe)
//     {
//         $this->stripe = $stripe;
//     }

//     public function book(Request $request)
//     {
//         $validated = $request->validate([
//             'doctor_id' => 'required|exists:doctors,id',
//             'date' => 'required|date',
//             'slot_id' => 'required|exists:time_slots,id',
//             'patient_notes' => 'nullable|string|max:500',
//             'payment_intent_id' => 'nullable|string',
//         ]);

//         try {
//             $doctor = Doctor::findOrFail($validated['doctor_id']);

//             if ($doctor->consultation_fee > 0) {
//                 $paymentIntent = $this->stripe->retrievePaymentIntent($validated['payment_intent_id']);
//                 if ($paymentIntent->status !== 'succeeded') {
//                     throw new \Exception('Payment not completed.');
//                 }
//             }

//             $appointment = Appointment::create([
//                 'user_id' => auth()->id(),
//                 'doctor_id' => $validated['doctor_id'],
//                 'date' => $validated['date'],
//                 'time_slot_id' => $validated['slot_id'],
//                 'notes' => $validated['patient_notes'],
//                 'payment_intent_id' => $validated['payment_intent_id'] ?? null,
//                 'status' => 'confirmed',
//             ]);

//             $user = auth()->user();
//             $user->notify(new PaymentReceipt($appointment));
//             $doctor->user->notify(new NewAppointmentNotification($appointment));

//             return redirect()->route('appointments.show', $appointment)
//                 ->with('success', 'Appointment booked successfully!');
//         } catch (\Exception $e) {
//             return back()->with('error', $e->getMessage())->withInput();
//         }
//     }
// }



