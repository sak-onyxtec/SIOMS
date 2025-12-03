<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventory Movement Report - {{ $year }}</title>
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
            background-color: #ecfdf3;
            color: #166534;
            border: 1px solid #bbf7d0;
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
            <h1 class="title">Inventory Movement Report</h1>
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

    {{-- Inventory movement by month --}}
    <div class="card">
        <h2 class="section-title">Monthly Movement Summary</h2>
        <p class="section-subtitle">
            Stock in, out, and adjustments aggregated by month for {{ $year }}.
        </p>
        <table>
            <thead>
            <tr>
                <th>Month</th>
                <th class="text-right">Stock In</th>
                <th class="text-right">Stock Out</th>
                <th class="text-right">Adjustments</th>
                <th class="text-right">Net Movement (In - Out + Adj)</th>
            </tr>
            </thead>
            <tbody>
            @php
                $monthNames = [1=>'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                $totalIn = 0;
                $totalOut = 0;
                $totalAdj = 0;
            @endphp
            @foreach($inventoryMovement as $index => $row)
                @php
                    $monthNumber = $index + 1;
                    $in = (int) ($row['in'] ?? 0);
                    $out = (int) ($row['out'] ?? 0);
                    $adj = (int) ($row['adjustment'] ?? 0);
                    $totalIn += $in;
                    $totalOut += $out;
                    $totalAdj += $adj;
                @endphp
                <tr @if($index % 2 === 1) class="row-alt" @endif>
                    <td>{{ $monthNames[$monthNumber] ?? $monthNumber }}</td>
                    <td class="text-right">{{ number_format($in) }}</td>
                    <td class="text-right">{{ number_format($out) }}</td>
                    <td class="text-right">{{ number_format($adj) }}</td>
                    <td class="text-right">{{ number_format($in - $out + $adj) }}</td>
                </tr>
            @endforeach
            <tr>
                <th>Total</th>
                <th class="text-right">{{ number_format($totalIn) }}</th>
                <th class="text-right">{{ number_format($totalOut) }}</th>
                <th class="text-right">{{ number_format($totalAdj) }}</th>
                <th class="text-right">{{ number_format($totalIn - $totalOut + $totalAdj) }}</th>
            </tr>
            </tbody>
        </table>
    </div>

    {{-- Per-product stock movement --}}
    @if(!empty($productInventoryMovement) && count($productInventoryMovement) > 0)
        <div class="card">
            <h2 class="section-title">Product Stock Movement</h2>
            <p class="section-subtitle">
                Total stock in, out, and adjustments for each product during {{ $year }}.
            </p>
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th class="text-right">Stock In</th>
                    <th class="text-right">Stock Out</th>
                    <th class="text-right">Adjustments</th>
                    <th class="text-right">Net Movement</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $grandIn = 0;
                    $grandOut = 0;
                    $grandAdj = 0;
                @endphp
                @foreach($productInventoryMovement as $index => $row)
                    @php
                        $in = (int) $row->total_in;
                        $out = (int) $row->total_out;
                        $adj = (int) $row->total_adjustment;
                        $grandIn += $in;
                        $grandOut += $out;
                        $grandAdj += $adj;
                    @endphp
                    <tr @if($index % 2 === 1) class="row-alt" @endif>
                        <td>{{ $row->product_name }}</td>
                        <td>{{ $row->product_sku }}</td>
                        <td class="text-right">{{ number_format($in) }}</td>
                        <td class="text-right">{{ number_format($out) }}</td>
                        <td class="text-right">{{ number_format($adj) }}</td>
                        <td class="text-right">{{ number_format($in - $out + $adj) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total</th>
                    <th class="text-right">{{ number_format($grandIn) }}</th>
                    <th class="text-right">{{ number_format($grandOut) }}</th>
                    <th class="text-right">{{ number_format($grandAdj) }}</th>
                    <th class="text-right">{{ number_format($grandIn - $grandOut + $grandAdj) }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    @endif

    <div class="footer">
        <span>{{ config('app.name') }}</span> &mdash; Inventory movement report (internal use only).
    </div>
</div>
</body>
</html>


