<?php

namespace App\Livewire\Web;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class HeaderCart extends Component
{
    public $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $this->cartCount = $this->getCartCount();
    }

    private function getCartCount()
    {
        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }

    public function render()
    {
        // Update count each render
        $this->updateCartCount();

        return view('livewire.web.header-cart');
    }
}
