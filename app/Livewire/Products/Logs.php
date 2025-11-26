<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductChangeLog;
use App\Models\InventoryTransaction;

class Logs extends Component
{
    public $product;

    public $changeLogs = [];
    public $transactions = [];

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);

        // Product change logs
        $this->changeLogs = ProductChangeLog::where('product_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Inventory transactions for this product
        $this->transactions = InventoryTransaction::with('user')
            ->where('product_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.products.logs', [
            'product' => $this->product,
            'changeLogs' => $this->changeLogs,
            'transactions' => $this->transactions
        ]);
    }
}
