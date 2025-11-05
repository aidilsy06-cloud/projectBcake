<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Product;
use App\Models\User;

Route::get('/_health', fn () => 'ok');

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

// HOME / LANDING
Route::get('/', function () {
    return view('home', [
        'products' => Product::take(3)->get(),
    ]);
})->name('home');

// PRODUK (PUBLIC)
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/product/{product:slug}', 'show')->name('products.show');
});

// KERANJANG (PUBLIC / SESSION)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    // pakai method spoofing di form: <form method="POST">@csrf @method('DELETE')</form>
    Route::delete('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove');
});

// HALAMAN STATIS
Route::view('/tentang-kami', 'static.about')->name('about');
Route::view('/bantuan', 'static.help')->name('help');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',   [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register',[RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Role-based Dashboard
|--------------------------------------------------------------------------
*/

// /dashboard -> arahkan sesuai role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) return redirect()->route('login');

    return match ($user->role) {
        'admin'  => redirect()->route('admin.dashboard'),
        'seller' => redirect()->route('seller.dashboard'),
        default  => redirect()->route('buyer.dashboard'),
    };
})->middleware('auth')->name('dashboard');

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'total_products' => Product::count(),
            'users'          => User::count(),
        ];
        return view('dashboard.admin', compact('stats'));
    })->name('dashboard');
});

// PENJUAL
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'my_products' => Product::count(), // ganti ke where('user_id', auth()->id()) kalau ada kolom owner
        ];
        return view('dashboard.seller', compact('stats'));
    })->name('dashboard');
});

// PEMBELI
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', function () {
        $stats = ['wish' => 0];
        return view('dashboard.buyer', compact('stats'));
    })->name('dashboard');
});
