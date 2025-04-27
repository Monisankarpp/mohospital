<?php

// app/Console/Commands/HandleStripeWebhooks.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\StripeClient;
use App\Models\Appointment;

class HandleStripeWebhooks extends Command
{
    protected $signature = 'stripe:webhook';
    protected $description = 'Handle Stripe webhook calls';

    public function handle()
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;
            case 'radar.rule.triggered':
                $this->handleRadarRuleTriggered($event->data->object);
                break;
        }

        return response()->json(['success' => true]);
    }

    protected function handlePaymentSucceeded($paymentIntent)
    {
        // Handle successful payment (already handled in your controller)
    }

    protected function handleRadarRuleTriggered($rule)
    {
        $paymentIntentId = $rule->object->payment_intent ?? null;

        if ($paymentIntentId && $rule->rule->action === 'block') {
            $appointment = Appointment::where('payment_intent_id', $paymentIntentId)->first();

            if ($appointment) {
                $appointment->update([
                    'status' => 'fraud_review',
                    'fraud_details' => json_encode($rule)
                ]);

                // Notify admin about potential fraud
                // You can create another notification class for this
            }
        }
    }
}
