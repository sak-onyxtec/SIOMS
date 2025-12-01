<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\OrderTrail;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = ''; // filter dropdown

    protected $paginationTheme = 'tailwind';
    protected $statuses = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'delivered' => 'Delivered',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    protected $listeners = ['changeStatus'];
    public function changeStatus($orderId, $newStatus)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $newStatus;
            $order->save();
            OrderTrail::create([
                'order_id' => $order->id,
                'user_id' => Auth::id() ?? null,
                'status' => $newStatus,
            ]);

            // Handle cancelled order inventory
            if ($newStatus === 'cancelled') {
                $inventoryService = app(InventoryService::class);

                foreach ($order->items as $item) {
                    try {
                        $inventoryService->process(
                            $item->product_id,
                            'stock_in',
                            $item->quantity,
                            'Order Cancelled #' . $order->uid
                        );
                    } catch (\Exception $e) {
                        $this->addError('inventory', "Product {$item->product->name}: " . $e->getMessage());
                    }
                }
            }


            // $this->emit('statusUpdated', "Order #{$order->uid} status updated to {$newStatus}");
        }
    }

    public function render()
    {
        $orders = Order::when(
            $this->search,
            fn($q) =>
            $q->where('uid', 'like', "%{$this->search}%")
                ->orWhere('status', 'like', "%{$this->search}%")
        )
            ->when(
                $this->status,
                fn($q) =>
                $q->where('status', $this->status)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statuses = $this->statuses;
        return view('livewire.orders.index', [
            'orders' => $orders,
            'statuses' => $statuses,
        ]);
    }
}
