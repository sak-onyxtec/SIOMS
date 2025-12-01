<?php

namespace App\Livewire\Products\Web;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Listing extends Component
{
    use WithPagination;

    public $perPage = 12;
    public $search = '';
    public $category = '';
    public $minPrice = null;
    public $maxPrice = null;
    public $viewMode = 'grid';
    public $lowStock = false;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        // Check if lowStock filter is passed via query parameter
        if (request()->has('lowStock') && request()->get('lowStock') == '1') {
            $this->lowStock = true;
        }
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->minPrice = null;
        $this->maxPrice = null;
        $this->lowStock = false;
    }

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->category, fn($q) => $q->where('category_id', $this->category))
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice))
            ->when($this->lowStock, fn($q) => $q->where('quantity', '<=', 5))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('livewire.products.web.listing', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
