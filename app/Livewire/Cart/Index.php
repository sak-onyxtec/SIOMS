<?php

namespace App\Livewire\Cart;

use App\Jobs\SendOrderConfirmationJob;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrail;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function checkout()
    {
        if (empty($this->cart)) {
            session()->flash('message', 'Your cart is empty!');
            return;
        }
        $inventoryService = app(InventoryService::class);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'total' => $this->total,
                'status' => 'pending'
            ]);

            $order->user_id = Auth::id();
            $order->uid = $this->generateOrderUID($order);
            $order->save();

            $order_items = [];

            foreach ($this->cart as $productId => $item) {

                try {
                    $inventoryService->process(
                        $productId,
                        'stock_out',
                        $item['quantity'],
                        'Order Checkout #' . $order->uid
                    );
                } catch (\Exception $e) {
                    $this->addError('cart', $e->getMessage());
                    return;
                }
                $order_items[] = [
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ];
            }

            if (!empty($order_items)) {
                OrderItem::insert($order_items);
            }

            OrderTrail::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'status' => 'pending',
            ]);

            Session::forget('cart');
            $this->cart = [];

            session()->flash('message', 'Order placed successfully!');
            $order->load('items.product', 'user');
            dispatch(new SendOrderConfirmationJob($order));
            DB::commit();

            return redirect()->route('orders.success');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'Order failed: ' . $e->getMessage());
        }
    }


    private function generateOrderUID($booking)
    {
        $date = date("Ymd", strtotime($booking->created_at));
        return 'ORD-' . $date . '-' . $booking->id;
    }


    public function render()
    {
        return view('livewire.cart.index');
    }
}
