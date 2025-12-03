<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Report - {{ $year }}</title>
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
            margin-bottom: 12px;
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
        .section-title {
            font-weight: 600;
            font-size: 14px;
            margin: 18px 0 8px;
            color: #111827;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            padding: 6px 8px;
            border: 1px solid #e5e7eb;
            font-size: 11px;
        }
        th {
            background-color: #f3f4f6;
            text-align: left;
            color: #374151;
        }
        .text-right {
            text-align: right;
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
    <div class="header">
        <div>
            <h1 class="title">Monthly Sales &amp; Inventory Report</h1>
            <p class="muted">
                Year: {{ $year }}<br>
                Generated at: {{ now()->format('d M Y, h:i A') }}
            </p>
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

    {{-- Monthly Sales --}}
    <div>
        <h2 class="section-title">Monthly Sales ({{ $year }})</h2>
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
                <tr>
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

    {{-- Inventory Movement --}}
    <div>
        <h2 class="section-title">Inventory Movement ({{ $year }})</h2>
        <table>
            <thead>
            <tr>
                <th>Month</th>
                <th class="text-right">Stock In</th>
                <th class="text-right">Stock Out</th>
                <th class="text-right">Net Movement (In - Out)</th>
            </tr>
            </thead>
            <tbody>
            @php
                $totalIn = 0;
                $totalOut = 0;
            @endphp
            @foreach($inventoryMovement as $index => $row)
                @php
                    $monthNumber = $index + 1;
                    $in = (int) ($row['in'] ?? 0);
                    $out = (int) ($row['out'] ?? 0);
                    $totalIn += $in;
                    $totalOut += $out;
                @endphp
                <tr>
                    <td>{{ $monthNames[$monthNumber] ?? $monthNumber }}</td>
                    <td class="text-right">{{ number_format($in) }}</td>
                    <td class="text-right">{{ number_format($out) }}</td>
                    <td class="text-right">{{ number_format($in - $out) }}</td>
                </tr>
            @endforeach
            <tr>
                <th>Total</th>
                <th class="text-right">{{ number_format($totalIn) }}</th>
                <th class="text-right">{{ number_format($totalOut) }}</th>
                <th class="text-right">{{ number_format($totalIn - $totalOut) }}</th>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        {{ config('app.name') }} &mdash; Internal dashboard report for monthly sales and inventory movement.
    </div>
</div>
</body>
</html>


