<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductChangeLog;
use App\Models\InventoryTransaction;

class View extends Component
{
    public $product;

    public $changeLogs = [];
    public $transactions = [];

    public function mount($id)
    {
        $this->product = Product::with([
            'transactions.user',
            'change_logs.user',
            'category',
            'images',
        ])->findOrFail($id);

        // Product change logs ordered by latest first
        $this->changeLogs = $this->product->change_logs()
            ->with('user')
            ->latest()
            ->get()
            ->map(function ($log) {
                // Ensure before/after are arrays for safe iteration in the view
                if (!is_array($log->before)) {
                    $log->before = $log->before ? (array) $log->before : [];
                }
                if (!is_array($log->after)) {
                    $log->after = $log->after ? (array) $log->after : [];
                }
                return $log;
            });

        // Inventory transactions for this product ordered by latest first
        $this->transactions = $this->product->transactions()->with('user')->latest()->get();
    }

    public function render()
    {
        return view('livewire.products.view', [
            'product' => $this->product,
            'changeLogs' => $this->changeLogs,
            'transactions' => $this->transactions
        ]);
    }
}

