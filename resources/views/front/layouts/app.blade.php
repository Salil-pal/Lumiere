<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lumière — Premium Shop</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  {{-- csrf tokens --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="{{ asset('front/asset/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('front/asset/css/cart.css') }}" />
  <link rel="stylesheet" href="{{ asset('front/asset/css/shop.css') }}" />
</head>
<body>

    @include('front.layouts.partials.header')

    @yield('content')

    @include('front.layouts.partials.footer')

    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- ============================= --}}
{{-- CART JAVASCRIPT (CLEAN VERSION) --}}
{{-- ============================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // ADD TO CART
    // =========================
    document.querySelectorAll('.add-cart-btn').forEach(button => {

        button.addEventListener('click', function () {

            let productId = this.dataset.id;

            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id: productId })
            })
            .then(res => res.json())
            .then(data => {

                updateCartUI(data.count);

                alert("Added to cart");
            });

        });

    });

    // =========================
    // UPDATE QUANTITY
    // =========================
    document.addEventListener("click", function (e) {

        if (e.target.closest(".qty-btn")) {

            let btn = e.target.closest(".qty-btn");

            let id = btn.dataset.id;
            let action = btn.dataset.action;

            fetch("{{ route('cart.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id: id,
                    action: action
                })
            })
            .then(res => res.json())
            .then(data => {

                document.getElementById('qty-' + id).innerText = data.quantity;
                document.getElementById('sub-' + id).innerText = '$' + Number(data.subtotal).toFixed(2);

                document.getElementById('summarySubtotal').innerText = '$' + Number(data.total).toFixed(2);

                let tax = data.total * 0.08;
                document.getElementById('taxVal').innerText = '$' + tax.toFixed(2);

                let grand = data.total + tax;
                document.getElementById('grandTotal').innerText = '$' + grand.toFixed(2);

                document.getElementById('summaryItemCount').innerText = data.count;
                updateCartUI(data.count);
            });
        }
    });

    // =========================
    // REMOVE SINGLE ITEM
    // =========================
    document.addEventListener("click", function (e) {

        if (e.target.closest(".item-remove-btn")) {

            let btn = e.target.closest(".item-remove-btn");
            let id = btn.dataset.id;

            fetch("{{ route('cart.remove') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id: id })
            })
            .then(res => res.json())
            .then(data => {

                document.getElementById('cart-item-' + id).remove();

                updateTotals(data);

                if (data.count == 0) {
                    document.getElementById('cartItemsList').innerHTML =
                        '<h3>Your cart is empty</h3>';
                }

                updateSelectedCount();
            });
        }

    });

    // =========================
    // CLICK ITEM TO SELECT
    // =========================
    document.addEventListener('click', function (e) {

        let item = e.target.closest('.cart-selectable');

        if (!item) return;

        // ignore buttons
        if (e.target.closest('.qty-btn') || e.target.closest('.item-remove-btn')) {
            return;
        }

        let checkbox = item.querySelector('.item-checkbox');

        checkbox.checked = !checkbox.checked;

        item.classList.toggle('selected', checkbox.checked);

        updateSelectedCount();
    });

    // =========================
    // SELECT ALL
    // =========================
    const selectAll = document.getElementById('selectAll');

    if (selectAll) {

        selectAll.addEventListener('change', function () {

            let checkboxes = document.querySelectorAll('.item-checkbox');

            checkboxes.forEach(cb => {

                cb.checked = selectAll.checked;

                cb.closest('.cart-selectable')
                    .classList.toggle('selected', cb.checked);
            });

            updateSelectedCount();
        });
    }

    // =========================
    // DELETE SELECTED ITEMS
    // =========================
    document.getElementById('deleteSelected').addEventListener('click', function () {

        let selectedIds = [];

        document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
            selectedIds.push(cb.dataset.id);
        });

        if (selectedIds.length === 0) {
            alert('Please select items first');
            return;
        }

        fetch("{{ route('cart.removeSelected') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ ids: selectedIds })
        })
        .then(res => res.json())
        .then(data => {

            selectedIds.forEach(id => {
                let item = document.getElementById('cart-item-' + id);
                if (item) item.remove();
            });

            updateTotals(data);

            if (data.count == 0) {
                document.getElementById('cartItemsList').innerHTML =
                    '<h3>Your cart is empty</h3>';
            }

            updateSelectedCount();
        });

    });

    // =========================
    // UPDATE TOTALS FUNCTION
    // =========================
    function updateTotals(data) {

        document.getElementById('summarySubtotal').innerText =
            '$' + Number(data.total).toFixed(2);

        let tax = data.total * 0.08;
        document.getElementById('taxVal').innerText =
            '$' + tax.toFixed(2);

        let grand = data.total + tax;
        document.getElementById('grandTotal').innerText =
            '$' + grand.toFixed(2);

        document.getElementById('summaryItemCount').innerText = data.count;
        updateCartUI(data.count);
    }

    // =========================
    // UPDATE SELECTED COUNT
    // =========================
    function updateSelectedCount() {

        let selected = document.querySelectorAll('.item-checkbox:checked').length;

        let el = document.getElementById('selectedCount');
        if (el) el.innerText = selected;
    }

    function updateCartUI(count) {

        // navbar icon
        let nav = document.getElementById('cart-count');
        if (nav) nav.innerText = count;

        // cart page header
        let header = document.getElementById('headerItemCount');
        if (header) header.innerText = count;

        let selectedCount = document.getElementById('selectedCount');
        if (selectedCount) selectedCount.innerText = count;
    }

});
</script>
@stack('scripts')
</body>
</html>