<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// PUBLIC controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController as PublicOrderController;
use App\Http\Controllers\CartController;

// Auth controllers
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\OTPController;
use App\Http\Controllers\Auth\PasswordResetController; // 👈 NEW

// Buyer
use App\Http\Controllers\Buyer\StoreController;
use App\Http\Controllers\Buyer\HomeController as BuyerHomeController;
use App\Http\Controllers\Buyer\OrderController as BuyerOrderController;

// Seller
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Seller\StoreController as SellerStore;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;

// Admin
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Review (ULASAN PRODUK) 👇
use App\Http\Controllers\ReviewController;

// Models
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| HEALTHCHECK
|--------------------------------------------------------------------------
*/
Route::get('/_health', fn () => 'ok');

/*
|--------------------------------------------------------------------------
| SAFE HELPERS
|--------------------------------------------------------------------------
*/
if (! function_exists('safeCount')) {
    function safeCount(callable $cb): int {
        try { return (int) $cb(); }
        catch (\Throwable $e) { return 0; }
    }
}

if (! function_exists('pickDashboardView')) {
    function pickDashboardView(string $who): string {
        if (view()->exists("dashboard.$who"))  return "dashboard.$who";
        if (view()->exists("dashboards.$who")) return "dashboards.$who";
        return 'static.dashboard';
    }
}

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Produk publik
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/product/{product:slug}', 'show')->name('products.show');
});

// Kategori
Route::get('/kategori/{category:slug}', [ProductController::class, 'byCategory'])
    ->name('categories.show');

/*
|--------------------------------------------------------------------------
| CART (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('cart')
    ->name('cart.')
    ->group(function () {

        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::delete('/item/{product}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/', [CartController::class, 'clear'])->name('clear');
    });

/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
*/
Route::view('/tentang-kami', 'static.about')->name('about');
Route::view('/bantuan', 'static.help')->name('help');
Route::redirect('/help', '/bantuan');

/*
|--------------------------------------------------------------------------
| TOKO (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/store/{store:slug}', [StoreController::class, 'show'])->name('stores.show');

/*
|--------------------------------------------------------------------------
| ORDER VIA WHATSAPP + ULASAN (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Order via WA
    Route::post('/store/{store:slug}/order', [PublicOrderController::class, 'store'])
        ->name('stores.order');

    Route::get('/orders/{order}/success', [PublicOrderController::class, 'success'])
        ->name('orders.success');

    // ULASAN PRODUK (REVIEW) 👇
    // form di detail produk akan POST ke route ini
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
        ->name('products.reviews.store');
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN / REGISTER / OTP / LUPA PASSWORD)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // LOGIN
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // REGISTER
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // OTP VERIFIKASI REGISTER
    Route::get('/verify-otp', [OTPController::class, 'form'])->name('otp.form');
    Route::post('/verify-otp', [OTPController::class, 'verify'])->name('otp.verify');
    Route::post('/resend-otp', [OTPController::class, 'resend'])->name('otp.resend');

    /*
    |--------------------------------------------------------------------------
    | 🔐 LUPA PASSWORD (RESET VIA OTP)
    |--------------------------------------------------------------------------
    */

    // Step 1 — Form email
    Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])
        ->name('password.request');

    // Step 2 — Kirim OTP
    Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp'])
        ->name('password.email');

    // Step 3 — Form input OTP
    Route::get('/verify-reset-otp', [PasswordResetController::class, 'verifyForm'])
        ->name('password.verify');

    // Step 4 — Submit OTP
    Route::post('/verify-reset-otp', [PasswordResetController::class, 'verifyOtp'])
        ->name('password.otp.check');

    // Step 5 — Form password baru
    Route::get('/reset-password', [PasswordResetController::class, 'resetForm'])
        ->name('password.reset');

    // Step 6 — Update password
    Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])
        ->name('password.update');
});

// LOGOUT
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (! $user) return redirect()->route('login');

    $target = match ($user->role ?? 'buyer') {
        'admin'  => 'admin.dashboard',
        'seller' => 'seller.dashboard',
        default  => 'buyer.dashboard',
    };

    return Route::has($target)
        ? redirect()->route($target)
        : view('dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/', function () {
            $stats = [
                'total_products' => safeCount(fn () => Product::count()),
                'users'          => safeCount(fn () => User::count()),
                'orders'         => safeCount(fn () => Order::count()),
            ];

            $users = User::latest()->paginate(8);
            $products = Product::latest()->paginate(8);

            $view = view()->exists('dashboard.admin') ? 'dashboard.admin'
                : pickDashboardView('admin');

            return view($view, compact('stats', 'users', 'products'));
        })->name('dashboard');

        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('products', AdminProductController::class)->except(['show']);

        Route::post('/products/{product}/status', [AdminProductController::class, 'updateStatus'])
            ->name('products.updateStatus');

        Route::resource('stores', AdminStoreController::class)->except(['show']);

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
    });

/*
|--------------------------------------------------------------------------
| SELLER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('seller')
    ->as('seller.')
    ->group(function () {

        Route::get('/', [SellerDashboard::class, 'index'])->name('dashboard');

        Route::get('/store', [SellerStore::class, 'show'])->name('store.show');
        Route::get('/store/edit', [SellerStore::class, 'edit'])->name('store.edit');
        Route::put('/store', [SellerStore::class, 'update'])->name('store.update');

        Route::get('/products', [SellerProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
        Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [SellerProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        Route::get('/promos', fn () => view('seller.placeholders.promos'))->name('promos.index');
        Route::get('/settings', fn () => view('seller.placeholders.settings'))->name('settings');
    });

/*
|--------------------------------------------------------------------------
| BUYER
|--------------------------------------------------------------------------
*/
Route::prefix('buyer')
    ->name('buyer.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', [BuyerHomeController::class, 'index'])->name('dashboard');

        Route::view('/help', 'static.help')->name('help');

        Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
        Route::get('/store/{store:slug}', [StoreController::class, 'show'])->name('stores.show');

        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');
    });
