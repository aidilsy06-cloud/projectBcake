<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PasswordResetController extends Controller
{
    public function requestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        $otp = rand(100000, 999999);

        Session::put('reset_email', $request->email);
        Session::put('reset_otp', $otp);

        Mail::raw("Kode OTP reset password Anda adalah: $otp", function ($msg) use ($request) {
            $msg->to($request->email)
                ->subject('OTP Reset Password - Bcake');
        });

        return redirect()->route('password.verify')->with('success', 'OTP telah dikirim ke email Anda.');
    }

    public function verifyForm()
    {
        return view('auth.passwords.verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        if ($request->otp == Session::get('reset_otp')) {
            Session::put('reset_allowed', true);
            return redirect()->route('password.reset');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah!']);
    }

    public function resetForm()
    {
        if (!Session::get('reset_allowed')) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.reset');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = Session::get('reset_email');

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        Session::forget(['reset_email', 'reset_otp', 'reset_allowed']);

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
