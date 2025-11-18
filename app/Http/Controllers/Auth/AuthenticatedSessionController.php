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
        // Kalau user sudah login, jangan ke halaman login lagi
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->role ?? 'buyer';

            $target = match ($role) {
                'admin'  => route('admin.dashboard'),
                'seller' => route('seller.dashboard'),
                default  => route('buyer.dashboard'),
            };

            return redirect()->to($target);
        }

        // Belum login → tampilkan form login
        return view('auth.login');
    }

    /**
     * Proses autentikasi (login).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Cek email + password
        $request->authenticate();

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user->role ?? 'buyer';

        $target = match ($role) {
            'admin'  => route('admin.dashboard'),
            'seller' => route('seller.dashboard'),
            default  => route('buyer.dashboard'),
        };

        // Set DUA flash sekalian, supaya semua layout bisa pakai
        session()->flash('login_success', "Kamu berhasil login! Selamat datang kembali di B'cake 💗");
        session()->flash('success', "Kamu berhasil login! Selamat datang kembali di B'cake 💗");

        // redirect ke dashboard sesuai role
        return redirect()->intended($target);
    }

    /**
     * Logout user dari sesi saat ini.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // flash untuk logout
        session()->flash('success', "Kamu berhasil logout dari B'cake 💗");

        return redirect('/');
    }
}
