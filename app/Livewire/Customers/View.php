<?php

namespace App\Livewire\Customers;

use App\Models\User;
use App\Models\Order;
use Livewire\Component;

class View extends Component
{
    public User $customer;

    public function mount($id)
    {
        $this->customer = User::role('customer')
            ->withCount('orders')
            ->findOrFail($id);
    }

    public function render()
    {
        $orders = Order::where('user_id', $this->customer->id)
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.customers.view', [
            'orders' => $orders,
        ]);
    }
}


