@extends('front.layouts.app')

@section('content')

<div class="container py-5 text-center">

    <h2>Track Your Order</h2>

    @if(session('error'))
        <p class="text-danger">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('order.track') }}" class="mt-4">
        @csrf

        <input type="text" name="order_number"
            class="form-control mb-3"
            placeholder="Enter your Order Number (e.g. ORD-XXXX)"
            required>

        <button class="btn btn-dark">
            Track Order
        </button>
    </form>

</div>

@endsection