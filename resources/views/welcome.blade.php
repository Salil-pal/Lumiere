@extends('front.layouts.app')

@section('content')
      <!-- ===================== HERO ===================== -->
  <section class="hero-section">
    <div class="hero-bg-shapes" aria-hidden="true">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
    </div>

    <div class="container-xl h-100">
      <div class="row align-items-center h-100 hero-row">

        <!-- Text Content -->
        <div class="col-lg-6 hero-content">
          <p class="hero-eyebrow">
            <span class="eyebrow-dot"></span> New Season Arrivals
          </p>
          <h1 class="hero-heading">
            Style That<br />
            <em>Speaks</em><br />
            For Itself.
          </h1>
          <p class="hero-sub">
            Curated collections that blend timeless elegance with
            contemporary edge. Up to <strong>40% off</strong> on selected pieces.
          </p>
          <div class="hero-ctas">
            <a href="#" class="btn-primary-lumiere">
              Shop Now <i class="bi bi-arrow-right"></i>
            </a>
            <a href="#" class="btn-ghost-lumiere">
              Explore Lookbook
            </a>
          </div>
          <div class="hero-stats">
            <div class="stat">
              <span class="stat-num">12K+</span>
              <span class="stat-label">Products</span>
            </div>
            <div class="stat-sep"></div>
            <div class="stat">
              <span class="stat-num">98%</span>
              <span class="stat-label">Happy Customers</span>
            </div>
            <div class="stat-sep"></div>
            <div class="stat">
              <span class="stat-num">Free</span>
              <span class="stat-label">Shipping</span>
            </div>
          </div>
        </div>

        <!-- Hero Visual -->
        <div class="col-lg-6 hero-visual d-none d-lg-flex">
          <div class="hero-card hero-card--main">
                <img src="front/asset/img/hero.jpg" alt="">
            <div class="hero-card-badge">
              <i class="bi bi-fire"></i> Trending
            </div>
          </div>

          <!-- Floating accent cards -->
          <div class="floating-card floating-card--offer">
            <i class="bi bi-tag-fill"></i>
            <div>
              <p class="fc-title">Summer Sale</p>
              <p class="fc-sub">Ends in 2 days</p>
            </div>
          </div>
          <div class="floating-card floating-card--rating">
            <div class="stars">★★★★★</div>
            <p class="fc-sub">4.9 from 8,400 reviews</p>
          </div>
        </div>

      </div>
    </div>

    <!-- Scroll indicator -->
    <div class="hero-scroll-hint">
      <span>Scroll</span>
      <div class="scroll-line"></div>
    </div>
  </section>
  <!-- ===================== END HERO ===================== -->

    <main id="main-content">
      <!-- ===================== All Products ===================== -->
    <section class="products-section">
      <div class="container-xl">

        <div class="section-header d-flex align-items-end justify-content-between flex-wrap gap-4">
          <div>
            <p class="section-eyebrow">Hand-Picked</p>
            <h2 class="section-title mb-0">Products</h2>
          </div>

          <a href="{{ route('shop') }}" class="view-all-link">
            View All <i class="bi bi-arrow-right"></i>
          </a>
        </div>

        <div class="row g-4 mt-1">

          @foreach($products as $product)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card">

              <div class="product-img-wrap">

                <img src="{{ asset('storage/' . $product->image) }}" alt="">

                <div class="product-overlay">
                  <button class="quick-view-btn">
                    <i class="bi bi-eye"></i> Quick View
                  </button>
                </div>

                {{-- BADGE --}}
                @if($product->discount > 0)
                  <span class="product-badge product-badge--sale">
                    -{{ $product->discount }}%
                  </span>
                @elseif($product->created_at->diffInDays() < 7)
                  <span class="product-badge product-badge--new">New</span>
                @endif

                <button class="wishlist-btn">
                  <i class="bi bi-heart"></i>
                </button>

              </div>

              <div class="product-info">

                {{-- BRAND --}}
                <p class="product-brand">
                  {{ $product->brand->name ?? 'No Brand' }}
                </p>

                {{-- NAME --}}
                <h3 class="product-name">
                  {{ $product->en_name }}
                </h3>

                {{-- PRICE --}}
                <div class="product-footer">

                  <div class="product-price">
                    <span class="price-current">
                      ${{ $product->discounted_price ?? $product->price }}
                    </span>

                    @if($product->discount > 0)
                      <span class="price-old">
                        ${{ $product->price }}
                      </span>
                    @endif
                  </div>

                  <button class="add-cart-btn" data-id="{{ $product->id }}">
                    <i class="bi bi-bag-plus"></i>
                  </button>

                </div>

              </div>

            </div>
          </div>
          @endforeach

        </div>
      </div>
    </section>
      <!-- ===================== End All Products ===================== -->
      
    <!-- ===================== CATEGORIES ===================== -->
    <section class="categories-section">
      <div class="container-xl">

        <div class="section-header text-center">
          <p class="section-eyebrow">Browse By</p>
          <h2 class="section-title">Shop Categories</h2>
          <p class="section-sub">Find exactly what you're looking for across our curated collections.</p>
        </div>

        <div class="row g-4 justify-content-center">

          @foreach($categories as $category)
          <div class="col-6 col-md-4 col-lg-3 col-xl-2">

            <a href="{{ route('shop', ['category' => $category->id]) }}" class="cat-card">

              <div class="cat-icon-wrap"
                  style="--cat-clr:#e8a045;--cat-bg:rgba(232,160,69,.12)">

                <i class="{{ $category->icon }}"></i>
              </div>

              <span class="cat-title">
                  {{ $category->en_category_name }}
              </span>

              <span class="cat-count">
                  {{ $category->products_count }} items
              </span>

            </a>

          </div>
          @endforeach

        </div>
      </div>
    </section>
    <!-- ===================== END CATEGORIES ===================== -->

    

    <!-- ===================== FEATURED PRODUCTS ===================== -->
    <section class="products-section">
      <div class="container-xl">

        <div class="section-header d-flex justify-content-between align-items-end flex-wrap gap-3">
          <div>
            <p class="section-eyebrow">Hand-Picked</p>
            <h2 class="section-title mb-0">Trending Products</h2>
          </div>

          <ul class="nav nav-pills mt-4 gap-2" id="productTabs" role="tablist">

          <li class="nav-item">
            <button class="filter-btn active" data-bs-toggle="tab" data-bs-target="#featured">
              Featured
            </button>
          </li>

          <li class="nav-item">
            <button class="filter-btn" data-bs-toggle="tab" data-bs-target="#new">
              New Arrival
            </button>
          </li>

          <li class="nav-item">
            <button class="filter-btn" data-bs-toggle="tab" data-bs-target="#best">
              Best Selling
            </button>
          </li>

          <li class="nav-item">
            <button class="filter-btn" data-bs-toggle="tab" data-bs-target="#sale">
              On Sale
            </button>
          </li>

        </ul>
        </div>

        <!-- NAV BUTTONS -->
        

        <!-- TAB CONTENT -->
        <div class="tab-content mt-4">

          <!-- FEATURED -->
          <div class="tab-pane fade show active" id="featured">
            <div class="row g-4">
              @foreach($featuredProducts as $product)
                @include('front.layouts.partials.product-card', ['product' => $product])
              @endforeach
            </div>
          </div>

          <!-- NEW ARRIVAL -->
          <div class="tab-pane fade" id="new">
            <div class="row g-4">
              @foreach($newProducts as $product)
                @include('front.layouts.partials.product-card', ['product' => $product])
              @endforeach
            </div>
          </div>

          <!-- BEST SELLING -->
          <div class="tab-pane fade" id="best">
            <div class="row g-4">
              @foreach($bestProducts as $product)
                @include('front.layouts.partials.product-card', ['product' => $product])
              @endforeach
            </div>
          </div>

          <!-- ON SALE -->
          <div class="tab-pane fade" id="sale">
            <div class="row g-4">
              @foreach($saleProducts as $product)
                @include('front.layouts.partials.product-card', ['product' => $product])
              @endforeach
            </div>
          </div>

        </div>

      </div>
    </section>
    <!-- ===================== END FEATURED PRODUCTS ===================== -->


    <!-- ===================== PROMO BANNER ===================== -->
    <section class="promo-section">
      <div class="container-xl">
        <div class="promo-banner">

          <!-- Background shapes -->
          <div class="promo-shape promo-shape--1" aria-hidden="true"></div>
          <div class="promo-shape promo-shape--2" aria-hidden="true"></div>
          <div class="promo-shape promo-shape--3" aria-hidden="true"></div>

          <!-- Content -->
          <div class="promo-content">
            <p class="promo-eyebrow">
              <i class="bi bi-lightning-charge-fill"></i>
              Limited Time Offer
            </p>
            <div class="promo-discount">
              <span class="discount-num">50</span>
              <span class="discount-pct">%<br/>OFF</span>
            </div>
            <h2 class="promo-heading">Summer Mega Sale</h2>
            <p class="promo-sub">
              Shop the season's best styles at half the price. New drops added daily — don't miss out.
            </p>
            <div class="promo-ctas">
              <a href="#" class="btn-primary-lumiere">
                Grab the Deal <i class="bi bi-arrow-right"></i>
              </a>
              <div class="promo-countdown">
                <div class="countdown-unit"><span id="cd-h">08</span><small>Hrs</small></div>
                <div class="countdown-sep">:</div>
                <div class="countdown-unit"><span id="cd-m">34</span><small>Min</small></div>
                <div class="countdown-sep">:</div>
                <div class="countdown-unit"><span id="cd-s">12</span><small>Sec</small></div>
              </div>
            </div>
          </div>

          <!-- Visual -->
          <div class="promo-visual" aria-hidden="true">
            <div class="promo-tag-stack">
              <div class="promo-tag promo-tag--lg">
                <i class="bi bi-tag-fill"></i>
                <span>SALE</span>
              </div>
              <div class="promo-tag promo-tag--sm">
                <i class="bi bi-bag-fill"></i>
              </div>
              <div class="promo-ring"></div>
              <div class="promo-dots"></div>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- ===================== END PROMO BANNER ===================== -->

  </main>
@endsection
