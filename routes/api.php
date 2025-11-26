<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::group(['prefix'=>'app','as'=>'api.'],function(){
    Route::post('login',[AuthController::class,'login'])->name('login');

    Route::group(['middleware'=>'auth:sanctum'],function(){
        Route::get('get-my-profile',[AuthController::class,'getMyProfile'])->name('getMyProfile');


        Route::group(['prefix'=>'product'],function(){
            Route::post('/add',[ProductController::class,'addProduct'])->name('addProduct');
            Route::post('/update/{id}',[ProductController::class,'updateProduct'])->name('updateProduct');
            Route::get('/',[ProductController::class,'getProducts'])->name('getProducts');
            Route::delete('/delete/{id}',[ProductController::class,'deleteProduct'])->name('deleteProduct');
            Route::get('/{id}',[ProductController::class,'getProduct'])->name('getProduct');
        });
    });
});