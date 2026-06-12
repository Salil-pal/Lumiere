<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Webhook;
use App\Services\StripeService;

class StripeWebhookController extends Controller
{
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function handleWebhook(Request $request)
    {
        \Log::info('WEBHOOK CONTROLLER HIT');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\Exception $e) {
            \Log::error('Invalid Stripe webhook', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // ONLY handle checkout session
        if ($event->type === 'checkout.session.completed') {

            \Log::info('CHECKOUT SESSION COMPLETED');

            $session = $event->data->object;

            $this->stripeService->handleSuccessfulPayment($session);
        }

        return response()->json(['status' => 'success']);
    }
}