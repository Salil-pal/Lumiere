<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body style="margin:0; padding:0; background:#f8f6f2; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f6f2; padding:40px 0;">

    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="650" cellpadding="0" cellspacing="0"
                   style="background:#ffffff; border-radius:12px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td
                        style="
                            background:#1a1a2e;
                            padding:30px;
                            text-align:center;
                        "
                    >
                        <h1
                            style="
                                color:#ffffff;
                                margin:0;
                                font-size:32px;
                                letter-spacing:1px;
                            "
                        >
                            Lumière
                        </h1>

                        <p
                            style="
                                color:#f5c27a;
                                margin-top:10px;
                                font-size:14px;
                            "
                        >
                            Premium Shopping Experience
                        </p>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:40px;">

                        <h2 style="color:#1a1a2e; margin-top:0;">
                            Thank you for your order!
                        </h2>

                        <p style="color:#555; line-height:1.7;">
                            Hello <strong>{{ $order->name }}</strong>,
                        </p>

                        <p style="color:#555; line-height:1.7;">
                            Your order has been placed successfully and is now being processed.
                        </p>

                        <!-- Order Box -->
                        <table width="100%" cellpadding="0" cellspacing="0"
                               style="
                                   margin-top:30px;
                                   border:1px solid #e8e4dc;
                                   border-radius:8px;
                               ">

                            <tr>
                                <td style="padding:18px; border-bottom:1px solid #e8e4dc;">
                                    <strong>Order Number:</strong>
                                    {{ $order->order_number }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:18px; border-bottom:1px solid #e8e4dc;">
                                    <strong>Payment Method:</strong>
                                    {{ strtoupper($order->payment_method) }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:18px; border-bottom:1px solid #e8e4dc;">
                                    <strong>Status:</strong>
                                    {{ ucfirst($order->status) }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:18px;">
                                    <strong>Total:</strong>
                                    <span style="color:#c4812a; font-size:20px;">
                                        ${{ number_format($order->total, 2) }}
                                    </span>
                                </td>
                            </tr>

                        </table>

                        <!-- Items -->
                        <h3 style="margin-top:40px; color:#1a1a2e;">
                            Order Items
                        </h3>

                        <table width="100%" cellpadding="0" cellspacing="0"
                               style="
                                   border-collapse:collapse;
                                   margin-top:15px;
                               ">

                            <tr style="background:#1a1a2e;">

                                <th align="left"
                                    style="
                                        padding:14px;
                                        color:#ffffff;
                                        font-size:14px;
                                    ">
                                    Product
                                </th>

                                <th align="center"
                                    style="
                                        padding:14px;
                                        color:#ffffff;
                                        font-size:14px;
                                    ">
                                    Quantity
                                </th>

                            </tr>

                            @foreach($order->items as $item)

                            <tr>

                                <td
                                    style="
                                        padding:14px;
                                        border-bottom:1px solid #e8e4dc;
                                        color:#444;
                                    "
                                >
                                    {{ $item->product_name }}
                                </td>

                                <td
                                    align="center"
                                    style="
                                        padding:14px;
                                        border-bottom:1px solid #e8e4dc;
                                        color:#444;
                                    "
                                >
                                    {{ $item->quantity }}
                                </td>

                            </tr>

                            @endforeach

                        </table>

                        <!-- CTA Button -->
                        <table width="100%" cellpadding="0" cellspacing="0"
                               style="margin-top:40px;">

                            <tr>
                                <td align="center">

                                    <a href="{{ url('/') }}"
                                       style="
                                            display:inline-block;
                                            background:#e8a045;
                                            color:#ffffff;
                                            text-decoration:none;
                                            padding:14px 30px;
                                            border-radius:6px;
                                            font-weight:bold;
                                            font-size:14px;
                                       ">
                                        Continue Shopping
                                    </a>

                                </td>
                            </tr>

                        </table>

                        <!-- Footer -->
                        <p
                            style="
                                margin-top:50px;
                                color:#888;
                                font-size:13px;
                                line-height:1.7;
                                text-align:center;
                            "
                        >
                            Thank you for shopping with Lumière.<br>
                            We appreciate your trust in our brand.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>

</table>

</body>
</html>