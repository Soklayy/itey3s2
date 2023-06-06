<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::group(['middleware'=>"auth:sanctum"],function(){
    Route::post('/logout',[AuthController::class,"logout"]);
    Route::get('/me',[AuthController::class,'me']);
    Route::apiResource('/products',ProductController::class);
});

