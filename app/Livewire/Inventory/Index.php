<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $product_id;
    public $type;
    public $quantity;
    public $notes;

    public $products;
    public $transactions;

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
        $query = InventoryTransaction::latest();

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

        $product = Product::findOrFail($this->product_id);

        // Prevent stock going negative
        if ($this->type === 'stock_out' && $product->stock < $this->quantity) {
            $this->addError('quantity', 'Not enough stock available.');
            return;
        }

        // Adjust stock
        if ($this->type === 'stock_in') {
            $product->increment('quantity', $this->quantity);
        } elseif ($this->type === 'stock_out') {
            $product->decrement('quantity', $this->quantity);
        } elseif ($this->type === 'adjustment') {
            $product->quantity = $this->quantity;
            $product->save();
        }

        // Log transaction
        $inventory = InventoryTransaction::create([
            'type' => $this->type,
            'quantity' => $this->quantity,
            'notes' => $this->notes,
        ]);
        $inventory->product_id = $this->product_id;
        $inventory->user_id = Auth::id();
        $inventory->save();

        // Reset inputs
        $this->reset(['type', 'quantity', 'notes']);
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
