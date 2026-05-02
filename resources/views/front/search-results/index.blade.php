@extends('front.layouts.app')

@section('content')

<div class="container py-4">

<!-- SORT + INFO BAR -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

    <!-- LEFT: RESULTS INFO -->
    <div>
        <h4 class="mb-0">
            Search results for:
            "<span class="text-primary">{{ request('query') }}</span>"
        </h4>

        <p class="text-muted mb-0">
            {{ $products->total() }} products found
        </p>
    </div>

    <!-- RIGHT: SORT -->
    <form method="GET" class="d-flex align-items-center gap-2">

        <!-- keep filters -->
        <input type="hidden" name="query" value="{{ request('query') }}">

        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 180px;">

            <option value="">Sort By</option>

            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                Latest
            </option>

            <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>
                Price: Low → High
            </option>

            <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>
                Price: High → Low
            </option>

            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                Name A → Z
            </option>

        </select>

    </form>

</div>

    

    <!-- PRODUCTS GRID -->
    @if($products->count())
        <div class="row g-4">

                @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">

                    <div class="product-img-wrap">
                    <img src="{{ asset('front/asset/img/'.$product->image) }}" alt="">

                    <div class="product-overlay">
                        <button class="quick-view-btn">
                        <i class="bi bi-eye"></i> Quick View
                        </button>
                    </div>

                    {{-- Badge --}}
                    @if($product->is_new_arrival)
                        <span class="product-badge product-badge--new">New</span>
                    @elseif($product->is_onsale)
                        <span class="product-badge product-badge--sale">Sale</span>
                    @endif

                    <button class="wishlist-btn">
                        <i class="bi bi-heart"></i>
                    </button>
                    </div>

                    <div class="product-info">

                    {{-- Brand --}}
                    <p class="product-brand">
                        {{ $product->brand->name ?? 'No Brand' }}
                    </p>

                    {{-- Name --}}
                    <h3 class="product-name">
                        {{ $product->en_name }}
                    </h3>

                    {{-- Rating --}}
                    @php $rating = $product->review; @endphp

                    <div class="product-rating">
                        <span class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($rating))
                                ★
                            @elseif ($i - $rating < 1)
                                ☆
                            @else
                                ☆
                            @endif
                        @endfor
                        </span>
                        <span class="rating-count">
                        ({{ number_format($rating,1) }})
                        </span>
                    </div>

                    {{-- Price --}}
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

                        <button class="add-cart-btn" data-id="{{$product->id}}">
                        <i class="bi bi-bag-plus"></i>
                        </button>
                    </div>

                    </div>
                </div>
                </div>
            @endforeach

        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        
        <!-- EMPTY STATE -->
        <div class="text-center py-5">
            <h4>No products found 😕</h4>
            <p class="mx-auto">Try searching with different keywords</p>
        </div>

    @endif

</div>

@endsection