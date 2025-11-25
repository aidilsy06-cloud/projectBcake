<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// HOME publik
use App\Http\Controllers\HomeController;

// Buyer / publik
use App\Http\Controllers\Buyer\StoreController;
use App\Http\Controllers\Buyer\HomeController as BuyerHomeController;

// Seller
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Seller\StoreController as SellerStore;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;   // tracking pesanan seller

// Admin
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;     // CRUD toko admin
use App\Http\Controllers\Admin\OrderController as AdminOrderController;     // tracking pesanan admin

// Order / transaksi (form → WhatsApp)
use App\Http\Controllers\OrderController;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;

/* ----------------------------------------
| HEALTHCHECK
|---------------------------------------- */
Route::get('/_health', fn () => 'ok');

/* ----------------------------------------
| HELPERS (aman saat DB belum siap)
|---------------------------------------- */
if (! function_exists('safeCount')) {
    function safeCount(callable $cb): int {
        try {
            return (int) $cb();
        } catch (\Throwable $e) {
            return 0;
        }
    }
}

if (! function_exists('pickDashboardView')) {
    function pickDashboardView(string $who): string {
        if (view()->exists("dashboard.$who"))  return "dashboard.$who";
        if (view()->exists("dashboards.$who")) return "dashboards.$who";
        return 'static.dashboard';
    }
}

/* ----------------------------------------
| PUBLIC PAGES
|---------------------------------------- */
// Halaman depan (landing page publik)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Produk publik
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');

    // DETAIL PRODUK (pakai slug)
    Route::get('/product/{product:slug}', 'show')->name('products.show');
});

// Halaman Kategori (pakai route model binding Category:slug)
Route::get('/kategori/{category:slug}', [ProductController::class, 'byCategory'])
    ->name('categories.show');

/* ----------------------------------------
| CART / KERANJANG  (WAJIB LOGIN)
|---------------------------------------- */
Route::middleware('auth')
    ->prefix('cart')
    ->name('cart.')
    ->group(function () {

        // Lihat keranjang
        Route::get('/', [CartController::class, 'index'])->name('index');

        // HALAMAN CHECKOUT (lanjut ke pemesanan)
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

        // Tambah ke keranjang -> form: route('cart.add', $product)
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');

        // Update banyak item sekaligus
        Route::post('/update', [CartController::class, 'update'])->name('update');

        // Hapus satu item (pakai parameter product)
        Route::delete('/item/{product}', [CartController::class, 'remove'])->name('remove');

        // Kosongkan seluruh keranjang
        Route::delete('/', [CartController::class, 'clear'])->name('clear');
    });

/* ----------------------------------------
| HALAMAN STATIS
|---------------------------------------- */
Route::view('/tentang-kami', 'static.about')->name('about');
Route::view('/bantuan', 'static.help')->name('help');
Route::redirect('/help', '/bantuan');

/* ----------------------------------------
| TOKO (PUBLIK / BUYER)
|---------------------------------------- */
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/store/{store:slug}', [StoreController::class, 'show'])->name('stores.show');

/* ----------------------------------------
| ORDER → WHATSAPP PENJUAL + HALAMAN SUKSES
|---------------------------------------- */

// FORM PEMESANAN → simpan order + siapkan URL WA
Route::middleware('auth')
    ->post('/store/{store:slug}/order', [OrderController::class, 'store'])
    ->name('stores.order');

// HALAMAN SUKSES SETELAH PESANAN DIBUAT
Route::middleware('auth')
    ->get('/orders/{order}/success', [OrderController::class, 'success'])
    ->name('orders.success');

/* ----------------------------------------
| AUTH (LOGIN / REGISTER / LOGOUT)
|---------------------------------------- */
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Register
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/* ----------------------------------------
| DASHBOARD REDIRECT (UMUM)
|---------------------------------------- */
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (! $user) {
        return redirect()->route('login');
    }

    $target = match ($user->role ?? 'buyer') {
        'admin'  => 'admin.dashboard',
        'seller' => 'seller.dashboard',
        default  => 'buyer.dashboard',
    };

    return Route::has($target)
        ? redirect()->route($target)
        : view('dashboard');
})->middleware('auth')->name('dashboard');

/* ----------------------------------------
| ADMIN
|---------------------------------------- */
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', function () {
            $user = auth()->user();

            abort_unless(($user->role ?? null) === 'admin', 403);

            $stats = [
                'total_products' => safeCount(fn () => Product::count()),
                'users'          => safeCount(fn () => User::count()),
                'orders'         => safeCount(fn () => Order::count()),
            ];

            $users    = collect();
            $products = collect();

            try { $users = User::latest()->paginate(8); } catch (\Throwable $e) {}
            try { $products = Product::latest()->paginate(8); } catch (\Throwable $e) {}

            $view = view()->exists('dashboard.admin')
                ? 'dashboard.admin'
                : pickDashboardView('admin');

            return view($view, compact('stats', 'users', 'products'));
        })->name('dashboard');

        // CRUD User
        Route::resource('users', AdminUserController::class)->except(['show']);

        // CRUD Produk
        Route::resource('products', AdminProductController::class)->except(['show']);

        // ✅ route khusus update status produk
        Route::post('/products/{product}/status', [AdminProductController::class, 'updateStatus'])
            ->name('products.updateStatus');

        // CRUD Toko
        Route::resource('stores', AdminStoreController::class)->except(['show']);

        // TRACKING PESANAN (ADMIN)
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

/* ----------------------------------------
| SELLER
|---------------------------------------- */
Route::middleware(['auth', 'verified'])
    ->prefix('seller')
    ->as('seller.')
    ->group(function () {
        Route::get('/', [SellerDashboard::class, 'index'])->name('dashboard');

        // Kelola toko
        Route::get('/store', [SellerStore::class, 'show'])->name('store.show');
        Route::get('/store/edit', [SellerStore::class, 'edit'])->name('store.edit');
        Route::put('/store', [SellerStore::class, 'update'])->name('store.update');

        // Produk seller
        Route::get('/products', [SellerProductController::class, 'index'])
            ->name('products.index');

        Route::get('/products/create', [SellerProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [SellerProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [SellerProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [SellerProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])
            ->name('products.destroy');

        // TRACKING PESANAN (SELLER)
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Halaman lain placeholder
        Route::get('/promos', fn () => view('seller.placeholders.promos'))->name('promos.index');
        Route::get('/settings', fn () => view('seller.placeholders.settings'))->name('settings');
    });

/* ----------------------------------------
| BUYER
|---------------------------------------- */
Route::prefix('buyer')
    ->name('buyer.')
    ->middleware('auth')
    ->group(function () {

        // DASHBOARD PEMBELI
        Route::get('/dashboard', [BuyerHomeController::class, 'index'])
            ->name('dashboard');

        // Bantuan (versi buyer)
        Route::view('/help', 'static.help')->name('help');

        // Toko untuk buyer
        Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
        Route::get('/store/{store:slug}', [StoreController::class, 'show'])->name('stores.show');

        // RIWAYAT PESANAN BUYER
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    });
