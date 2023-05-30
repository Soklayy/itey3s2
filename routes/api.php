<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::middleware("auth:santum")->group(function(){
    Route::post('/logout',[AuthController::class,"logout"]);
    Route::get('/me',[AuthController::class,'me']);
});
