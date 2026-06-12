<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if(empty($cart)){
            return redirect()->route('welcome.index')->with('error', 'Cart is empty');
        }

        return view('front.checkout.index', compact('cart'));
    }

    public function store(CheckoutRequest $request)
    {
        $cart = session('cart', []);

        // Prevent empty cart
        if (empty($cart)) {

            return redirect()
                ->route('welcome.index')
                ->with('error', 'Cart is empty');
        }

        // Calculate totals
        $total = 0;

        foreach ($cart as $item) {

            $total += $item['price'] * $item['quantity'];
        }

        $tax = $total * 0.08;

        $grandTotal = $total + $tax;

        // Create order
        $order = Order::create([

            'order_number'   => 'ORD-' . strtoupper(uniqid()),

            'user_id'        => auth()->id(),

            'name'           => $request->name,

            'email'          => $request->email,

            'phone'          => $request->phone,

            'address'        => $request->address,

            'total'          => $grandTotal,

            'status'         => 'pending',

            'payment_method' => $request->payment_method,
        ]);

        // Save order items
        foreach ($cart as $item) {

            OrderItem::create([

                'order_id'     => $order->id,

                'product_id'   => $item['product_id'],

                'product_name' => $item['name'],

                'price'        => $item['price'],

                'quantity'     => $item['quantity'],
            ]);
        }

        // COD payment
        if ($request->payment_method === 'cod') {

            // Mark as paid
            $order->update([
                'status' => 'paid',
            ]);

            // Fire event
            event(new \App\Events\OrderPaid($order->id));

            \Log::info('COD ORDER EVENT FIRED');
        }

        // Clear cart
        session()->forget('cart');

        // Stripe payment
        if ($request->payment_method === 'stripe') {

            return redirect()
                ->route('stripe.checkout', $order->id);
        }

        // PayPal payment
        if ($request->payment_method === 'paypal') {

            return redirect()
                ->route('paypal.checkout', $order->id);
        }

        // COD success page
        return redirect()
            ->route('order.success', $order->id);
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);

        return view('front.checkout.order-success', compact('order'));
    }
}
