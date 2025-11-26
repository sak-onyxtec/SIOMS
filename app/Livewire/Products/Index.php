<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\App;

class Index extends Component
{
    public $selectedProductId;
    private $productService;

    public function mount()
    {
        $this->productService = App::make(ProductService::class);
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
        return view('livewire.products.index', [
            'products' => Product::all()
        ]);
    }
}
