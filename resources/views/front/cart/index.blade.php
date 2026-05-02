@extends('front.layouts.app')

@section('content')
    <!-- ══════════════════════════════════════
        PAGE HEADER
    ══════════════════════════════════════ -->
    <div class="cart-header">
        <div class="container-xl">
        <div class="cart-header-inner">
            <div>
            <ol class="breadcrumb-list">
                <li><a href="index.html">Home</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="active">Shopping Cart</li>
            </ol>
            
            <h1 class="cart-page-title">
                Your Cart
                <span class="cart-item-chip" id="headerItemCount">
                  {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                </span>
            </h1>
            </div>
            <a href="shop.html" class="continue-shopping-link">
            <i class="bi bi-arrow-left"></i> Continue Shopping
            </a>
        </div>

        <!-- Progress Steps -->
        <div class="checkout-steps">
            <div class="step step--active">
            <div class="step-dot"><i class="bi bi-bag"></i></div>
            <span class="step-label">Cart</span>
            </div>
            <div class="step-line step-line--done"></div>
            <div class="step">
            <div class="step-dot"><i class="bi bi-person"></i></div>
            <span class="step-label">Details</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
            <div class="step-dot"><i class="bi bi-truck"></i></div>
            <span class="step-label">Shipping</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
            <div class="step-dot"><i class="bi bi-credit-card"></i></div>
            <span class="step-label">Payment</span>
            </div>
        </div>
        </div>
    </div>

      <!-- ══════════════════════════════════════
            MAIN CART LAYOUT
      ══════════════════════════════════════ -->
  <div class="cart-layout">
    <div class="container-xl">
      <div class="row g-0 cart-row">

        <!-- ══════════════════════════════
             LEFT — CART ITEMS
        ══════════════════════════════ -->
        <div class="col-lg-8 cart-items-col">

          <!-- Select All Bar -->
          <div class="cart-select-bar">

            
            <label class="select-all-label">
              <input type="checkbox" id="selectAll" />
              <span class="checkmark"></span>

              <span>
                  Select All (
                  <span id="selectedCount">
                    {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                  </span>
                  items)
              </span>
            </label>
            <button class="delete-selected-btn" id="deleteSelected">
              <i class="bi bi-trash3"></i> Remove Selected
            </button>
          </div>

          <!-- ── Cart Items List ───────────────────────── -->
          <div class="cart-items-list" id="cartItemsList">

                @php
                    $cart = session('cart', []);
                @endphp

                @if(count($cart) > 0)

                    @foreach($cart as $id => $item)

                    <div class="cart-item cart-selectable" id="cart-item-{{ $id }}" data-id="{{ $id }}">
                      <input type="checkbox" class="item-checkbox" data-id="{{ $id }}" hidden>
                        <!-- Image -->
                        <div class="item-img-wrap">
                            <img src="{{ asset('storage/'.$item['image']) }}" width="">
                        </div>

                        <!-- Details -->
                        <div class="item-details">

                            <div class="item-top">
                                <div>
                                    <h3 class="item-name">
                                        {{ $item['name'] }}
                                    </h3>
                                </div>

                                <!-- REMOVE -->
                                <button class="item-remove-btn"  data-id="{{ $id }}">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            <div class="item-bottom">

                                <!-- QUANTITY -->
                                <div class="item-qty-wrap">
                                    <button class="qty-btn" data-action="minus" data-id="{{ $id }}">-</button>

                                    <span class="qty-val" id="qty-{{ $id }}">
                                        {{ $item['quantity'] }}
                                    </span>

                                    <button class="qty-btn" data-action="plus" data-id="{{ $id }}">+</button>
                                </div>

                                <!-- PRICE -->
                                <div class="item-price-wrap">
                                    <span class="item-price-unit">
                                        ${{ $item['price'] }}
                                    </span>
                                </div>

                                <!-- SUBTOTAL -->
                                <div class="item-subtotal">
                                    <span id="sub-{{ $id }}">
                                        ${{ $item['price'] * $item['quantity'] }}
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                    @endforeach

                @else

                    <div class="empty-cart">
                        <h3>Your cart is empty</h3>
                    </div>

                @endif

            </div>
          <!-- end cart-items-list -->

          

        </div><!-- end cart-items-col -->

        <!-- ══════════════════════════════
             RIGHT — ORDER SUMMARY
        ══════════════════════════════ -->
        <div class="col-lg-4 cart-summary-col">
          <div class="order-summary" id="orderSummary">

            <h2 class="summary-title">Order Summary</h2>

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


            <!-- Line Items -->
            <div class="summary-lines">
              <div class="summary-line">
                <span>Subtotal (<span id="summaryItemCount">{{ $totalItems }}</span> items)</span>
                <span id="summarySubtotal">${{ $subtotal }}</span>
              </div>
              <div class="summary-line" id="discountLine" style="display:none">
                <span class="discount-label">
                  <i class="bi bi-tag-fill"></i>
                  Promo: <span id="couponCodeLabel"></span>
                </span>
                <span class="discount-val" id="discountVal">−$0.00</span>
              </div>
              <div class="summary-line">
                <span>Shipping</span>
                <span class="shipping-val" id="shippingVal">Free</span>
              </div>
              <div class="summary-line">
                <span>Estimated Tax (8%)</span>
                <span id="taxVal">{{ number_format($tax, 2) }}</span>
              </div>
            </div>

            <div class="summary-divider"></div>

            <!-- Total -->
            <div class="summary-total-row">
              <span class="total-label">Total</span>
              <span class="total-val" id="grandTotal">
                ${{ number_format($grandTotal, 2) }}
              </span>
            </div>


            <!-- Checkout CTA -->
            <a href="{{ route('checkout') }}" class="checkout-btn">
              <i class="bi bi-lock-fill"></i>
              Proceed to Checkout
              <span class="checkout-arrow">
                  <i class="bi bi-arrow-right"></i>
              </span>
            </a>


          </div><!-- end order-summary -->

        </div><!-- end cart-summary-col -->

      </div><!-- end row -->
    </div>
  </div><!-- end cart-layout -->
@endsection