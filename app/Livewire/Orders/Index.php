<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\OrderTrail;
use App\Mail\OrderCancellationMail;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Stripe\Stripe;
use Stripe\Refund;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = ''; // filter dropdown
    public $loadingOrderId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

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
        try {
            $this->loadingOrderId = $orderId;
            $order = Order::with(['user', 'items.product'])->find($orderId);
            if ($order) {
            $order->status = $newStatus;
            $order->save();
            OrderTrail::create([
                'order_id' => $order->id,
                'user_id' => Auth::id() ?? null,
                'status' => $newStatus,
            ]);

            // Handle cancelled order inventory, refund, and email
            if ($newStatus === 'cancelled') {
                $inventoryService = app(InventoryService::class);
                $refunded = false;

                // Restore inventory
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

                // Process Stripe refund if order was paid
                if (!is_null($order->paid_at) && !is_null($order->stripe_payment_intent_id)) {
                    try {
                        $secret = config('services.stripe.secret') ?: env('stripe_secret', env('STRIPE_SECRET'));
                        
                        if (!empty($secret)) {
                            Stripe::setApiKey($secret);
                            
                            // Create refund
                            $refund = Refund::create([
                                'payment_intent' => $order->stripe_payment_intent_id,
                                'amount' => (int)($order->total * 100), // Convert to cents
                                'reason' => 'requested_by_customer',
                            ]);
                            
                            if ($refund->status === 'succeeded' || $refund->status === 'pending') {
                                $refunded = true;
                                $order->stripe_refund_id = $refund->id;
                                $order->refunded_at = now();
                                $order->save();
                                Log::info("Refund processed for order #{$order->uid}. Refund ID: {$refund->id}");
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Failed to process refund for order #{$order->uid}: " . $e->getMessage());
                        $this->addError('refund', 'Payment refund failed. Please process manually in Stripe dashboard.');
                    }
                }

                // Send cancellation email to user
                if ($order->user && $order->user->email) {
                    try {
                        Mail::to($order->user->email)->send(new OrderCancellationMail($order, $refunded));
                    } catch (\Exception $e) {
                        Log::error("Failed to send cancellation email for order #{$order->uid}: " . $e->getMessage());
                        $this->addError('email', 'Cancellation email could not be sent.');
                    }
                }
            }


            // $this->emit('statusUpdated', "Order #{$order->uid} status updated to {$newStatus}");
            }
        } catch (\Exception $e) {
            Log::error("Error changing order status: " . $e->getMessage());
            $this->addError('status', 'Failed to update order status. Please try again.');
        } finally {
            $this->loadingOrderId = null;
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
