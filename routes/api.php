<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\CartController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::group(['middleware'=>"auth:sanctum"],function(){

    //logout and me route
    Route::post('/logout',[AuthController::class,"logout"]);
    Route::get('/me',[AuthController::class,'me']);

    //product route
    Route::apiResource('/products',ProductController::class);

    // cart route
    Route::prefix('cart')->group(function(){
        Route::get('/',[CartController::class,'index'])->name('cart.index');
        Route::post('add-item/{product}',[CartController::class,'addItem'])->name('cart.addItem');
        Route::post('increase-item/{cart}',[CartController::class,'increase'])->name('cart.increase');
        Route::post('decrease-item/{cart}',[CartController::class,'decrease'])->name('cart.decrease');
        Route::delete('remove-item/{cart}',[CartController::class,'removeItem'])->name('cart.removeItem');
    });
    
});

