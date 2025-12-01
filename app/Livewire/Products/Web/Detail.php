<?php

namespace App\Livewire\Products\Web;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Detail extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->product = Product::with('category')->where('slug', $slug)->firstOrFail();
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
        if ($this->product->quantity < $this->quantity) {
            session()->flash('message', 'Not enough stock available!');
            return;
        }

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

        // Decrement product quantity in the database
        $this->product->decrement('quantity', $this->quantity);
        $this->product->refresh(); // Update local product instance

        session()->flash('message', 'Product added to cart!');
        $this->quantity = 1; // reset quantity selector
    }

    public function render()
    {
        $relatedProducts = Product::with('category')->where('id', '!=', $this->product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('livewire.products.web.detail', [
            'relatedProducts' => $relatedProducts
        ]);
    }
}
