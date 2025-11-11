<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Product;
use App\Models\User;

// === Admin Controllers ===
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// === Seller Controller ===
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;

<<<<<<< HEAD
// (opsional) Buyer controller kamu sendiri
// use App\Http\Controllers\Buyer\DashboardController as BuyerDashboard;

/* ----------------------------------------
| Healthcheck
|---------------------------------------- */
Route::get('/_health', fn () => 'ok');

/* ----------------------------------------
| Helpers (aman saat DB belum siap)
|---------------------------------------- */
=======
/*
|--------------------------------------------------------------------------
| Healthcheck (untuk cek hidup)
|--------------------------------------------------------------------------
*/
Route::get('/_health', fn () => 'ok');

/*
|--------------------------------------------------------------------------
| Helper kecil (aman saat DB belum siap)
|--------------------------------------------------------------------------
*/
>>>>>>> 3a42f34011c4a49c0f9265cf5828a7ff891dcb76
if (! function_exists('safeCount')) {
    function safeCount(callable $cb): int {
        try { return (int) $cb(); } catch (\Throwable $e) { return 0; }
    }
}
if (! function_exists('pickDashboardView')) {
    function pickDashboardView(string $who): string {
        if (view()->exists("dashboard.$who"))  return "dashboard.$who";
        if (view()->exists("dashboards.$who")) return "dashboards.$who";
        return 'static.dashboard'; // fallback agar tidak 500
    }
}

/* ----------------------------------------
| Public pages
|---------------------------------------- */

// HOME / LANDING (aman tanpa DB)
Route::get('/', function () {
    $products = collect();
    try {
        if (class_exists(Product::class)) {
            $products = Product::query()->take(3)->get();
        }
    } catch (\Throwable $e) {
        // biarkan kosong agar tidak 500 saat DB belum siap
    }
    return view('home', ['products' => $products]);
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
    Route::delete('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove'); // form pakai @method('DELETE')
});

// HALAMAN STATIS (publik)
Route::view('/tentang-kami', 'static.about')->name('about');

// Bantuan publik: tersedia di /bantuan dan alias /help
Route::view('/bantuan', 'static.help')->name('help');
Route::get('/help', fn () => redirect()->route('help'));

/* ----------------------------------------
| Auth (custom login view + Breeze actions)
|---------------------------------------- */
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

/* ----------------------------------------
| Redirect /dashboard -> sesuai role
|---------------------------------------- */
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (! $user) return redirect()->route('login');

    $target = match ($user->role ?? 'buyer') {
        'admin'  => 'admin.dashboard',
        'seller' => 'seller.dashboard',
        default  => 'buyer.dashboard',
    };

    // kalau rute target ada => redirect, kalau tidak ada => fallback view
    return Route::has($target) ? redirect()->route($target) : view('dashboard');
})->middleware('auth')->name('dashboard');

/* ----------------------------------------
| ADMIN (Dashboard + CRUD)
|---------------------------------------- */
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        $user = auth()->user();
        if (($user->role ?? null) !== 'admin') abort(403);

        $stats = [
            'total_products' => safeCount(fn () => Product::count()),
            'users'          => safeCount(fn () => User::count()),
        ];

        $users    = collect();
        $products = collect();
        try { $users = User::latest()->paginate(8); } catch (\Throwable $e) {}
        try { $products = Product::latest()->paginate(8); } catch (\Throwable $e) {}

        $view = view()->exists('dashboard.admin') ? 'dashboard.admin' : pickDashboardView('admin');
        return view($view, compact('stats','users','products'));
    })->name('dashboard');

    Route::resource('users',    AdminUserController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
});

/* ----------------------------------------
| SELLER (pakai Controller biar rapi)
|---------------------------------------- */
Route::prefix('seller')->name('seller.')->middleware('auth')->group(function () {
    // /seller -> dashboard penjual
    Route::get('/', [SellerDashboard::class, 'index'])->name('dashboard'); // view: resources/views/seller/dashboard.blade.php
});

/* ----------------------------------------
| BUYER
<<<<<<< HEAD
|---------------------------------------- */
=======
|--------------------------------------------------------------------------
*/
>>>>>>> 3a42f34011c4a49c0f9265cf5828a7ff891dcb76
Route::prefix('buyer')->name('buyer.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if (($user->role ?? 'buyer') !== 'buyer') abort(403);

        $stats = ['wish' => 0];
<<<<<<< HEAD
        return view('buyer.index', compact('stats')); // pastikan view ada
    })->name('dashboard');
=======
        // panggil view dashboard buyer yang kamu buat
        return view('buyer.index', compact('stats'));
    })->name('dashboard');

    // Bantuan versi buyer (login) -> view sama dengan publik
    Route::view('/help', 'static.help')->name('help');

    // STORES (daftar toko & detail toko) — opsional sesuai kebutuhanmu
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/store/{store:slug}', [StoreController::class, 'show'])->name('stores.show');
>>>>>>> 3a42f34011c4a49c0f9265cf5828a7ff891dcb76
});
