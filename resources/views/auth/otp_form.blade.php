@extends('layouts.app')

@section('title', "Verifikasi OTP — B'cake")

@section('content')
<div class="min-h-screen flex items-center justify-center bg-rose-50">
    <div class="bg-white shadow-xl rounded-3xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-semibold text-rose-900 mb-2">
            Verifikasi Akun 🎀
        </h1>
        <p class="text-sm text-rose-500 mb-4">
            Masukkan kode OTP yang kami kirim ke email
            <b>{{ request('email') }}</b>.
        </p>

        @if(session('error'))
            <div class="mb-3 text-sm text-red-600">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-3 text-sm text-emerald-600">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="email" value="{{ request('email') }}">

            <div>
                <label class="block text-sm font-medium text-rose-800 mb-1">
                    Kode OTP
                </label>
                <input type="text" name="otp_code" maxlength="6"
                       class="w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-400"
                       required>
            </div>

            <button type="submit"
                    class="w-full py-2.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-semibold">
                Verifikasi Sekarang
            </button>
        </form>

        <form action="{{ route('otp.resend') }}" method="POST" class="mt-4 text-center text-sm">
            @csrf
            <input type="hidden" name="email" value="{{ request('email') }}">
            <button type="submit" class="text-rose-600 hover:underline">
                Kirim ulang kode OTP
            </button>
        </form>
    </div>
</div>
@endsection
