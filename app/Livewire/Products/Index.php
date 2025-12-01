<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\App;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedProductId;
    public $lowStock = false;
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    protected $paginationTheme = 'tailwind';
    private $productService;

    public function mount()
    {
        $this->productService = App::make(ProductService::class);
        // Check if lowStock filter is passed via query parameter
        if (request()->has('lowStock') && request()->get('lowStock') == '1') {
            $this->lowStock = true;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
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

    public function delete($id)
    {
        $productService = app(ProductService::class);
        $productService->deleteProduct(request(), $id);
        session()->flash('success', 'Product deleted!');
    }

    public function selectProduct($id)
    {
        $this->selectedProductId = $id;
    }

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->lowStock, fn($q) => $q->where('quantity', '<=', 5))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.products.index', [
            'products' => $products
        ]);
    }
}
