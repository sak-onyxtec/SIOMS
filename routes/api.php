<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::group(['prefix' => 'app', 'as' => 'api.'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('get-my-profile', [AuthController::class, 'getMyProfile'])->name('getMyProfile');


        Route::group(['prefix' => 'product'], function () {
            Route::post('/add', [ProductController::class, 'addProduct'])->name('addProduct');
            Route::post('/update/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');
            Route::get('/', [ProductController::class, 'getProducts'])->name('getProducts');
            Route::delete('/delete/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
            Route::get('/{id}', [ProductController::class, 'getProduct'])->name('getProduct');
        });

        Route::group(['prefix' => 'order'], function () {
            Route::post('/add', [OrderController::class, 'addOrder'])->name('addOrder');
            Route::post('/update/{id}', [OrderController::class, 'updateOrder'])->name('updateOrder');
            Route::post('/update-status/{id}', [OrderController::class, 'updateOrderStatus'])->name('updateOrderStatus');
            Route::get('/', [OrderController::class, 'getOrders'])->name('getOrders');
            Route::delete('/delete/{id}', [OrderController::class, 'deleteOrder'])->name('deleteOrder');
            Route::get('/{id}', [OrderController::class, 'getOrder'])->name('getOrder');
        });
    });
});
