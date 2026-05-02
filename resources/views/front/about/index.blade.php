@extends('front.layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="py-5" style="background: var(--clr-bg);">
    <div class="container text-center">
        <h1 class="fw-bold">{{ $about->title ?? 'About Us' }}</h1>
        <p class="mt-3 mx-auto">
            {{ $about->short_description }}
        </p>
    </div>
</section>

<!-- MAIN CONTENT -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- IMAGE -->
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $about->image) }}" class="img-fluid rounded-4 shadow" alt="About Image">
            </div>

            <!-- TEXT -->
            <div class="col-md-6">
                <h2 class="mb-3">Our Story</h2>
                <p class="text-muted">
                    {{ $about->description }}
                </p>

                <div class="mt-4">
                    <a href="{{ route('shop') }}" class="btn-primary-lumiere">
                        Explore Products <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MISSION / VISION -->
<section class="py-5 bg-white border-top">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="p-4 rounded-4 border h-100">
                    <h4>{{ $about->mission_title ?? 'Our Mission' }}</h4>
                    <p class="text-muted mb-0">
                        {{ $about->mission_text }}
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 rounded-4 border h-100">
                    <h4>{{ $about->vision_title ?? 'Our Vision' }}</h4>
                    <p class="text-muted mb-0">
                        {{ $about->vision_text }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- EXPERIENCE -->
<section class="py-5 text-center" style="background: var(--clr-bg);">
    <div class="container">
        <h2 class="fw-bold">{{ $about->experience_years ?? '10+' }}</h2>
        <p class="text-muted mx-auto">Years of Trusted Experience</p>
    </div>
</section>

@endsection