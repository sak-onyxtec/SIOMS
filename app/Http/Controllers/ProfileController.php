<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\Product;
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
            'latestProducts',
            'latestOrders'
        ));
    }
}
