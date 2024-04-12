<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::name('user.')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/products', [HomeController::class, 'products']);
    Route::get('/me', [\App\Http\Controllers\Auth\LoginController::class, 'me']);
    Route::resource('cart', \App\Http\Controllers\V1\User\CartController::class);
    \Illuminate\Support\Facades\Auth::routes();
});
