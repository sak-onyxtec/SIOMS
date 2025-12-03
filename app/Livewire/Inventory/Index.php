<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\InventoryTransaction;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    public $product_id;
    public $type;
    public $quantity;
    public $notes;

    public $products;

    public $showModal = false;

    public $sortBy = 'created_at';
    public $sortDirection = 'asc';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->products = Product::all();
    }

    public $filter_product_id;
    public $filter_type;

    protected function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:stock_in,stock_out,adjustment',
            'quantity'   => 'required|integer|min:1|max:999999',
        ];
    }

    public function updatedFilterProductId()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedQuantity(): void
    {
        $this->validateOnly('quantity', $this->rules());
    }

    public function saveTransaction()
    {
        $this->validate($this->rules());
        
        $inventoryService = app(InventoryService::class);

        $inventoryService->process(
            $this->product_id,
            $this->type,
            $this->quantity,
            $this->notes
        );

        // Reset inputs and close modal, then reset pagination so list refreshes
        $this->reset(['type', 'quantity', 'notes', 'showModal']);
        $this->resetPage();

        session()->flash('success', 'Transaction saved successfully!');

        // Let frontend know to refresh the DataTable instance
        $this->dispatch('inventory-table-refresh');

    }

    public function sortByColumn($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function render()
    {
        $query = InventoryTransaction::with(['user', 'product'])
            ->orderBy($this->sortBy, $this->sortDirection);

        if (!is_null($this->filter_product_id) && $this->filter_product_id !== '') {
            $query->where('product_id', (int) $this->filter_product_id);
        }

        if (!is_null($this->filter_type) && $this->filter_type !== '') {
            $query->where('type', $this->filter_type);
        }

        $transactions = $query->get();

        return view('livewire.inventory.index', [
            'transactions' => $transactions
        ]);
    }
}
