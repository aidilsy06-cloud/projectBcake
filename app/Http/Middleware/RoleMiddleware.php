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

        // Jika hanya "admin,seller" jadi satu argumen, pecah dulu
        if (count($roles) === 1 && is_string($roles[0]) && str_contains($roles[0], ',')) {
            $roles = explode(',', $roles[0]);
        }

        // Normalisasi
        $roles = array_values(array_filter(array_map(
            fn ($r) => strtolower(trim((string) $r)),
            $roles
        )));

        // Tidak ada role yang dipassing atau role user kosong
        if (empty($roles) || empty($user->role)) {
            return $this->deny($request);
        }

        if (! in_array(strtolower((string) $user->role), $roles, true)) {
            return $this->deny($request);
        }

        return $next($request);
    }

    private function deny(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        abort(403, 'Anda tidak memiliki akses untuk halaman ini.');
    }
}
