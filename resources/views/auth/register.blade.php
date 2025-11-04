@extends('layouts.app')

@section('title', 'Masuk | B’cake')

@section('content')
  <div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md">
      {{-- Card --}}
      <div class="bg-white/70 backdrop-blur rounded-2xl shadow-xl border border-rose-100">
        {{-- Header --}}
        <div class="p-6 text-center">
          <div class="mx-auto w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center mb-3">
            {{-- Simple logo mark --}}
            <span class="text-rose-700 font-extrabold text-xl">B’</span>
          </div>
          <h1 class="text-xl font-semibold text-rose-800">Masuk ke B’cake</h1>
          <p class="text-sm text-rose-500 mt-1">Marketplace kue — pembeli, penjual, & admin</p>
        </div>

        {{-- Alerts --}}
        @if (session('status'))
          <div class="px-6">
            <div class="text-sm rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-3 py-2 mb-3">
              {{ session('status') }}
            </div>
          </div>
        @endif

        @if ($errors->any())
          <div class="px-6">
            <div class="text-sm rounded-lg bg-rose-50 border border-rose-200 text-rose-700 px-3 py-2 mb-3">
              <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="px-6 pb-6 space-y-4">
          @csrf

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required
                   value="{{ old('email') }}"
                   class="mt-1 w-full rounded-xl border-gray-300 focus:border-rose-400 focus:ring-rose-400">
          </div>

          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
              @if (Route::has('password.request'))
                <a class="text-sm text-rose-600 hover:text-rose-700" href="{{ route('password.request') }}">
                  Lupa sandi?
                </a>
              @endif
            </div>
            <input id="password" name="password" type="password" autocomplete="current-password" required
                   class="mt-1 w-full rounded-xl border-gray-300 focus:border-rose-400 focus:ring-rose-400">
          </div>

          <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
              <input type="checkbox" name="remember"
                     class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
              Ingat saya
            </label>

            {{-- opsional: hint role yang didukung --}}
            <span class="text-xs text-gray-400">Role: admin / penjual / pembeli</span>
          </div>

          <button type="submit"
                  class="w-full rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 shadow">
            Masuk
          </button>

          <p class="text-center text-sm text-gray-600">
            Belum punya akun?
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="text-rose-600 hover:text-rose-700 font-medium">Daftar</a>
            @endif
          </p>
        </form>
      </div>
    </div>
  </div>
@endsection

