<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Pakai:
     *   ->middleware('role:admin')
     *   ->middleware('role:admin,seller')
     *   ->middleware('role:admin,seller,buyer')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        // Jika Laravel mengirim satu argumen "admin,seller", pecah dulu
        if (count($roles) === 1 && is_string($roles[0]) && str_contains($roles[0], ',')) {
            $roles = explode(',', $roles[0]);
        }

        // Bersihkan & normalisasi
        $roles = array_values(array_filter(array_map(
            fn ($r) => strtolower(trim((string) $r)),
            $roles
        )));

        // Default aman: kalau tak ada role yang dipassing → tolak
        if (empty($roles)) {
            abort(403, 'Anda tidak memiliki akses untuk halaman ini.');
        }

        if (! in_array(strtolower((string) $user->role), $roles, true)) {
            abort(403, 'Anda tidak memiliki akses untuk halaman ini.');
        }

        return $next($request);
    }
}
