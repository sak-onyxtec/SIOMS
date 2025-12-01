<?php

use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'home'])->name('home.web');
Route::get('/products', [WebController::class, 'products'])->name('products.web');
Route::get('/products/{slug}', [WebController::class, 'productDetail'])->name('products.detail.web');
Route::get('/cart', [WebController::class, 'cart'])->name('cart.web');
Route::get('/login',[WebController::class,'login'])->name('login.web');
Route::get('/register',[WebController::class,'register'])->name('register.web');


Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/orders', [WebController::class, 'orders'])->name('orders.web.listing');
    Route::get('/orders/{id}', [WebController::class, 'orderDetail'])->name('orders.web.detail');
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index')->can('view-products');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create')->can('create-products');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit')->can('edit-products');
        Route::get('/view/{id}', [ProductController::class, 'view'])->name('product.view');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/destroy', [ProductController::class, 'destroy'])->name('product.destroy')->can('delete-products');
        Route::get('/listing', [ProductController::class, 'listing'])->name('product.listing');
        Route::get('/{id}', [ProductController::class, 'detail'])->name('products.detail');
    });
    Route::group(['prefix' => 'staff'], function () {
        Route::get('/', [StaffController::class, 'staffs'])->name('staff.index');
        Route::get('/get-staffs', [StaffController::class, 'getStaffs'])->name('staff.getStaffs');
        Route::get('/create', [StaffController::class, 'addStaff'])->name('staff.create');
        Route::post('/create', [StaffController::class, 'addStaff'])->name('staff.store');
        Route::get('/edit/{id}', [StaffController::class, 'updateStaff'])->name('staff.edit');
        Route::post('/edit/{id}', [StaffController::class, 'updateStaff'])->name('staff.edit');
        Route::delete('/destroy', [StaffController::class, 'deleteStaff'])->name('staff.destroy');
    });
    Route::group(['prefix' => 'role', 'middleware' => ['check.role:admin']], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('roles.index');
        Route::get('/{role}/permissions', [PermissionController::class, 'update'])->name('roles.permissions');
    });
    // Route::group(['prefix' => 'cart'], function () {
    //     Route::get('/', [ProductController::class, 'cart'])->name('cart.index');
    // });
    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/', [ProductController::class, 'inventory'])->name('inventory.index');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::get('/my',[OrderController::class,'myOrders'])->name('orders.my');
        Route::get('/',[OrderController::class,'index'])->name('orders.index');
        Route::get('/detail/{id}',[OrderController::class,'detail'])->name('orders.detail');
        Route::get('/success', function () {
            return view('web.orders.success');
        })->name('orders.success');
    });
});


require __DIR__ . '/auth.php';
