<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Admin\AuthController;
use App\Http\Controllers\V1\Admin\DashboardController;
use App\Http\Controllers\V1\Admin\ProductController;
use App\Http\Controllers\V1\Admin\CategoryController;

Route::prefix('admin')->name('admin.')->group(function () {
    /** Administrator Authentication Routes */
    Route::get('/login', [AuthController::class, 'form'])->name('login-form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/me', [AuthController::class, 'me'])->name('me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /** Dashboard Routes */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /** Product Management */
    Route::get('/products/list', [ProductController::class, 'index'])->name('products.list');
    Route::get('/products', [ProductController::class, 'render'])->name('products.index');
    Route::resource('products', ProductController::class)
        ->except('index', 'render');

    /** Category Management */
    Route::resource('category', CategoryController::class);
});
