<div class="col-6 col-md-4 col-lg-3">
  <div class="product-card">

    <div class="product-img-wrap">
      <img src="{{ asset('storage/' . $product->image) }}" alt="">
    </div>

    <div class="product-info">

      <p class="product-brand">
        {{ $product->brand->name ?? 'No Brand' }}
      </p>

      <h3 class="product-name">
        {{ $product->en_name }}
      </h3>

      <div class="product-footer">
        <div class="product-price">
          ${{ $product->discounted_price ?? $product->price }}
        </div>
      </div>

    </div>

  </div>
</div>