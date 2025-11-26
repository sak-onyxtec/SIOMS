<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Detail extends Component
{
    public Product $product;
    public int $quantity = 1;

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
        $this->quantity = 1;
    }

    public function increment()
    {
        if ($this->quantity < $this->product->quantity) {
            $this->quantity++;
        } else {
            session()->flash('message', 'Cannot exceed available stock!');
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$this->product->id])) {
            $newQuantity = $cart[$this->product->id]['quantity'] + $this->quantity;

            $cart[$this->product->id]['quantity'] = min($newQuantity, $this->product->quantity);
        } else {
            $cart[$this->product->id] = [
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => $this->quantity,
                'image' => $this->product->product_image,
                'stock' => $this->product->quantity
            ];
        }

        Session::put('cart', $cart);
        session()->flash('message', 'Product added to cart!');
    }


    public function render()
    {
        $similarProducts = $this->similarProducts();

        return view('livewire.products.detail', [
            'similarProducts' => $similarProducts,
        ]);
    }

    public function similarProducts()
    {
        return \App\Models\Product::where('category', $this->product->category)
            ->where('id', '!=', $this->product->id)
            ->take(4)
            ->get();
    }
}
