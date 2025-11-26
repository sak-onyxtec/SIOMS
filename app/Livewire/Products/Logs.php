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
        $this->product = Product::with('transactions','change_logs')->findOrFail($id);

        // Product change logs
        $this->changeLogs = $this->product->change_logs;

        // Inventory transactions for this product
        $this->transactions = $this->product->transactions;
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
