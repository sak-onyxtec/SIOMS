<?php

namespace App\Livewire\Products\Web;

use App\Models\Product;
use Livewire\Component;

class Feature extends Component
{
    public function render()
    {
        // Show latest 8 products for home page feature section
        $products = Product::query()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('livewire.products.web.feature', [
            'products' => $products,
        ]);
    }
}



