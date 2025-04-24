<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
  protected $stripe;

  public function __construct()
  {
    $this->stripe = new StripeClient(config('services.stripe.secret'));
  }

  public function createIntent(Request $request)
  {
    $request->validate([
      'doctor_id' => 'required|exists:doctors,id',
      'amount' => 'required|numeric|min:1',
    ]);

    try {
      $paymentIntent = $this->stripe->paymentIntents->create([
        'amount' => $request->amount,
        'currency' => 'usd',
        'automatic_payment_methods' => [
          'enabled' => true,
        ],
        'metadata' => [
          'doctor_id' => $request->doctor_id,
          'user_id' => Auth::id(),
        ],
      ]);

      return response()->json([
        'clientSecret' => $paymentIntent->client_secret
      ]);
    } catch (ApiErrorException $e) {
      return response()->json([
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function success(Request $request)
  {
    // Verify payment and complete appointment booking
    $paymentIntentId = $request->query('payment_intent');

    try {
      $paymentIntent = $this->stripe->paymentIntents->retrieve($paymentIntentId);

      if ($paymentIntent->status === 'succeeded') {
        // Get appointment data from session or database temp storage
        // Complete the appointment booking process

        return view('payment.success', [
          'appointment' => $appointment,
          'payment' => $paymentIntent
        ]);
      }

      return redirect()->route('appointments.index')->with('error', 'Payment not completed.');
    } catch (ApiErrorException $e) {
      return redirect()->route('appointments.index')->with('error', $e->getMessage());
    }
  }
}