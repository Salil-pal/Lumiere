@extends('front.layouts.app')

@section('content')

<div class="container py-5">
    <h2>My Orders</h2>

    @forelse($orders as $order)
        <div class="card mb-3 p-3">
            <p><strong>Order:</strong> {{ $order->order_number }}</p>
            <p><strong>Total:</strong> ${{ $order->total }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>

            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-dark">
                View Details
            </a>
        </div>
    @empty
        <p>No orders found</p>
    @endforelse
</div>

@endsection