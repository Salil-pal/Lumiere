@extends('front.layouts.app')

@section('content')

<div class="container py-5 text-center">

    {{-- SUCCESS ICON --}}
    <div style="font-size:70px; color:green;">
        <i class="bi bi-check-circle-fill"></i>
    </div>

    <h2 class="mt-3">Order Placed Successfully 🎉</h2>

    <p class="text-muted mx-auto">
        Thank you! Your order has been received.
    </p>

    {{-- ORDER INFO --}}
    <div class="card mx-auto mt-4 p-4" style="max-width:500px;">

        <h5>Order Details</h5>

        <p><strong>Order ID:</strong> {{ $order->order_number }}</p>
        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    </div>

    {{-- BUTTONS --}}
    <div class="mt-4">

        <a href="{{ route('welcome.index') }}" class="btn btn-dark">
            Continue Shopping
        </a>

        <a href="" class="btn btn-outline-dark">
            View Products
        </a>

    </div>

</div>

@endsection