<?php

namespace App\Http\Controllers;

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

        // Build order from cart
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.web')->with('error', 'Cart is empty, cannot create order.');
        }

        $items = [];
        $total = 0;
        foreach ($cart as $productId => $item) {
            $items[] = [
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
            ];
            $total += $item['price'] * $item['quantity'];
        }

        /** @var OrderService $orderService */
        $orderService = app(OrderService::class);

        $orderRequest = new Request([
            'total' => $total,
            'items' => $items,
        ]);

        $order = $orderService->addOrder($orderRequest);

        // Clear cart after successful order creation
        Session::forget('cart');

        return redirect()->route('orders.success')->with('success', 'Order placed successfully!');
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
