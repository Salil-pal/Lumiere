<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\StripeService;

class StripeController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Stripe checkout
     */
    public function checkout($orderId)
    {
        $order = Order::findOrFail($orderId);

        $session = $this->stripeService
            ->createCheckoutSession($order);

        return redirect($session->url);
    }

    /**
     * Success page
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('front.checkout.order-success', compact('order'));
    }
}