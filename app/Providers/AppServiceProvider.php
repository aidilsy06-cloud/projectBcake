<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(Router $router): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1) Alias Middleware
        |--------------------------------------------------------------------------
        */
        $router->aliasMiddleware('role', RoleMiddleware::class);

        /*
        |--------------------------------------------------------------------------
        | 2) View Composer global
        |    - $cartCount       → ikon keranjang
        |    - $navbarCategories → dropdown kategori di navbar / mobile
        |--------------------------------------------------------------------------
        */
        View::composer('*', function ($view) {

            // ============================
            // CART COUNT
            // ============================
            // PRIORITAS 1 — jika controller set session('cart_count') manual
            $cartCount = (int) session('cart_count', 0);

            // PRIORITAS 2 — jika belum ada, hitung otomatis dari session('cart')
            if ($cartCount === 0) {
                $cart = session('cart', []);

                if (is_array($cart)) {
                    // Bentuk A: ['slug'=>['qty'=>2], ...]
                    foreach ($cart as $item) {
                        if (is_array($item) && array_key_exists('qty', $item)) {
                            $cartCount += (int) $item['qty'];
                        } elseif (is_array($item)) {
                            // Bentuk B: ['slug'=>[]] tanpa qty → hitung itemnya
                            $cartCount += 1;
                        }
                    }

                    // Bentuk C: ['items'=>[...]]
                    if (isset($cart['items']) && is_array($cart['items'])) {
                        $cartCount = max($cartCount, count($cart['items']));
                    }
                } elseif ($cart instanceof \Countable) {
                    // Jika session cart berupa Collection
                    $cartCount = max($cartCount, count($cart));
                }
            }

            // ============================
            // NAVBAR CATEGORIES
            // ============================
            try {
                $navbarCategories = Category::orderBy('name')->get();
            } catch (\Throwable $e) {
                // kalau belum migrate / DB error, jangan bikin error view
                $navbarCategories = collect();
            }

            // Kirim ke semua view
            $view->with([
                'cartCount'        => $cartCount,
                'navbarCategories' => $navbarCategories,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | (Opsional tambahan)
        |--------------------------------------------------------------------------
        */
        // Schema::defaultStringLength(191); // untuk MySQL lama
        // if (app()->environment('production')) URL::forceScheme('https');
    }
}
