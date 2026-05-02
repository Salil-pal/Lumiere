@extends('front.layouts.app')

@section('content')

<!-- HERO -->
<section class="py-5 text-center">
    <div class="container">
        <h1 class="fw-bold">{{ $contact->title ?? 'Contact Us' }}</h1>
        <p class="mt-2 mx-auto">
            {{ $contact->description }}
        </p>
    </div>
</section>

<!-- CONTACT INFO -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <!-- LEFT INFO -->
            <div class="col-md-5">
                <div class="p-4 border rounded-4 h-100 shadow-sm">

                    <h4 class="mb-3">Get in Touch</h4>

                    <p class="mb-2">
                        📧 <strong>Email:</strong> {{ $contact->email }}
                    </p>

                    <p class="mb-2">
                        📞 <strong>Phone:</strong> {{ $contact->phone }}
                    </p>

                    <p class="mb-3">
                        📍 <strong>Address:</strong> {{ $contact->address }}
                    </p>

                    <a href="mailto:{{ $contact->email }}" class="btn-primary-lumiere mt-3">
                        Send Email
                    </a>

                </div>
            </div>

            <!-- RIGHT FORM -->
            <div class="col-md-7">
                <div class="p-4 border rounded-4 shadow-sm">

                    <h4 class="mb-3">Send a Message</h4>

                    <form method="POST" action="#">
                        @csrf

                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>

                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your Email">
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Your Message"></textarea>
                        </div>

                        <button type="submit" class="btn-primary-lumiere">
                            Send Message
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- MAP -->
@if($contact->map_embed)
<section class="pb-5">
    <div class="container">

        <div class="rounded-4 overflow-hidden shadow" style="width:100%; height:400px;">

            <div style="width:100%; height:100%;">
                {!! str_replace(
                    '<iframe',
                    '<iframe style="width:100%; height:100%; border:0;"',
                    $contact->map_embed
                ) !!}
            </div>

        </div>

    </div>
</section>
@endif

@endsection