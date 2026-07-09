<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Order Coffee System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f7f7f4 0%, #efefeb 100%);
            color: #111111;
            font-family: DM Sans, sans-serif;
            padding-top: 95px;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 75px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e6e6e2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            z-index: 999;
            box-shadow: 0 8px 24px rgba(17, 17, 17, 0.04);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 22px;
            font-weight: 800;
            color: #111111;
        }

        .navbar form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar form input {
            width: 240px;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid #dcdcd7;
            outline: none;
            background: #fff;
            color: #111111;
        }

        .navbar form input:focus {
            border-color: #111111;
            box-shadow: 0 0 0 4px rgba(17, 17, 17, 0.08);
        }

        .btn {
            border: none;
            cursor: pointer;
            padding: 12px 18px;
            border-radius: 14px;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .btn-primary {
            background: #111111;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #2a2a2a;
            transform: translateY(-2px);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 26px;
            padding: 30px;
        }

        .product-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #e6e6e2;
            box-shadow: 0 12px 30px rgba(17, 17, 17, 0.05);
            transition: 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(17, 17, 17, 0.08);
        }

        .product-image img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .product-card-body {
            padding: 16px;
        }

        .product-title {
            font-size: 18px;
            font-weight: 800;
            color: #111111;
            margin-bottom: 8px;
        }

        .product-category {
            display: inline-block;
            background: #f2f2ee;
            color: #111111;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .product-description {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.5;
        }

        .product-card-footer {
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-size: 18px;
            font-weight: 800;
            color: #111111;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        .cart-btn {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #111111;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            box-shadow: 0 12px 28px rgba(17, 17, 17, 0.16);
            transition: 0.2s ease;
        }

        .cart-btn:hover {
            transform: scale(1.06);
        }

        .cart-btn svg {
            width: 26px;
            height: 26px;
        }

        .alert {
            margin: 20px;
            padding: 14px;
            background: #edf9f2;
            color: #1f7a4d;
            font-weight: 700;
            border-radius: 12px;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(17, 17, 17, 0.4);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 1000;
        }

        .modal-backdrop.is-open {
            display: flex;
        }

        .cart-modal {
            width: min(420px, 100%);
            background: #fff;
            border: 1px solid #e6e6e2;
            border-radius: 18px;
            box-shadow: 0 24px 70px rgba(17, 17, 17, 0.12);
            overflow: hidden;
        }

        .cart-modal-header,
        .cart-modal-body,
        .cart-modal-footer {
            padding: 20px;
        }

        .cart-modal-header {
            border-bottom: 1px solid #e6e6e2;
        }

        .cart-modal-title {
            font-size: 20px;
            font-weight: 800;
            color: #111111;
        }

        .cart-modal-body {
            color: #4b5563;
            line-height: 1.5;
        }

        .cart-modal-product {
            margin-top: 12px;
            padding: 12px;
            background: #f7f7f4;
            border: 1px solid #e6e6e2;
            border-radius: 12px;
            color: #111111;
            font-weight: 800;
        }

        .cart-modal-price {
            margin-top: 4px;
            color: #111111;
            font-weight: 800;
        }

        .cart-modal-quantity {
            margin-top: 16px;
        }

        .cart-modal-quantity label {
            display: block;
            margin-bottom: 6px;
            color: #111111;
            font-size: 14px;
            font-weight: 800;
        }

        .cart-modal-quantity input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dcdcd7;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            outline: none;
        }

        .cart-modal-quantity input:focus {
            border-color: #111111;
            box-shadow: 0 0 0 4px rgba(17, 17, 17, 0.08);
        }

        .cart-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #e6e6e2;
        }

        .btn-secondary {
            background: #f2f2ee;
            color: #111111;
        }

        .btn-secondary:hover {
            background: #e6e6e2;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                height: auto;
                padding: 14px;
                gap: 10px;
            }

            body {
                padding-top: 140px;
            }

            .navbar form input {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">

        <div class="logo">
            <img width="80" src="{{ asset('storage/default/logo.png') }}">
            <h2 class="mt-3 mx-3 fw-bold text-black">Coffe Menu</h2>

        </div>

        <form method="GET" action="{{ route('search_order') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search coffee...">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

    </nav>

    <main>

        @if (session('success'))
            <div id="alert-success" class="alert">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(() => {
                    let el = document.getElementById('alert-success');
                    if (el) el.style.display = "none";
                }, 2000);
            </script>
        @endif

        <div class="products-grid">

            @foreach ($products as $product)
                @if ($product->stock_quantity == 'In Stock')
                    <div class="product-card">

                        <div class="product-image">
                            <img
                                src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/default/download.png') }}">
                        </div>

                        <div class="product-card-body">
                            <div class="product-title">{{ $product->product_name }}</div>
                            <div class="product-meta d-flex align-items-center gap-12">
                                <div class="product-category">{{ $product->category_name }}</div>

                            </div>
                            <div class="product-description">{{ $product->description }}</div>
                        </div>

                        <div class="product-card-footer">

                            <span class="product-price">
                                ${{ number_format($product->price, 2) }}
                            </span>

                            <button type="button" class="btn btn-primary add-to-cart-btn"
                                data-product-id="{{ $product->product_id }}"
                                data-product-name="{{ $product->product_name }}"
                                data-product-price="{{ $product->price }}"
                                data-product-price-display="${{ number_format($product->price, 2) }}">
                                Add To Cart
                            </button>

                        </div>

                    </div>
                @endif
            @endforeach
        </div>
    </main>

    <!-- ADD TO CART CONFIRMATION MODAL -->
    <div class="modal-backdrop" id="addToCartModal" aria-hidden="true">
        <div class="cart-modal" role="dialog" aria-modal="true" aria-labelledby="addToCartModalTitle">
            <form action="{{ route('addtocart') }}" method="POST" id="addToCartForm">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">
                <input type="hidden" name="product_name" id="modalProductNameInput">
                <input type="hidden" name="price" id="modalProductPriceInput">
                <input type="hidden" name="customer_name" value="Guest">

                <div class="cart-modal-header">
                    <div class="cart-modal-title" id="addToCartModalTitle">Add to cart?</div>
                </div>
                <div class="cart-modal-body">
                    Confirm before sending this item to the cart.
                    <div class="cart-modal-product" id="modalProductName"></div>
                    <div class="cart-modal-price" id="modalProductPrice"></div>
                    <div class="cart-modal-quantity">
                        <label for="modalQuantity">Quantity</label>
                        <input type="number" name="quantity" id="modalQuantity" min="1" value="1">
                    </div>
                </div>
                <div class="cart-modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelAddToCart">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add To Cart</button>
                </div>
            </form>
        </div>
    </div>

    <!-- FLOATING CART -->
    <div class="footer">
        <a href="{{ route('showcart') }}" class="cart-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h12m-9 0a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2" />
            </svg>
        </a>
    </div>

    <script>
        const addToCartModal = document.getElementById('addToCartModal');
        const addToCartForm = document.getElementById('addToCartForm');
        const modalProductId = document.getElementById('modalProductId');
        const modalProductName = document.getElementById('modalProductName');
        const modalProductNameInput = document.getElementById('modalProductNameInput');
        const modalProductPrice = document.getElementById('modalProductPrice');
        const modalProductPriceInput = document.getElementById('modalProductPriceInput');
        const modalQuantity = document.getElementById('modalQuantity');
        const cancelAddToCart = document.getElementById('cancelAddToCart');

        document.querySelectorAll('.add-to-cart-btn').forEach((button) => {
            button.addEventListener('click', () => {
                modalProductId.value = button.dataset.productId;
                modalProductNameInput.value = button.dataset.productName;
                modalProductPriceInput.value = button.dataset.productPrice;
                modalProductName.textContent = button.dataset.productName;
                modalProductPrice.textContent = button.dataset.productPriceDisplay;
                modalQuantity.value = 1;
                addToCartModal.classList.add('is-open');
                addToCartModal.setAttribute('aria-hidden', 'false');
                modalQuantity.focus();
            });
        });

        function closeAddToCartModal() {
            addToCartModal.classList.remove('is-open');
            addToCartModal.setAttribute('aria-hidden', 'true');
            addToCartForm.reset();
        }

        cancelAddToCart.addEventListener('click', closeAddToCartModal);

        addToCartModal.addEventListener('click', (event) => {
            if (event.target === addToCartModal) {
                closeAddToCartModal();
            }
        });

        addToCartForm.addEventListener('submit', () => {
            modalQuantity.value = Math.max(1, parseInt(modalQuantity.value, 10) || 1);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
