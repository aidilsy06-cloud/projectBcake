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

// === Buyer Controllers ===
use App\Http\Controllers\Buyer\StoreController;

// ----------------------------------------
// Healthcheck
// ----------------------------------------
Route::get('/_health', fn () => 'ok');

// ----------------------------------------
// Helpers (aman saat DB belum siap)
// ----------------------------------------
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

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

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
    Route::delete('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove'); // pakai @method('DELETE') di form
});

// HALAMAN STATIS
Route::view('/tentang-kami', 'static.about')->name('about');
Route::view('/bantuan', 'static.help')->name('help');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
| GET /login diarahkan ke view custom (auth.login).
| POST /login tetap ke Breeze untuk autentikasi.
*/
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register',[RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Role-based Dashboard (tanpa middleware role:, dicek manual)
|--------------------------------------------------------------------------
*/

// /dashboard => redirect sesuai role (fallback 'buyer')
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (! $user) return redirect()->route('login');

    $role = $user->role ?? 'buyer';
    $target = match ($role) {
        'admin'  => 'admin.dashboard',
        'seller' => 'seller.dashboard',
        default  => 'buyer.dashboard',
    };

    return Route::has($target) ? redirect()->route($target) : view('dashboard'); // fallback
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (Dashboard + CRUD Users & Products)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
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

/*
|--------------------------------------------------------------------------
| SELLER
|--------------------------------------------------------------------------
*/
Route::prefix('seller')->name('seller.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if (($user->role ?? null) !== 'seller') abort(403);

        $stats = [
            // ganti ke where('user_id', auth()->id()) jika sudah ada relasi owner
            'my_products' => safeCount(fn () => Product::count()),
        ];

        return view(pickDashboardView('seller'), compact('stats'));
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| BUYER
|--------------------------------------------------------------------------
*/
// BUYER
Route::prefix('buyer')->name('buyer.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if (($user->role ?? 'buyer') !== 'buyer') abort(403);

        $stats = ['wish' => 0];
        // panggil view yang kamu buat
        return view('buyer.index', compact('stats'));
    })->name('dashboard');
});

