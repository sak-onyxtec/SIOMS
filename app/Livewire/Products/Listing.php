<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Listing extends Component
{
    use WithPagination;

    public $perPage = 3;      
    public $search = '';       
    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        info($this->search);
        $products = Product::query()
            ->when($this->search, function($query) {
                $query->where('name', 'LIKE', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.products.listing', [
            'products' => $products
        ]);
    }
}
