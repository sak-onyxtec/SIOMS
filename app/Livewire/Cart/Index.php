<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = Session::get('cart', []);
    }

    public function increment($id)
    {
        if (isset($this->cart[$id])) {
            $productQty = $this->cart[$id]['quantity'];
            $availableQty = $this->cart[$id]['stock'];

            if ($productQty < $availableQty) {
                $this->cart[$id]['quantity']++;
                $this->updateSession();
            } else {
                session()->flash('message', "Cannot exceed available stock for {$this->cart[$id]['name']}!");
            }
        }
    }

    public function decrement($id)
    {
        if (isset($this->cart[$id]) && $this->cart[$id]['quantity'] > 1) {
            $this->cart[$id]['quantity']--;
            $this->updateSession();
        }
    }


    public function remove($id)
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
            $this->updateSession();
        }
    }

    public function updateSession()
    {
        Session::put('cart', $this->cart);
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function render()
    {
        return view('livewire.cart.index');
    }
}
