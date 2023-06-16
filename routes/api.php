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
    Route::apiResource('cart',CartController::class);


});

