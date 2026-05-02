@extends('front.layouts.app')

@section('content')

<div class="container py-5">
    <div class="col-md-5 mx-auto">

        <h3 class="mb-4 text-center">Login</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" placeholder="Email"
                class="form-control mb-3" required>

            <input type="password" name="password" placeholder="Password"
                class="form-control mb-3" required>

            <button class="btn btn-dark w-100">Login</button>
        </form>

        <!-- 👇 REGISTER LINK -->
        <p class="text-center mt-3">
            Don't have an account?
            <a href="{{ route('register') }}">Register</a>
        </p>

    </div>
</div>

@endsection