<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f7f7f4 0%, #efefeb 100%);
            font-family: Arial, sans-serif;
            color: #111111;
            min-height: 100vh;
        }

        .cart-wrapper {
            max-width: 1160px;
            margin: 40px auto;
            padding: 0 20px 30px;
        }

        .cart-card {
            background: #ffffff;
            border: 1px solid #e6e6e2;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 18px 48px rgba(17, 17, 17, 0.05);
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f0f0eb;
        }

        .cart-title {
            font-size: 28px;
            font-weight: 700;
            color: #111111;
            margin: 0;
        }

        .cart-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }

        .table thead th {
            border: none;
            background: #f7f7f4;
            color: #4b5563;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 12px 14px;
        }

        .table td {
            vertical-align: middle;
            border-color: #f0f0eb;
            padding: 14px;
        }

        .product-name {
            font-weight: 700;
            font-size: 15px;
            color: #111111;
        }

        .product-meta {
            font-size: 13px;
            color: #6b7280;
            margin-top: 3px;
        }

        .qty-input {
            width: 72px;
            text-align: center;
            border-radius: 10px;
            border: 1px solid #dcdcd7;
            background: #fcfcfb;
        }

        .btn-delete {
            background: #111111;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 14px;
            transition: 0.2s ease;
        }

        .btn-delete:hover {
            background: #2a2a2a;
        }

        .summary-box {
            background: #f7f7f4;
            border: 1px solid #e6e6e2;
            border-radius: 18px;
            padding: 20px;
            margin-top: 24px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 15px;
            color: #4b5563;
        }

        .grand-total {
            font-size: 22px;
            font-weight: 700;
            color: #111111;
        }

        .continue-btn {
            border-radius: 12px;
            padding: 10px 18px;
            background: #111111;
            color: #ffffff;
            border: none;
            transition: 0.2s ease;
        }

        .continue-btn:hover {
            background: #2a2a2a;
            color: #ffffff;
        }

        .pay-btn {
            width: 100%;
            margin-top: 16px;
            padding: 13px 18px;
            border: none;
            border-radius: 14px;
            background: #111111;
            color: #ffffff;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .pay-btn:hover {
            background: #2a2a2a;
            color: #ffffff;
        }

        .empty-cart {
            text-align: center;
            padding: 50px 20px;
            color: #6b7280;
            background: #fcfcfb;
            border: 1px dashed #dcdcd7;
            border-radius: 18px;
        }

        .alert-success {
            background: #edf9f2;
            color: #1f7a4d;
            border: none;
            border-radius: 12px;
            padding: 12px 14px;
        }
    </style>
</head>

<body>

    <div class="container cart-wrapper">

        <div class="cart-card">

            <div class="cart-header">
                <div>
                    <h2 class="cart-title">🛒 Shopping Cart</h2>
                    <p class="cart-subtitle">Review your selected items before checkout.</p>
                </div>

                <a href="{{ route('order_page') }}" class="btn btn-primary continue-btn">
                    Continue Shopping
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}

                </div>
                <script>
                    setTimeout(() => {
                        document.querySelector('.alert-success').style.display = 'none';
                    }, 2000);
                </script>
            @endif

            @if ($carts->isEmpty())

                <div class="empty-cart">
                    <h4>Your cart is empty 🛒</h4>
                </div>
            @else
                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Price</th>
                                <th width="180">Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($carts as $cart)
                                @php
                                    $grandTotal += $cart->total_price;
                                    $price = $cart->total_price / $cart->quantity;
                                @endphp

                                <tr>

                                    <td>
                                        <div class="product-name">
                                            {{ $cart->product_name }}
                                        </div>
                                        <div class="product-meta">Freshly added to your order</div>
                                    </td>

                                    <td>{{ $cart->customer_name }}</td>

                                    <td>${{ number_format($price, 2) }}</td>

                                    <td>
                                        <input type="number" name="quantity" value="{{ $cart->quantity }}"
                                            min="1" class="form-control qty-input" readonly>
                                    </td>

                                    <td>
                                        <strong>
                                            ${{ number_format($cart->total_price, 2) }}
                                        </strong>
                                    </td>

                                    <td>

                                        <form action="{{ route('remove_from_cart', $cart->Order_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn-delete">
                                                Delete
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                @php
                    $tax = $grandTotal * 0.1;
                    $finalTotal = $grandTotal + $tax;
                @endphp

                <div class="summary-box">

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($grandTotal, 2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Tax (10%)</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>

                    <hr>

                    <div class="summary-row grand-total">
                        <span>Total</span>
                        <span>${{ number_format($finalTotal, 2) }}</span>
                    </div>

                </div>

            @endif

        </div>
        <form action="{{ route('payment') }}" method="POST">
            @csrf
            <button type="submit" class="pay-btn">
                💳 Pay Now
            </button>
        </form>
    </div>

</body>

</html>
