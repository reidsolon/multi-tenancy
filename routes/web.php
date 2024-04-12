<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\V1\Main\TenantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/me', [\App\Http\Controllers\Auth\LoginController::class, 'me'])->name('me');
Auth::routes();
Route::get('/tenants', [TenantController::class, 'render'])->name('tenants.index');
Route::get('/tenants/list', [TenantController::class, 'index'])->name('tenants.list');
Route::resource('tenants', TenantController::class)
    ->except('index', 'render');
