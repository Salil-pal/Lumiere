<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;

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

    public function store(Request $request)
    {

        $cart = session('cart', []);

        if(empty($cart)){
            return redirect()->route('welcome.index')->with('error', 'Cart is empty');
        }

        // 🔒 Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required'
        ]);

        // Calculate total
        $total = 0;

        foreach($cart as $item){
            $total += $item['price'] * $item['quantity'];
        }

        $tax = $total * 0.08;
        $grandTotal = $total + $tax;

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $grandTotal,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Save order items (FIXED)
        foreach($cart as $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'] ?? null,
                'product_name' => $item['name'] ?? 'Unknown Product',
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        // Redirect based on payment method
        if ($request->payment_method === 'stripe') {
            return redirect()->route('stripe.checkout', $order->id);
        }

        if ($request->payment_method === 'paypal') {
            return redirect()->route('paypal.checkout', $order->id);
        }

        return redirect()->route('order.success', $order->id);
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);

        return view('front.checkout.order-success', compact('order'));
    }
}
