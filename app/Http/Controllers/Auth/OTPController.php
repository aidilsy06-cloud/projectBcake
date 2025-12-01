<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OTPController extends Controller
{
    // Tampilkan form OTP
    public function form(Request $request)
    {
        return view('auth.otp_form');
    }

    // Verifikasi OTP
    public function verify(Request $r)
    {
        $r->validate([
            'email'    => 'required|email',
            'otp_code' => 'required',
        ]);

        $user = User::where('email', $r->email)->first();

        if (! $user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        $otp = UserOtp::where('user_id', $user->id)
            ->where('otp_code', $r->otp_code)
            ->where('expired_at', '>=', Carbon::now())
            ->first();

        if (! $otp) {
            return back()->with('error', 'Kode OTP salah atau sudah kadaluarsa.');
        }

        // OTP valid → verifikasi user
        $user->is_verified = 1;
        $user->save();

        // hapus OTP biar tidak bisa dipakai ulang
        $otp->delete();

        return redirect()->route('login')->with(
            'status',
            'Akun kamu sudah terverifikasi 🎉 Silakan login.'
        );
    }

    // Kirim ulang OTP
    public function resend(Request $r)
    {
        $r->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $r->email)->first();

        if (! $user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        // Generate OTP baru
        $newOtp = rand(100000, 999999);

        UserOtp::where('user_id', $user->id)->delete();

        UserOtp::create([
            'user_id'    => $user->id,
            'otp_code'   => $newOtp,
            'expired_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::send('emails.verify_otp', [
            'otp'  => $newOtp,
            'name' => $user->name,
        ], function ($msg) use ($user) {
            $msg->to($user->email)
                ->subject("Kode OTP Baru — B’cake");
        });

        return back()->with('success', 'Kode OTP baru sudah dikirim ke email kamu 💌');
    }
}
