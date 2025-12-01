<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
