<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderConfirmationJob;
use App\Models\Order;
use App\Models\OrderTrail;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeCheckoutSession;

class OrderController extends Controller
{
    public function stripeSuccess(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login.web');
        }

        $sessionId = $request->query('session_id');
        $orderId = $request->query('order_id');
        
        if (!$sessionId) {
            return redirect()->route('cart.web')->with('error', 'Payment session not found.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $checkoutSession = StripeCheckoutSession::retrieve($sessionId);
        } catch (\Throwable $e) {
            return redirect()->route('cart.web')->with('error', 'Unable to verify payment.');
        }

        if ($checkoutSession->payment_status !== 'paid') {
            return redirect()->route('cart.web')->with('error', 'Payment was not completed.');
        }

        if ($orderId) {
            $order = Order::with(['items.product', 'user'])->find($orderId);
            if ($order) {
                if (is_null($order->paid_at)) {
                    // Mark order as paid/confirmed
                    $order->stripe_payment_intent_id = $checkoutSession->payment_intent ?? null;
                    $order->paid_at = now();
                    $order->status = 'confirmed';
                    $order->save();

                    OrderTrail::create([
                        'order_id' => $order->id,
                        'user_id' => Auth::id() ?? null,
                        'status' => 'confirmed',
                    ]);

                    // Send order confirmation mail (our own receipt)
                    if ($order->user && $order->user->email) {
                        dispatch(new SendOrderConfirmationJob($order));
                    }

                    // Note: Stripe's own email receipt will be sent automatically
                    // because we passed customer_email when creating the Checkout Session.
                } else {
                    info("Attempted to process payment for already paid order: {$order->id}");
                }
            }
        }
        Session::forget('cart');

        return view('web.orders.success');
    }
    public function index()
    {
        return view('orders.index');
    }

    public function myOrders()
    {
        return view('orders.my-order');
    }

    public function detail($id)
    {
        return view('orders.detail')->with('id', $id);
    }
}
