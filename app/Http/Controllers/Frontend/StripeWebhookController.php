<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Webhook;
use App\Models\Order;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // 🎯 PAYMENT SUCCESS EVENT
        if ($event->type == 'checkout.session.completed') {

            $session = $event->data->object;

            // 👇 we will pass order id here
            $orderId = $session->metadata->order_id;

            $order = Order::find($orderId);

            if ($order) {
                $order->update([
                    'status' => 'paid'
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
