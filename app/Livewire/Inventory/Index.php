<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Product;
use App\Models\InventoryTransaction;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $product_id;
    public $type;
    public $quantity;
    public $notes;

    public $products;
    public $transactions;

    public $showModal = false;

    public function mount()
    {
        $this->products = Product::all();
        $this->loadTransactions();
    }

    public $filter_product_id;

    public function updatedFilterProductId()
    {
        $this->loadTransactions();
    }

    public function loadTransactions()
    {
        $query = InventoryTransaction::with(['user', 'product'])->latest();

        if ($this->filter_product_id) {
            $query->where('product_id', $this->filter_product_id);
        }

        $this->transactions = $query->get();
    }


    public function updatedProductId()
    {
        $this->loadTransactions();
    }

    public function saveTransaction()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:stock_in,stock_out,adjustment',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $inventoryService = app(InventoryService::class);

        $inventoryService->process(
            $this->product_id,
            $this->type,
            $this->quantity,
            $this->notes
        );

        // Reset inputs and close modal
        $this->reset(['type', 'quantity', 'notes', 'showModal']);
        $this->loadTransactions();

        session()->flash('success', 'Transaction saved successfully!');
    }

    public function render()
    {
        return view('livewire.inventory.index', [
            'transactions' => $this->transactions
        ]);
    }
}
