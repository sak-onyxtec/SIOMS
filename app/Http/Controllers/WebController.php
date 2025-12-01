<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function orders()
    {
        return view('web.orders.listing');
    }

    public function orderDetail($id)
    {
        return view('web.orders.detail', ['id' => $id]);
    }
}
