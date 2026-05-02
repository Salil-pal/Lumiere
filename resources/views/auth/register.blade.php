@extends('front.layouts.app')

@section('content')

<div class="container py-5">
    <div class="col-md-5 mx-auto">

        <h3 class="text-center">Register</h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="text" name="name" placeholder="Name" class="form-control mb-3">
            <input type="email" name="email" placeholder="Email" class="form-control mb-3">
            <input type="password" name="password" placeholder="Password" class="form-control mb-3">

            <button class="btn btn-dark w-100">Register</button>
        </form>
    </div>
</div>

@endsection