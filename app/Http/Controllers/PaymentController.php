<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Jobs\NotifyDoctorAndPatient;

class PaymentController extends Controller
{
  public function createPaymentIntent(Request $request)
  {
    if (!auth()->check()) {
      return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $request->validate(['appointment_id' => 'required|exists:appointments,id']);

    $appointment = Appointment::with('slot.doctor.user')
      ->where('id', $request->appointment_id)
      ->where('patient_id', auth()->id())
      ->where('status', 'pending')
      ->firstOrFail();

    Stripe::setApiKey(config('services.stripe.secret'));

    $amount = 10000; // $100.00 in cents (adjust as needed)

    $intent = PaymentIntent::create([
      'amount' => $amount,
      'currency' => 'usd',
      'metadata' => [
        'appointment_id' => $appointment->id,
        'user_id' => $appointment->patient_id,
        'transaction_id' => $appointment->slot->doctor->id ?? 'N/A',
      ],
      'description' => 'Appointment with Dr. ' . ($appointment->slot->doctor->user->name ?? 'Unknown')
    ]);

    return response()->json([
      'client_secret' => $intent->client_secret,
      'appointment_id' => $appointment->id
    ]);
  }

  public function paymentSuccess(Request $request)
  {
    $request->validate([
      'appointment_id' => 'required|exists:appointments,id',
      'payment_intent_id' => 'required|string'
    ]);

    try {
      $appointment = Appointment::with('slot.doctor.user')
        ->where('id', $request->appointment_id)
        ->where('patient_id', auth()->id())
        ->where('status', 'pending')
        ->firstOrFail();

      Stripe::setApiKey(config('services.stripe.secret'));
      $intent = PaymentIntent::retrieve($request->payment_intent_id);

      if ($intent->status !== 'succeeded' || $intent->metadata['appointment_id'] != $appointment->id) {
        return response()->json([
          'success' => false,
          'message' => 'Payment verification failed'
        ], 400);
      }

      DB::transaction(function () use ($appointment, $intent) {
        $appointment->status = 'accepted';
        $appointment->save();

        if ($appointment->slot) {
          $appointment->slot->is_booked = 1;
          $appointment->slot->status = 'booked';
          $appointment->slot->save();
        }

        Payment::create([
          'user_id' => auth()->id(),
          'appointment_id' => $appointment->id,
          'transaction_id' => $intent->id,
          'amount' => $intent->amount / 100,
          'payment_method' => 'stripe',
          'status' => 'success'
        ]);
      });

      dispatch(new NotifyDoctorAndPatient($appointment));

      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      \Log::error('Payment Success Error: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'Something went wrong while confirming your payment.'
      ], 500);
    }
  }

}
