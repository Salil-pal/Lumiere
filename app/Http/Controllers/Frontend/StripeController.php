<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout($orderId)
    {
        $order = Order::findOrFail($orderId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
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

        return redirect($session->url);
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);

        $order->update([
            'status' => 'paid'
        ]);

        return view('front.checkout.order-success', compact('order'));
    }
}
