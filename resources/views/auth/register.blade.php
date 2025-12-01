@extends('layouts.app')

@section('title', "Daftar — B'cake")

@section('content')
<div class="min-h-screen bg-gradient-to-b from-rose-50 via-rose-50 to-white flex items-center justify-center py-10">
    <div class="w-full max-w-5xl bg-white rounded-[2.5rem] shadow-[0_20px_60px_rgba(244,63,94,0.18)] overflow-hidden flex flex-col md:flex-row">

        {{-- PANEL KIRI --}}
        <div class="md:w-5/12 bg-gradient-to-br from-rose-600 via-rose-500 to-rose-400 text-white p-8 md:p-10 flex flex-col justify-between">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm mb-6 opacity-90 hover:opacity-100">
                    ← Kembali
                </a>

                <h2 class="text-2xl md:text-3xl font-semibold mb-3">
                    Hello, Welcome! ✨
                </h2>
                <p class="text-sm md:text-base text-rose-100/90 mb-6">
                    Yuk daftar dulu, pilih mau jadi <b>Pembeli</b> atau <b>Penjual</b>.
                    Buka etalase kue cantikmu atau pesan kue favoritmu di B’cake 🍰
                </p>
            </div>

            <div class="mt-6">
                <p class="text-xs text-rose-100/80 mb-2">
                    Sudah punya akun?
                </p>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 rounded-full border border-white/70 bg-white/10 text-sm font-medium backdrop-blur hover:bg-white hover:text-rose-600 transition">
                    Login
                </a>
            </div>
        </div>

        {{-- PANEL KANAN: FORM --}}
        <div class="md:w-7/12 p-8 md:p-10">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-9 h-9 rounded-2xl bg-rose-100 flex items-center justify-center">
                    <span class="text-lg">🧁</span>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.18em] text-rose-400">B’cake</p>
                    <h1 class="text-xl font-semibold text-rose-900">Buat Akun</h1>
                </div>
            </div>

            {{-- ALERT GLOBAL --}}
            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                {{-- NAMA --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-rose-900 mb-1">
                        Nama
                    </label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name') }}"
                           class="w-full rounded-2xl border @error('name') border-red-400 @else border-rose-100 @enderror px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400/70 focus:border-rose-400 bg-rose-50/40"
                           required autofocus>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-rose-900 mb-1">
                        Email
                    </label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           class="w-full rounded-2xl border @error('email') border-red-400 @else border-rose-100 @enderror px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400/70 focus:border-rose-400 bg-rose-50/40"
                           required>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- PASSWORD --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-rose-900 mb-1">
                            Password
                        </label>
                        <input id="password" name="password" type="password"
                               class="w-full rounded-2xl border @error('password') border-red-400 @else border-rose-100 @enderror px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400/70 focus:border-rose-400 bg-rose-50/40"
                               required>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ULANGI PASSWORD --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-rose-900 mb-1">
                            Ulangi Password
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="w-full rounded-2xl border border-rose-100 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400/70 focus:border-rose-400 bg-rose-50/40"
                               required>
                    </div>
                </div>

                {{-- ROLE --}}
                <div>
                    <p class="block text-sm font-medium text-rose-900 mb-2">
                        Daftar sebagai
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="flex items-start gap-3 rounded-2xl border px-3.5 py-2.5 cursor-pointer
                                      @if(old('role','buyer') === 'buyer') border-rose-400 bg-rose-50 @else border-rose-100 bg-rose-50/40 @endif">
                            <input type="radio" name="role" value="buyer"
                                   class="mt-1 accent-rose-500"
                                   {{ old('role','buyer') === 'buyer' ? 'checked' : '' }}>
                            <span class="text-sm">
                                <span class="font-semibold text-rose-900">Pembeli</span>
                                <span class="block text-xs text-rose-500">
                                    Belanja dan pesan kue di B’cake
                                </span>
                            </span>
                        </label>

                        <label class="flex items-start gap-3 rounded-2xl border px-3.5 py-2.5 cursor-pointer
                                      @if(old('role') === 'seller') border-rose-400 bg-rose-50 @else border-rose-100 bg-rose-50/40 @endif">
                            <input type="radio" name="role" value="seller"
                                   class="mt-1 accent-rose-500"
                                   {{ old('role') === 'seller' ? 'checked' : '' }}>
                            <span class="text-sm">
                                <span class="font-semibold text-rose-900">Penjual (Seller)</span>
                                <span class="block text-xs text-rose-500">
                                    Buka etalase toko dan jualan kue
                                </span>
                            </span>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TERMS --}}
                <div class="flex items-start gap-2">
                    <input id="terms" type="checkbox" class="mt-1 rounded border-rose-200 text-rose-500 focus:ring-rose-400"
                           required>
                    <label for="terms" class="text-xs text-rose-600">
                        Saya setuju dengan <a href="#" class="underline">Syarat & Ketentuan</a>.
                    </label>
                </div>

                {{-- SUBMIT --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full inline-flex justify-center items-center rounded-2xl bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold px-4 py-2.75 shadow-[0_12px_30px_rgba(244,63,94,0.45)] transition">
                        Daftar
                    </button>
                </div>

                <p class="text-xs text-center text-rose-500 mt-2">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-rose-600 hover:underline">
                        Masuk
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
