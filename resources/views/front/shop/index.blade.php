@extends('front.layouts.app')

@section('content')

<!-- ── SHOP PAGE BREADCRUMB ────────────────────────────────── -->
<div class="shop-breadcrumb">
  <div class="container-xl">
    <nav>
      <ol class="breadcrumb-list">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><i class="bi bi-chevron-right"></i></li>
        <li class="active">{{ $categoryName ?? 'Shop' }}</li>
      </ol>
    </nav>

    <div class="shop-hero-text">
      <h1 class="shop-page-title">
        {{ $categoryName ?? 'All Products' }}
      </h1>
      <p class="shop-page-sub">
        Discover our collection — {{ $products->total() }} items
      </p>
    </div>
  </div>
</div>

<!-- ── MAIN SHOP LAYOUT ────────────────────────────────────── -->
<div class="shop-layout">
  <div class="container-xl">
    <div class="row g-0 shop-row">

      <!-- ════════════════════════════════════════════════════
           SIDEBAR
      ════════════════════════════════════════════════════ -->
      <aside class="col-lg-3 shop-sidebar">
        <div class="sidebar-inner">

          <div class="sidebar-head">
            <span class="sidebar-title">
              <i class="bi bi-sliders2"></i> Filters
            </span>
          </div>

          <!-- CATEGORY FILTER -->
          <div class="filter-group">
            <button class="filter-group-toggle">
              Category
              <i class="bi bi-chevron-up toggle-icon"></i>
            </button>

            <div class="filter-group-body">
              <div class="filter-options">

                @foreach($categories as $cat)
                <label class="filter-check">
                  <input type="checkbox"
                    onchange="window.location.href='{{ route('shop', ['category'=>$cat->id]) }}'"
                    {{ request('category') == $cat->id ? 'checked' : '' }}>

                  <span class="checkmark"></span>
                  <span class="check-label">{{ $cat->en_category_name }}</span>
                  <span class="check-count">{{ $cat->products_count }}</span>
                </label>
                @endforeach

              </div>
            </div>
          </div>

        </div>
      </aside>

      <!-- ════════════════════════════════════════════════════
           PRODUCTS
      ════════════════════════════════════════════════════ -->
      <div class="col-lg-9 shop-main">

        <!-- ── Toolbar ─────────────────────────────────── -->
        <div class="shop-toolbar">
          <div class="toolbar-left">
            <p class="result-label">
              Showing {{ $products->firstItem() }}–{{ $products->lastItem() }}
              of {{ $products->total() }} results
            </p>
          </div>

          <div class="toolbar-right">

            <!-- Sort -->
            <div class="sort-wrap">
              <label class="sort-label">Sort:</label>

              <select class="sort-select"
                onchange="updateSort(this.value)">

                <option value="">Featured</option>

                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>
                    Price: Low to High
                </option>

                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>
                    Price: High to Low
                </option>

            </select>
            </div>

          </div>
        </div>

        <!-- ── Product Grid ────────────────────────────── -->
        <div class="product-grid">

          @forelse($products as $product)

          <div class="product-card">

            <div class="product-img-wrap">
              <img src="{{ asset('storage/' . $product->image) }}" alt="">

              <div class="product-overlay">
                <button class="quick-view-btn">
                  <i class="bi bi-eye"></i> Quick View
                </button>
              </div>

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

              <p class="product-brand">
                {{ $product->brand->name ?? 'No Brand' }}
              </p>

              <h3 class="product-name">
                {{ $product->en_name }}
              </h3>

              @php $rating = $product->review ?? 0; @endphp

              <div class="product-rating">
                <span class="rating-stars">
                  @for ($i=1;$i<=5;$i++)
                    {{ $i <= floor($rating) ? '★' : '☆' }}
                  @endfor
                </span>
                <span class="rating-count">
                  ({{ number_format($rating,1) }})
                </span>
              </div>

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

          @empty

          <!-- EMPTY -->
          <div class="no-results">
            <div class="no-results-inner">
              <i class="bi bi-search"></i>
              <h3>No products found</h3>
              <p>Try different filters</p>
            </div>
          </div>

          @endforelse

        </div>

        <!-- ── Pagination ───────────────────────────────── -->
        <div class="shop-pagination mt-4">
          {{ $products->links() }}
        </div>

      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function updateSort(value) {
    let url = new URL(window.location.href);

    if (value) {
        url.searchParams.set('sort', value);
    } else {
        url.searchParams.delete('sort');
    }

    window.location.href = url.toString();
}
</script>
@endpush