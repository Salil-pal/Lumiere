<!-- ===================== NAVBAR ===================== -->
<nav class="navbar navbar-expand-lg lumiere-nav sticky-top" id="mainNav">
  <div class="container-xl">

    <!-- Logo -->
    <a class="navbar-brand lumiere-logo" href="{{ route('welcome.index') }}">
      <span class="logo-mark">✦</span> Lumière
    </a>

    <!-- Mobile Right -->
    <div class="d-flex align-items-center gap-3 d-lg-none">

      <!-- Cart -->
      <a href="{{ route('cart.index') }}" class="nav-icon-btn">
        <i class="bi bi-bag"></i>
        <span class="cart-badge" >
          {{ array_sum(array_column(session('cart', []), 'quantity')) }}
        </span>
      </a>

      <!-- Hamburger -->
      <button class="hamburger-btn" type="button"
        data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span></span><span></span><span></span>
      </button>
    </div>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navMenu">

      <!-- Search -->
      <form action="{{ route('search') }}" method="GET" class="nav-search mx-auto">
        <div class="search-wrap">

          <select class="search-category" name="category">
            <option value="">All</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">
                {{ $category->en_category_name }}
              </option>
            @endforeach
          </select>

          <div class="search-divider"></div>

          <input 
            type="text" 
            name="query" 
            class="search-input" 
            placeholder="Search products..." 
          />

          <button type="submit" class="search-btn">
            <i class="bi bi-search"></i>
          </button>

        </div>
      </form>

      <!-- Right Actions -->
      <div class="nav-actions d-flex align-items-center gap-2">

        <!-- Wishlist -->
        <a href="#" class="nav-icon-btn">
          <i class="bi bi-heart"></i>
          <span class="wishlist-badge">0</span>
        </a>

        <!-- Cart Desktop -->
        <a href="{{ route('cart.index') }}" class="nav-icon-btn d-none d-lg-flex">
          <i class="bi bi-bag"></i>
          <span class="cart-badge" id="cart-count">
            {{ array_sum(array_column(session('cart', []), 'quantity')) }}
          </span>
        </a>

        <!-- AUTH -->
        @auth

        <div class="dropdown">
          <a class="nav-login-btn dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person"></i>
            {{ auth()->user()->name }}
          </a>

          <ul class="dropdown-menu dropdown-menu-end">

            <li>
              <a class="dropdown-item" href="{{ route('orders.my') }}">
                My Orders
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="{{ route('order.track') }}">
                Track Order
              </a>
            </li>

            <li><hr class="dropdown-divider"></li>

            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item text-danger">
                  Logout
                </button>
              </form>
            </li>

          </ul>
        </div>

        @else

        <a href="{{ route('login') }}" class="nav-login-btn">
          <i class="bi bi-person"></i>
          <span>Login</span>
        </a>

        @endauth

      </div>

    </div>
  </div>
</nav>
<!-- ===================== END NAVBAR ===================== -->

<!-- ================= SECONDARY NAV ================= -->
<div class="lumiere-secondary-nav">
  <div class="container-xl">

    <ul class="secondary-menu">

      <li>
        <a href="{{ route('welcome.index') }}"
           class="{{ request()->routeIs('welcome.index') ? 'active' : '' }}">
          Home
        </a>
      </li>

      <li>
        <a href="{{ route('shop') }}"
           class="{{ request()->routeIs('shop') ? 'active' : '' }}">
          Shop
        </a>
      </li>

      <li>
        <a href="{{route('about')}}">
          About
        </a>
      </li>

      <li>
        <a href="{{route('contact')}}">
          Contact
        </a>
      </li>

    </ul>

  </div>
</div>
<!-- ================= END SECONDARY NAV ================= -->