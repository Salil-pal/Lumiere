@extends('front.layouts.app')

@section('content')

<div class="container py-5">
    <div class="row g-4">

        {{-- ================= LEFT: BILLING + PAYMENT ================= --}}
        <div class="col-lg-7">

            <div class="card shadow-sm border-0 p-4">

                <h4 class="mb-4 fw-bold">Billing Details</h4>

                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <input type="text" name="name" class="form-control mb-3"
                        placeholder="Full Name" required>

                    <input type="email" name="email" class="form-control mb-3"
                        placeholder="Email Address" required>

                    <input type="text" name="phone" class="form-control mb-3"
                        placeholder="Phone Number" required>

                    <textarea name="address" class="form-control mb-4"
                        placeholder="Full Address" rows="3" required></textarea>

                    {{-- ================= PAYMENT SECTION ================= --}}
                    <div class="border rounded p-3 mb-4 bg-light">

                        <h5 class="mb-3">Payment Method</h5>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
                            <label class="form-check-label">
                                Cash on Delivery
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="stripe">
                            <label class="form-check-label">
                                Credit / Debit Card (Stripe)
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" value="paypal">
                            <label class="form-check-label">
                                PayPal
                            </label>
                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <button class="btn btn-dark w-100 py-2 fw-semibold">
                        Place Order
                    </button>

                </form>

            </div>

        </div>

        {{-- ================= RIGHT: ORDER SUMMARY ================= --}}
        <div class="col-lg-5">

            @php
                $cart = session('cart', []);

                $subtotal = 0;
                $totalItems = 0;

                foreach($cart as $item){
                    $subtotal += $item['price'] * $item['quantity'];
                    $totalItems += $item['quantity'];
                }

                $tax = $subtotal * 0.08;
                $grandTotal = $subtotal + $tax;
            @endphp

            <div class="card shadow-sm border-0 p-4">

                <h4 class="mb-4 fw-bold">Order Summary</h4>

                {{-- PRODUCTS --}}
                @foreach($cart as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <strong>${{ number_format($subtotal, 2) }}</strong>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <span>Tax (8%)</span>
                    <span>${{ number_format($tax, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <span>Shipping</span>
                    <span class="text-success">Free</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fs-5">
                    <strong>Total</strong>
                    <strong>${{ number_format($grandTotal, 2) }}</strong>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection