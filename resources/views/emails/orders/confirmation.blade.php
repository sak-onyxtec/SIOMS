<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin:0; padding:0;">
    <div
        style="max-width:600px; margin:40px auto; background-color:#fff; padding:20px; border:1px solid #ddd; border-radius:5px;">

        <!-- Logo -->
        <div style="text-align:center; margin-bottom: 20px;">
            <x-application-logo style="width: 200px; height:200px" />
        </div>

        <!-- Greeting -->
        <p style="font-size:16px; margin-bottom:20px;">
            Your order <strong>#{{ $order->uid }}</strong> has been placed successfully.
        </p>

        <!-- Order Summary -->
        <div style="background-color:#f1f1f1; padding:15px; border-radius:5px; margin-bottom:20px;">
            <p style="margin:0;"><strong>Order Total:</strong> ${{ number_format($order->total, 2) }}</p>
            <p style="margin:0;"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>

        <!-- Order Items Table -->
        <table style="width:100%; border-collapse: collapse; margin-bottom:20px;">
            <thead>
                <tr>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Product</th>
                    <th style="text-align:center; padding:8px; border-bottom:1px solid #ddd;">Qty</th>
                    <th style="text-align:right; padding:8px; border-bottom:1px solid #ddd;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td style="padding:8px; border-bottom:1px solid #eee;">{{ $item->product->name }}</td>
                        <td style="text-align:center; padding:8px; border-bottom:1px solid #eee;">{{ $item->quantity }}
                        </td>
                        <td style="text-align:right; padding:8px; border-bottom:1px solid #eee;">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- View Order Button -->
        <div style="text-align:center; margin-bottom:20px;">
            <a href="{{ route('orders.success') }}"
                style="background-color:#007bff; color:#fff; padding:10px 20px; text-decoration:none; border-radius:5px; display:inline-block;">
                View Order
            </a>
        </div>

        <!-- Footer -->
        <p style="font-size:14px; color:#555; margin-bottom:5px;">Thanks,<br>{{ config('app.name') }}</p>
        <hr style="border:none; border-top:1px solid #ddd; margin:20px 0;">
        <p style="text-align:center; font-size:12px; color:#999;">
            This is an automated email. Please do not reply.<br>
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>

</html>
