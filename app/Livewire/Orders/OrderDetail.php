<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderDetail extends Component
{
    public $order;

    public function mount($orderId)
    {
        $this->order = Order::where('id', $orderId)
            // ->where('user_id', Auth::id())
            ->with(['items.product', 'trails'=> function ($query) {
                $query->with('user')->latest();
            }])
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.orders.order-detail');
    }
}
