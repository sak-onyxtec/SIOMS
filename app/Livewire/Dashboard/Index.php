<?php

namespace App\Livewire\Dashboard;

use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\Product;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        // Summary cards
        $totalProducts = Product::count();
        $totalStockValue = Product::sum(DB::raw('price * quantity'));
        $lowStockItems = Product::where('quantity', '<=', 5)->count();

        // Monthly Sales
        $sales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total_sales')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlySales = collect(range(1, 12))->map(fn($m) => $sales->firstWhere('month', $m)?->total_sales ?? 0);

        $monthlySalesChart = new \ConsoleTVs\Charts\Classes\Chartjs\Chart();
        $monthlySalesChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $monthlySalesChart->dataset('Monthly Sales', 'line', $monthlySales)
            ->backgroundColor('rgba(54, 162, 235, 0.2)')
            ->color('rgba(54, 162, 235, 1)');

        // Inventory Movement
        $movement = InventoryTransaction::selectRaw(
            "MONTH(created_at) as month,
        SUM(CASE WHEN type='stock_in' THEN quantity ELSE 0 END) as stock_in,
        SUM(CASE WHEN type='stock_out' THEN quantity ELSE 0 END) as stock_out"
        )->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $stockIn = collect(range(1, 12))->map(fn($m) => $movement->firstWhere('month', $m)?->stock_in ?? 0);
        $stockOut = collect(range(1, 12))->map(fn($m) => $movement->firstWhere('month', $m)?->stock_out ?? 0);

        $inventoryMovementChart = new \ConsoleTVs\Charts\Classes\Chartjs\Chart();
        $inventoryMovementChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $inventoryMovementChart->dataset('Stock In', 'bar', $stockIn)->backgroundColor('rgba(75, 192, 192, 0.6)');
        $inventoryMovementChart->dataset('Stock Out', 'bar', $stockOut)->backgroundColor('rgba(255, 99, 132, 0.6)');

        return view('livewire.dashboard.index', compact(
            'totalProducts',
            'totalStockValue',
            'lowStockItems',
            'monthlySalesChart',
            'inventoryMovementChart'
        ));
    }
}
