<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1) Alias Middleware (tetap dari kode lama)
        |--------------------------------------------------------------------------
        | Supaya bisa memakai ->middleware('role:admin') di routes
        */
        $router->aliasMiddleware('role', RoleMiddleware::class);


        /*
        |--------------------------------------------------------------------------
        | 2) View Composer (untuk membuat $cartCount tersedia di semua view)
        |--------------------------------------------------------------------------
        */
        View::composer('*', function ($view) {
            // Ambil data keranjang dari session
            $cart = session('cart', []);

            // Hitung jumlah item atau qty
            $cartCount = 0;
            if (is_array($cart) && !empty($cart)) {
                foreach ($cart as $item) {
                    if (is_array($item) && isset($item['qty'])) {
                        $cartCount += (int) $item['qty'];
                    } else {
                        $cartCount += 1;
                    }
                }
            }

            // Kirim ke semua view
            $view->with('cartCount', $cartCount);
        });

        /*
        |--------------------------------------------------------------------------
        | (Opsional tambahan, tetap aman kalau mau dipakai nanti)
        |--------------------------------------------------------------------------
        */

        // Schema::defaultStringLength(191); // untuk MySQL lama
        // if (app()->environment('production')) {
        //     URL::forceScheme('https');    // paksa pakai https di hosting
        // }
    }
}
