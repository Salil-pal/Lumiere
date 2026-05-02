@extends('front.layouts.app')

@section('content')

<div class="container py-5">

    <h2 class="mb-4">Order Details</h2>

    {{-- ORDER INFO --}}
    <div class="card p-4 mb-4">
        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
    </div>

    {{-- PRODUCTS --}}
    <div class="card p-4">
        <h5>Products</h5>

        @foreach($order->items as $item)
            <div class="d-flex justify-content-between border-bottom py-2">
                <span>
                    {{ $item->product_name }} (x{{ $item->quantity }})
                </span>
                <span>
                    ${{ number_format($item->price * $item->quantity, 2) }}
                </span>
            </div>
        @endforeach
    </div>

</div>

@endsection