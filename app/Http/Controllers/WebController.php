<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ContactMessage;
use App\Mail\ContactThankYouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class WebController extends Controller
{
    public function home()
    {
        return view('web.pages.home');
    }
    public function products()
    {
        return view('web.pages.product');
    }
    public function productDetail($slug)
    {
        return view('web.pages.product-detail', ['slug' => $slug]);
    }
    public function cart()
    {
        return view('web.pages.cart');
    }
    public function login()
    {
        return view('web.auth.login');
    }
    public function register()
    {
        return view('web.auth.register');
    }

    public function profile()
    {
        $user = Auth::user();

        $ordersQuery = Order::where('user_id', $user->id);

        $totalOrders = (clone $ordersQuery)->count();
        $activeOrders = (clone $ordersQuery)->whereIn('status', ['pending', 'confirmed'])->count();
        $completedOrders = (clone $ordersQuery)->whereIn('status', ['completed', 'delivered'])->count();

        return view('web.account.index', compact(
            'user',
            'totalOrders',
            'activeOrders',
            'completedOrders'
        ));
    }

    public function orders()
    {
        return view('web.orders.listing');
    }

    public function orderDetail($id)
    {
        return view('web.orders.detail', ['id' => $id]);
    }

    public function downloadReceipt(Order $order)
    {
        $user = Auth::user();

        // Ensure the authenticated user owns this order
        if (!$user || $order->user_id !== $user->id) {
            abort(403);
        }

        $order->loadMissing(['items.product', 'user']);

        $isRefunded = !is_null($order->refunded_at);

        // Choose the correct PDF view + filename based on refund status
        $view = $isRefunded
            ? 'emails.orders.refund-pdf'
            : 'emails.orders.receipt-pdf';

        $filename = ($isRefunded ? 'refund-receipt-' : 'receipt-') . $order->uid . '.pdf';

        $pdf = Pdf::loadView($view, [
            'order' => $order,
        ]);

        return $pdf->download($filename);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'order_id' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'order_id' => $validated['order_id'] ?? null,
            'message' => $validated['message'],
        ]);

        try {
            Mail::to($contactMessage->email)->send(new ContactThankYouMail($contactMessage));
        } catch (\Throwable $e) {
            info('Failed to send contact thank you email', [
                'contact_message_id' => $contactMessage->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Thank you for contacting us! We will get back to you shortly.',
            ]);
        }

        return back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }
}
