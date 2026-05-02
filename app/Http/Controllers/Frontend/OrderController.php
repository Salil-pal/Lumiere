<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;


class OrderController extends Controller
{
    public function trackForm()
    {
        return view('front.order-track.track-order');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required'
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        if(!$order){
            return back()->with('error', 'Order not found');
        }

        return view('front.order-track.track-result', compact('order'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
                        ->latest()
                        ->get();

        return view('front.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
                      ->with('items')
                      ->findOrFail($id);

        return view('front.orders.show', compact('order'));
    }
}