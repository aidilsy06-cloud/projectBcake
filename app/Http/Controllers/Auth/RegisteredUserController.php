<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form register (Breeze).
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses register + kirim OTP.
     *
     * - Jika email belum ada  → buat user baru, is_verified = 0
     * - Jika email sudah ada tapi belum verifikasi → update data & kirim OTP baru
     * - Jika email sudah ada & sudah verifikasi → tolak, suruh login
     */
    public function store(Request $r): RedirectResponse
    {
        // VALIDASI AWAL (TANPA KONFIRMASI PASSWORD)
        $r->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
            'role'     => ['required', Rule::in(['buyer', 'seller'])],
        ]);

        // ⚠️ Di tahap ini kita TIDAK lagi membandingkan password_confirmation.
        // Field "Ulangi Password" hanya untuk kenyamanan di UI.

        // CEK APAKAH EMAIL SUDAH TERDAFTAR
        $existing = User::where('email', $r->email)->first();

        // 1) EMAIL SUDAH TERDAFTAR & SUDAH TERVERIFIKASI → SURUH LOGIN
        if ($existing && $existing->is_verified) {
            return back()
                ->withErrors([
                    'email' => 'Email ini sudah terdaftar dan sudah terverifikasi. Silakan login saja ya 💗',
                ])
                ->onlyInput('email');
        }

        // 2) EMAIL SUDAH ADA TAPI BELUM VERIFIKASI → PAKAI USER LAMA
        if ($existing && ! $existing->is_verified) {
            $user = $existing;
            $user->update([
                'name'     => $r->name,
                'password' => Hash::make($r->password),
                'role'     => $r->role,
            ]);
        } else {
            // 3) EMAIL BELUM PERNAH TERDAFTAR → BUAT USER BARU
            $user = User::create([
                'name'        => $r->name,
                'email'       => $r->email,
                'password'    => Hash::make($r->password),
                'role'        => $r->role,
                'is_verified' => 0,
            ]);
        }

        // event Breeze (opsional)
        event(new Registered($user));

        // ==========================
        // HANDLE OTP
        // ==========================

        // Hapus OTP lama (kalau ada)
        UserOtp::where('user_id', $user->id)->delete();

        // Generate OTP 6 digit
        $otp = rand(100000, 999999);

        // Simpan OTP baru
        UserOtp::create([
            'user_id'    => $user->id,
            'otp_code'   => $otp,
            'expired_at' => now()->addMinutes(5),
        ]);

        // Kirim email OTP
        Mail::send('emails.verify_otp', [
            'otp'  => $otp,
            'name' => $user->name,
        ], function ($msg) use ($user) {
            $msg->to($user->email)
                ->subject("Kode OTP Verifikasi Akun B’cake");
        });

        // Redirect ke halaman input OTP
        return redirect()
            ->route('otp.form', ['email' => $user->email])
            ->with('success', 'Kode OTP telah dikirim ke email kamu 💌');
    }
}
