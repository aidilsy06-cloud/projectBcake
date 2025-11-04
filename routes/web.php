<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/_health', fn() => 'ok');
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
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/product/{product:slug}', 'show')->name('products.show');
});

// === KERANJANG (PUBLIC / SESSION) ===
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',          [CartController::class, 'index'])->name('index');
    Route::post('/add/{product:slug}',    [CartController::class, 'add'])->name('add');
    Route::post('/update',   [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove'); // <- DELETE
});

// === HALAMAN STATIS ===
Route::view('/tentang-kami', 'static.about')->name('about');
Route::view('/bantuan', 'static.help')->name('help');

// === AUTH (LOGIN / REGISTER / LOGOUT) ===
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',   [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register',[RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// === DASHBOARD (PROTECTED) ===
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
