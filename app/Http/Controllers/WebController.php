<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ContactMessage;
use App\Mail\ContactThankYouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            logger()->error('Failed to send contact thank you email', [
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
