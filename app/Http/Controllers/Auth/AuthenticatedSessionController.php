<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     * Jika sudah login, arahkan ke dashboard sesuai role.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            $role = Auth::user()->role ?? 'buyer';

            $target = match ($role) {
                'admin'  => route('admin.dashboard'),
                'seller' => route('seller.dashboard'),
                default  => route('buyer.dashboard'),
            };

            return redirect()->to($target);
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $role = Auth::user()->role ?? 'buyer';

        $target = match ($role) {
            'admin'  => route('admin.dashboard'),
            'seller' => route('seller.dashboard'),
            default  => route('buyer.dashboard'),
        };

        // intended: kalau ada niat URL sebelumnya, pakai itu; kalau tidak, pakai $target
        return redirect()->intended($target);
    }

    /**
     * Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
