<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === HOME / LANDING PAGE ===
Route::get('/', function () {
    return view('home', [
        'products' => \App\Models\Product::take(3)->get(),
    ]);
})->name('home');

// === PRODUK (PUBLIC) ===
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// === KERANJANG (PUBLIC / SESSION) ===
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product:slug}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product:slug}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');


// ===========================================================================
// === AUTH ROUTES (LOGIN & REGISTER) =======================================
// ===========================================================================

// SHOW LOGIN PAGE
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest')
        ->name('login');

// PROCESS LOGIN
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest');

// LOGOUT
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

// REGISTRATION (OPSIONAL, JIKA ADA REGISTER)
Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware('guest')
        ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest');


// ===========================================================================
// === DASHBOARD (SETELAH LOGIN) ============================================
// ===========================================================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
