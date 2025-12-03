<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function dashboard()
    {
        // Summary cards
        $totalProducts = Product::count();
        $totalStockValue = Product::sum(DB::raw('quantity * price'));
        $lowStockItems = Product::where('quantity', '<=', 5)->count(); // threshold

        // Orders summary
        $totalOrders = Order::count();
        $totalPendingOrders = Order::where('status', 'pending')->count();
        
        // Stripe earnings (only count orders where paid_at is not null and not refunded - confirmed net paid orders)
        $totalStripeEarnings = Order::where('payment_method', 'stripe')
            ->whereNotNull('paid_at')
            ->whereNull('refunded_at')
            ->sum('total');

        // Latest records
        $latestProducts = Product::latest()->take(3)->get();
        $latestOrders = Order::with('items.product')->latest()->take(3)->get();

        // Monthly Sales (1-12)
        $sales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total_sales')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlySales = collect(range(1, 12))->map(function ($m) use ($sales) {
            $record = $sales->firstWhere('month', $m);
            return $record ? $record->total_sales : 0;
        })->toArray();

        // Inventory movement
        $movement = InventoryTransaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw("SUM(CASE WHEN type='stock_in' THEN quantity ELSE 0 END) as stock_in"),
            DB::raw("SUM(CASE WHEN type='stock_out' THEN quantity ELSE 0 END) as stock_out")
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $inventoryMovement = collect(range(1, 12))->map(function ($m) use ($movement) {
            $record = $movement->firstWhere('month', $m);
            return [
                'in' => $record ? $record->stock_in : 0,
                'out' => $record ? $record->stock_out : 0,
            ];
        })->toArray();

        return view('dashboard', compact(
            'totalProducts',
            'totalStockValue',
            'lowStockItems',
            'monthlySales',
            'inventoryMovement',
            'totalOrders',
            'totalPendingOrders',
            'totalStripeEarnings',
            'latestProducts',
            'latestOrders'
        ));
    }

    /**
     * Export a PDF report of the current year's monthly sales only.
     */
    public function exportMonthlySalesPdf(Request $request)
    {
        $year = (int) ($request->input('year', now()->year));

        $sales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total_sales')
        )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlySales = collect(range(1, 12))->map(function ($m) use ($sales) {
            $record = $sales->firstWhere('month', $m);
            return $record ? (float) $record->total_sales : 0.0;
        })->toArray();

        // Per-product sales for the selected year
        $productSales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereYear('orders.created_at', $year)
            ->select(
                'products.name as product_name',
                'products.sku as product_sku',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.total_price) as total_sales')
            )
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_sales')
            ->get();

        $pdf = Pdf::loadView('reports.dashboard-monthly-sales', [
            'year' => $year,
            'monthlySales' => $monthlySales,
            'productSales' => $productSales,
        ]);

        $filename = 'dashboard-' . $year . '-monthly-sales.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export a PDF report of the current year's inventory movement only.
     */
    public function exportInventoryMovementPdf(Request $request)
    {
        $year = (int) ($request->input('year', now()->year));

        $movement = InventoryTransaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw("SUM(CASE WHEN type='stock_in' THEN quantity ELSE 0 END) as stock_in"),
            DB::raw("SUM(CASE WHEN type='stock_out' THEN quantity ELSE 0 END) as stock_out"),
            DB::raw("SUM(CASE WHEN type='adjustment' THEN quantity ELSE 0 END) as adjustment")
        )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $inventoryMovement = collect(range(1, 12))->map(function ($m) use ($movement) {
            $record = $movement->firstWhere('month', $m);
            return [
                'in' => $record ? (int) $record->stock_in : 0,
                'out' => $record ? (int) $record->stock_out : 0,
                'adjustment' => $record ? (int) $record->adjustment : 0,
            ];
        })->toArray();

        // Per-product inventory movement for the selected year
        $productInventoryMovement = DB::table('inventory_transactions')
            ->join('products', 'inventory_transactions.product_id', '=', 'products.id')
            ->whereYear('inventory_transactions.created_at', $year)
            ->select(
                'products.name as product_name',
                'products.sku as product_sku',
                DB::raw("SUM(CASE WHEN inventory_transactions.type='stock_in' THEN inventory_transactions.quantity ELSE 0 END) as total_in"),
                DB::raw("SUM(CASE WHEN inventory_transactions.type='stock_out' THEN inventory_transactions.quantity ELSE 0 END) as total_out"),
                DB::raw("SUM(CASE WHEN inventory_transactions.type='adjustment' THEN inventory_transactions.quantity ELSE 0 END) as total_adjustment")
            )
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderBy('products.name')
            ->get();

        $pdf = Pdf::loadView('reports.dashboard-inventory-movement', [
            'year' => $year,
            'inventoryMovement' => $inventoryMovement,
            'productInventoryMovement' => $productInventoryMovement,
        ]);

        $filename = 'dashboard-' . $year . '-inventory-movement.pdf';

        return $pdf->download($filename);
    }
}
