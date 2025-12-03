<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monthly Sales Report - {{ $year }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px 18px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .title {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px;
            color: #111827;
        }
        .muted {
            font-size: 11px;
            color: #6b7280;
            margin: 2px 0 0 0;
        }
        .badge-year {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            margin-top: 4px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            padding: 10px 12px 12px;
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px;
        }
        .section-subtitle {
            font-size: 11px;
            color: #6b7280;
            margin: 0 0 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        th, td {
            padding: 5px 7px;
            border: 1px solid #e5e7eb;
            font-size: 11px;
        }
        th {
            background-color: #f9fafb;
            text-align: left;
            color: #374151;
            font-weight: 600;
        }
        .text-right {
            text-align: right;
        }
        .row-alt {
            background-color: #f9fafb;
        }
        .pill {
            display: inline-block;
            padding: 1px 7px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 600;
            background-color: #ecfeff;
            color: #0e7490;
            border: 1px solid #a5f3fc;
        }
        .footer {
            margin-top: 10px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }
        .footer span {
            font-weight: 600;
            color: #374151;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div>
            <h1 class="title">Monthly Sales Report</h1>
            <p class="muted">
                Generated at: {{ now()->format('d M Y, h:i A') }}
            </p>
            <span class="badge-year">Year {{ $year }}</span>
        </div>
        <div>
            @php
                $logoPath = public_path('images/sioms-logo-horizontal.svg');
            @endphp
            @if (file_exists($logoPath))
                <img src="{{ $logoPath }}" alt="{{ config('app.name') }}" style="height:40px;">
            @endif
        </div>
    </div>

    {{-- Monthly totals by month --}}
    <div class="card">
        <h2 class="section-title">Monthly Summary</h2>
        <p class="section-subtitle">
            Total sales performance for each month of {{ $year }}.
        </p>
        <table>
            <thead>
            <tr>
                <th>Month</th>
                <th class="text-right">Total Sales</th>
            </tr>
            </thead>
            <tbody>
            @php
                $monthNames = [1=>'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                $grandTotalSales = 0;
            @endphp
            @foreach($monthlySales as $index => $value)
                @php
                    $monthNumber = $index + 1;
                    $grandTotalSales += $value;
                @endphp
                <tr @if($index % 2 === 1) class="row-alt" @endif>
                    <td>{{ $monthNames[$monthNumber] ?? $monthNumber }}</td>
                    <td class="text-right">${{ number_format($value, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <th>Total</th>
                <th class="text-right">${{ number_format($grandTotalSales, 2) }}</th>
            </tr>
            </tbody>
        </table>
    </div>

    {{-- Products sold summary --}}
    @if(!empty($productSales) && count($productSales) > 0)
        <div class="card">
            <h2 class="section-title">
                Products Sold
                <span class="pill">Top-selling overview</span>
            </h2>
            <p class="section-subtitle">
                Aggregated quantity and revenue for each product sold during {{ $year }}.
            </p>
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th class="text-right">Total Qty Sold</th>
                    <th class="text-right">Total Sales</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $grandQty = 0;
                    $grandSalesByProduct = 0;
                @endphp
                @foreach($productSales as $index => $row)
                    @php
                        $grandQty += (int) $row->total_quantity;
                        $grandSalesByProduct += (float) $row->total_sales;
                    @endphp
                    <tr @if($index % 2 === 1) class="row-alt" @endif>
                        <td>{{ $row->product_name }}</td>
                        <td>{{ $row->product_sku }}</td>
                        <td class="text-right">{{ number_format($row->total_quantity) }}</td>
                        <td class="text-right">${{ number_format($row->total_sales, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total</th>
                    <th class="text-right">{{ number_format($grandQty) }}</th>
                    <th class="text-right">${{ number_format($grandSalesByProduct, 2) }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    @endif

    <div class="footer">
        <span>{{ config('app.name') }}</span> &mdash; Monthly sales report (internal use only).
    </div>
</div>
</body>
</html>


