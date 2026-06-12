<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    protected $checkoutService;

    // Dependency Injection
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * Show checkout page
     */
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {

            return redirect()
                ->route('welcome.index')
                ->with('error', 'Cart is empty');
        }

        return view('front.checkout.index', compact('cart'));
    }

    /**
     * Store order
     */
    public function store(Request $request)
    {
        $cart = session('cart', []);

        // Prevent empty checkout
        if (empty($cart)) {

            return redirect()
                ->route('welcome.index')
                ->with('error', 'Cart is empty');
        }

        // Validation
        $request->validate([
            'name'           => 'required',
            'email'          => 'required|email',
            'phone'          => 'required',
            'address'        => 'required',
            'payment_method' => 'required',
        ]);

        // Create order through service
        $order = $this->checkoutService->createOrder($request, $cart);

        // Stripe payment
        if ($request->payment_method === 'stripe') {

            return redirect()->route('stripe.checkout', $order->id);
        }

        // PayPal payment
        if ($request->payment_method === 'paypal') {

            return redirect()->route('paypal.checkout', $order->id);
        }

        // COD / default success
        return redirect()->route('order.success', $order->id);
    }

    /**
     * Order success page
     */
    public function success($id)
    {
        $order = Order::findOrFail($id);

        return view('front.checkout.order-success', compact('order'));
    }
}