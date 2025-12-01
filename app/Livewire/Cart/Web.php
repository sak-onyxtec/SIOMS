<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;


class Web extends Component
{
    public $cart = [];
    public $subtotal = 0;
    public $taxRate = 0.15; // 15% tax
    public $tax = 0;
    public $total = 0;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = Session::get('cart', []);
        $this->calculateTotals();
    }

    public function increment($productId)
    {
        if (!isset($this->cart[$productId])) return;

        $cartItem = $this->cart[$productId];

        if ($cartItem['quantity'] < $cartItem['stock']) {
            // Increment cart quantity
            $this->cart[$productId]['quantity']++;

            // Decrement product stock in DB
            $product = Product::find($productId);
            if ($product && $product->quantity > 0) {
                $product->decrement('quantity', 1);
            }

            Session::put('cart', $this->cart);
            $this->calculateTotals();
        } else {
            session()->flash('message', 'Cannot exceed available stock!');
        }
    }

    public function decrement($productId)
    {
        if (!isset($this->cart[$productId])) return;

        if ($this->cart[$productId]['quantity'] > 1) {
            // Decrement cart quantity
            $this->cart[$productId]['quantity']--;

            // Increment product stock in DB
            $product = Product::find($productId);
            if ($product) {
                $product->increment('quantity', 1);
            }

            Session::put('cart', $this->cart);
            $this->calculateTotals();
        }
    }

    public function remove($productId)
    {
        if (!isset($this->cart[$productId])) return;

        $cartItem = $this->cart[$productId];

        // Restore product stock in DB
        $product = Product::find($productId);
        if ($product) {
            $product->increment('quantity', $cartItem['quantity']);
        }

        unset($this->cart[$productId]);
        Session::put('cart', $this->cart);
        $this->calculateTotals();
        session()->flash('message', 'Product removed from cart!');
    }

    public function clearCart()
    {
        foreach ($this->cart as $productId => $cartItem) {
            $product = Product::find($productId);
            if ($product) {
                $product->increment('quantity', $cartItem['quantity']);
            }
        }

        $this->cart = [];
        Session::forget('cart');
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->cart));
        // $this->tax = $this->subtotal * $this->taxRate;
        $this->total = $this->subtotal;
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login.web');
        }

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            session()->flash('message', 'Your cart is empty!');
            return;
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($cart as $id => $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => intval($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('orders.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.web'),
        ]);

        return redirect($checkoutSession->url);
    }

    public function render()
    {
        return view('livewire.cart.web');
    }
}
