<?php

namespace App\Services;

use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Events\OrderPaid;

class StripeService
{
    /**
     * Create Stripe Checkout Session
     */
    public function createCheckoutSession(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        return Session::create([

            'payment_method_types' => ['card'],

            'line_items' => [[

                'price_data' => [

                    'currency' => 'usd',

                    'product_data' => [
                        'name' => 'Order #' . $order->order_number,
                    ],

                    'unit_amount' => (int) ($order->total * 100),
                ],

                'quantity' => 1,
            ]],

            'mode' => 'payment',

            'metadata' => [
                'order_id' => $order->id,
            ],

            'success_url' => route('stripe.success', $order->id),

            'cancel_url' => route('checkout'),
        ]);
    }

    /**
     * Handle successful Stripe payment
     */
    public function handleSuccessfulPayment($session)
    {
        \Log::info('STRIPE SERVICE CALLED');

        // Get order ID from Stripe metadata
        $orderId = $session->metadata->order_id ?? null;

        if (!$orderId) {

            \Log::error('ORDER ID MISSING IN SESSION');

            return;
        }

        // Find order
        $order = Order::find($orderId);

        if (!$order) {

            \Log::error('ORDER NOT FOUND');

            return;
        }

        // Prevent duplicate webhook processing
        if ($order->status === 'paid') {

            \Log::info('DUPLICATE WEBHOOK IGNORED');

            return;
        }

        // Mark order as paid FIRST
        $order->update([
            'status' => 'paid',
        ]);

        \Log::info('ORDER MARKED AS PAID');

        // Fire event ONLY ONCE
        event(new OrderPaid($order->id));

        \Log::info('ORDER PAID EVENT FIRED');
    }
}