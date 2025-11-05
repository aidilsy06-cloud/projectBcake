<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\RoleMiddleware;
// (opsional) fitur umum yang sering dipakai:
// use Illuminate\Support\Facades\Schema;   // Schema::defaultStringLength(191);
// use Illuminate\Support\Facades\URL;      // URL::forceScheme('https');

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
        // Daftarkan alias middleware 'role' supaya bisa dipakai di routes:
        // ->middleware('role:admin'), 'role:seller', 'role:buyer', dll.
        $router->aliasMiddleware('role', RoleMiddleware::class);

        // (opsional) kalau perlu kompatibilitas MySQL lama untuk indeks panjang
        // Schema::defaultStringLength(191);

        // (opsional) paksa https di production
        // if (app()->environment('production')) {
        //     URL::forceScheme('https');
        // }
    }
}
