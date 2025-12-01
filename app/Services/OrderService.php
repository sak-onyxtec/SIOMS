<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileManagerTrait;

class OrderService
{
    use FileManagerTrait;

    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Add new order
     */
    public function addOrder(Request $request)
    {
        $order = Order::create([
            'status'  => 'pending',
            'total'   => $request->input('total', 0),
        ]);
        $order->user_id = Auth::id();
        $order->uid = $this->generateOrderUID($order);
        $order->save();

        $orderItems = [];
        if ($request->filled('items')) {
            foreach ($request->input('items') as $item) {
                $product = Product::find($item['product_id']);
                if (!$product || $product->quantity < $item['quantity']) continue;

                $this->inventoryService->process($product->id, 'stock_out', $item['quantity'], 'Order #' . $order->uid);

                $orderItems[] = [
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            OrderItem::insert($orderItems);
        }

        OrderTrail::create([
            'order_id' => $order->id,
            'user_id'  => Auth::id(),
            'status'   => 'pending',
        ]);

        return $order;
    }

    /**
     * Update existing order
     */
    public function updateOrder(Request $request, $orderId)
    {
        $order = Order::with('items')->find($orderId);
        if (!$order) return null;

        $orderItems = [];
        if ($request->filled('items')) {
            OrderItem::where('order_id', $order->id)->delete();
            foreach ($request->input('items') as $item) {
                $product = Product::find($item['product_id']);
                if (!$product || $product->quantity < $item['quantity']) continue;

                $this->inventoryService->process($product->id, 'stock_out', $item['quantity'], 'Order #' . $order->uid);

                $orderItems[] = [
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            OrderItem::insert($orderItems);
        }

        return $order;
    }

    public function changeOrderStatus(Request $request, $orderId)
    {
        $order = Order::with('items')->find($orderId);
        if (!$order) return null;

        $newStatus = $request->input('status');
        $order->status = $newStatus;
        $order->save();

        OrderTrail::create([
            'order_id' => $order->id,
            'user_id'  => Auth::id(),
            'status'   => $newStatus,
        ]);

        if ($newStatus === 'cancelled') {
            foreach ($order->items as $item) {
                $this->inventoryService->process(
                    $item->product_id,
                    'stock_in',
                    $item->quantity,
                    'Cancelled Order #' . $order->uid
                );
            }
        }

        return $order;
    }

    public function deleteOrder($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) return null;
        $order->delete();
        return true;
    }

    public function getOrders(Request $request)
    {
        $orders = Order::when($request->filled('search'), function ($query) use ($request) {
            $search = '%' . $request->input('search') . '%';
            $query->where('uid', 'like', $search)
                ->orWhere('status', 'like', $search);
        })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->orderBy('created_at', 'desc');

        return $orders->paginate($request->input('per_page', 10));
    }

    private function generateOrderUID($booking)
    {
        $date = date("Ymd", strtotime($booking->created_at));
        return 'ORD-' . $date . '-' . $booking->id;
    }
}
