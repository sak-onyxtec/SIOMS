<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation #{{ $order->uid }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color:#f3f4f6; margin:0; padding:24px;">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                   style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 10px 25px rgba(15,23,42,0.08);">
                <!-- Header with logo and title -->
                <tr>
                    <td style="background:linear-gradient(135deg,#2563eb,#4f46e5);padding:20px 28px;color:#ffffff;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td style="text-align:left;">
                                    <img src="{{ asset('images/sioms-logo-horizontal-white.svg') }}"
                                         alt="{{ config('app.name') }}"
                                         style="height:40px; margin-bottom:6px;">
                                </td>
                                <td style="text-align:right;font-size:14px;font-weight:600;">
                                    Order Confirmation
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:24px 28px;color:#111827;font-size:14px;line-height:1.6;">
                        <!-- Greeting -->
                        <p style="margin-top:0;margin-bottom:10px;font-size:16px;font-weight:600;">
                            Thank you for your order, {{ $order->user->name ?? 'Customer' }}!
                        </p>
                        <p style="margin:0 0 16px 0;">
                            Your order <strong>#{{ $order->uid }}</strong> has been placed successfully.
                            You’ll find a summary of your purchase below.
                        </p>

                        <!-- Order summary card -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                               style="background-color:#f9fafb;border-radius:10px;border:1px solid #e5e7eb;margin-bottom:20px;">
                            <tr>
                                <td style="padding:14px 16px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td style="font-size:13px;color:#6b7280;">
                                                Order ID
                                            </td>
                                            <td style="font-size:13px;color:#111827;text-align:right;font-weight:600;">
                                                {{ $order->uid }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:13px;color:#6b7280;padding-top:4px;">
                                                Date
                                            </td>
                                            <td style="font-size:13px;color:#111827;text-align:right;padding-top:4px;">
                                                {{ $order->created_at->format('d M Y, h:i A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:13px;color:#6b7280;padding-top:4px;">
                                                Status
                                            </td>
                                            <td style="text-align:right;padding-top:4px;">
                                                <span style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:11px;font-weight:600;
                                                             background-color:#dcfce7;color:#166534;">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:13px;color:#6b7280;padding-top:4px;">
                                                Total
                                            </td>
                                            <td style="font-size:16px;color:#111827;text-align:right;font-weight:700;padding-top:4px;">
                                                ${{ number_format($order->total, 2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- Items table -->
                        <p style="margin:0 0 8px 0;font-weight:600;font-size:14px;">Order items</p>
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                               style="border-collapse:collapse;margin-bottom:16px;">
                            <thead>
                            <tr>
                                <th style="text-align:left;padding:8px;border-bottom:1px solid #e5e7eb;font-size:12px;color:#6b7280;">
                                    Product
                                </th>
                                <th style="text-align:center;padding:8px;border-bottom:1px solid #e5e7eb;font-size:12px;color:#6b7280;">
                                    Qty
                                </th>
                                <th style="text-align:right;padding:8px;border-bottom:1px solid #e5e7eb;font-size:12px;color:#6b7280;">
                                    Price
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td style="padding:8px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                                        {{ $item->product->name }}
                                    </td>
                                    <td style="text-align:center;padding:8px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                                        {{ $item->quantity }}
                                    </td>
                                    <td style="text-align:right;padding:8px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                                        ${{ number_format($item->total_price, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- View Order & Download Receipt Buttons -->
                        <div style="text-align:center; margin:20px 0 18px;">
                            <a href="{{ route('orders.web.detail', ['id' => $order->id]) }}"
                               style="background-color:#2563eb;color:#ffffff;padding:10px 20px;text-decoration:none;border-radius:999px;display:inline-block;margin-right:8px;font-size:13px;font-weight:600;">
                                View Order
                            </a>
                            @if(isset($order->id))
                                <a href="{{ route('orders.web.receipt', $order->id) }}"
                                   style="background-color:#059669;color:#ffffff;padding:10px 20px;text-decoration:none;border-radius:999px;display:inline-block;font-size:13px;font-weight:600;">
                                    Download Receipt (PDF)
                                </a>
                            @endif
                        </div>

                        <!-- Help text -->
                        <p style="font-size:12px;color:#6b7280;margin-top:0;margin-bottom:8px;">
                            If you have any questions about your order, you can reply to this email or visit your
                            account dashboard to view order details.
                        </p>

                        <!-- Footer -->
                        <p style="font-size:13px; color:#4b5563; margin-top:18px;margin-bottom:4px;">
                            Thanks for shopping with {{ config('app.name') }}!
                        </p>
                        <hr style="border:none;border-top:1px solid #e5e7eb;margin:14px 0;">
                        <p style="text-align:center; font-size:11px; color:#9ca3af; margin:0;">
                            This is an automated message, please do not reply.<br>
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
