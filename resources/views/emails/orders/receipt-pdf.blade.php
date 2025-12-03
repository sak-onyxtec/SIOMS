<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt #{{ $order->uid }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            background-color: #f3f4f6;
        }
        .wrapper {
            max-width: 760px;
            margin: 0 auto;
            padding: 20px 16px;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 18px 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .title {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            color: #111827;
        }
        .muted {
            font-size: 11px;
            color: #6b7280;
            margin: 2px 0 0 0;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
        }
        .badge-paid {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-status {
            background-color: #e0f2fe;
            color: #075985;
        }
        .section-title {
            font-weight: 600;
            font-size: 13px;
            margin: 18px 0 6px;
            color: #111827;
        }
        table.table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table th,
        .table td {
            padding: 6px 8px;
            border: 1px solid #e5e7eb;
        }
        .table th {
            background-color: #f9fafb;
            font-size: 11px;
            text-align: left;
            color: #374151;
        }
        .text-right { text-align: right; }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .summary-table td {
            padding: 4px 0;
            font-size: 12px;
        }
        .summary-label {
            /* text-align: right; */
            color: #6b7280;
        }
        .summary-label.total {  text-align: right; }
        .summary-value.total { text-align: right; }
        .summary-value {
            /* text-align: right; */
            font-weight: 600;
            color: #111827;
            width: 120px;
        }
        .footer {
            margin-top: 14px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        {{-- Header --}}
        <table class="header-table">
            <tr>
                <td style="width: 50%;">
                    {{-- Use filesystem path so DomPDF can render the image --}}
                    <img src="{{ public_path('images/sioms-logo-horizontal.svg') }}"
                         alt="{{ config('app.name') }}"
                         style="height:40px; margin-bottom:6px;">
                </td>
                <td style="text-align:right;">
                    <h1 class="title">Receipt</h1>
                    <p class="muted">
                        Order #{{ $order->uid }}<br>
                        Date:
                        {{ $order->paid_at ? $order->paid_at->format('d M Y, h:i A') : $order->created_at->format('d M Y, h:i A') }}
                    </p>
                    <div style="margin-top:4px;">
                        <span class="badge badge-paid">Paid</span>
                        <span class="badge badge-status">{{ ucfirst($order->status) }}</span>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Billed To + Payment Info --}}
        <table class="header-table" style="margin-top:10px;">
            <tr>
                <td style="width:55%; padding-right:16px;">
                    <div class="section-title" style="margin-top:0;">Billed To</div>
                    <p class="muted" style="font-size:12px;">
                        {{ $order->user->name ?? 'Customer' }}<br>
                        {{ $order->user->email ?? '' }}
                    </p>
                </td>
                <td style="width:45%; padding-left:16px;">
                    <div class="section-title" style="margin-top:0;">Payment Details</div>
                    <table class="summary-table">
                        <tr>
                            <td class="summary-label">Method:</td>
                            <td class="summary-value">{{ strtoupper($order->payment_method ?? 'stripe') }}</td>
                        </tr>
                        <tr>
                            <td class="summary-label">Payment Intent:</td>
                            <td class="summary-value">{{ $order->stripe_payment_intent_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="summary-label">Paid At:</td>
                            <td class="summary-value">
                                {{ $order->paid_at ? $order->paid_at->format('d M Y, h:i A') : '-' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Order Items --}}
        <div class="section-title">Order Items</div>
        <table class="table">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Line Total</th>
            </tr>
            </thead>
            <tbody>
            @if($order->items->count() > 0)
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product' }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">${{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4" class="text-center">No items found</td>
            </tr>
            @endif
            </tbody>
        </table>

        {{-- Totals --}}
        <table class="summary-table">
            <tr>
                <td class="summary-label total">Subtotal:</td>
                <td class="summary-value total">
                    ${{ number_format($order->items->sum('total_price'), 2) }}
                </td>
            </tr>
            <tr>
                <td class="summary-label total">Total Paid:</td>
                <td class="summary-value total">
                    ${{ number_format($order->total, 2) }}
                </td>
            </tr>
        </table>

        <div class="footer">
            Thank you for your purchase from {{ config('app.name') }}.<br>
            This receipt confirms that your payment has been processed successfully.
        </div>
    </div>
</div>
</body>
</html>


