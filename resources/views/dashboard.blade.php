@extends('layouts.dashboard')

@section('title', 'Dashboard — B’cake')

@section('content')
  {{-- ========== HEADER DASHBOARD ========== --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
      <h1 class="text-3xl font-semibold text-rose-800">Dashboard</h1>
      <p class="text-sm text-gray-500 mt-1">Hai, {{ Auth::user()->name ?? 'User' }} 👋 Selamat datang kembali di B’cake</p>
    </div>
    <div class="mt-4 sm:mt-0">
      <a href="{{ route('home') }}" class="rounded-full bg-rose-600 text-white px-4 py-2 text-sm hover:bg-rose-700">
        ⬅ Kembali ke Beranda
      </a>
    </div>
  </div>

  {{-- ========== CARD INFORMASI CEPAT ========== --}}
  <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    {{-- Status login --}}
    <div class="rounded-2xl border border-rose-200/70 bg-white p-6 shadow-soft hover:shadow-md transition">
      <h2 class="font-semibold text-lg text-rose-700 mb-2">Status Login</h2>
      <p class="text-gray-700">✅ Kamu berhasil login ke sistem.</p>
      <div class="mt-3 text-xs text-gray-400">Terakhir login: {{ now()->format('d M Y, H:i') }}</div>
    </div>

    {{-- Pesanan --}}
    <div class="rounded-2xl border border-rose-200/70 bg-white p-6 shadow-soft hover:shadow-md transition">
      <h2 class="font-semibold text-lg text-rose-700 mb-2">Pesanan</h2>
      <p class="text-gray-700">Lihat dan kelola semua pesanan pelangganmu di sini.</p>
      <a href="{{ route('cart.index') }}" class="mt-3 inline-block rounded-full bg-rose-600 text-white px-4 py-2 text-sm hover:bg-rose-700">Lihat Pesanan</a>
    </div>

    {{-- Produk --}}
    <div class="rounded-2xl border border-rose-200/70 bg-white p-6 shadow-soft hover:shadow-md transition">
      <h2 class="font-semibold text-lg text-rose-700 mb-2">Produk</h2>
      <p class="text-gray-700">Tambahkan, ubah, atau hapus produk toko kue kamu.</p>
      <a href="{{ route('products.index') }}" class="mt-3 inline-block rounded-full border border-rose-600 text-rose-700 px-4 py-2 text-sm hover:bg-rose-50">Kelola Produk</a>
    </div>
  </div>

  {{-- ========== STATISTIK / INFORMASI TAMBAHAN ========== --}}
  <div class="mt-12 grid gap-6 lg:grid-cols-2">
    <div class="rounded-3xl overflow-hidden border border-rose-200 shadow-soft bg-white p-8">
      <h3 class="font-display text-2xl text-rose-800 mb-3">Statistik Mingguan 📈</h3>
      <ul class="text-gray-700 text-sm space-y-2">
        <li>🍰 <b>25</b> produk terjual minggu ini</li>
        <li>🛍️ <b>7</b> pesanan baru</li>
        <li>💬 <b>3</b> ulasan pelanggan baru</li>
      </ul>
      <p class="text-xs text-gray-400 mt-4">Data ini hanya contoh dummy untuk tampilan dashboard.</p>
    </div>

    {{-- Banner info --}}
    <div class="rounded-3xl overflow-hidden border border-rose-200 shadow-soft grid md:grid-cols-2 bg-rose-50">
      <img src="{{ asset('cake.jpg') }}" alt="Cake" class="w-full h-[240px] md:h-full object-cover">
      <div class="p-8 md:p-10 bg-white/80 backdrop-blur">
        <h3 class="font-display text-2xl text-rose-800">Kabar Baik 🍰</h3>
        <p class="text-gray-700 mt-2 max-w-md">
          Dashboard ini membantumu memantau aktivitas toko, pesanan, dan pelanggan dengan cepat dan elegan.
        </p>
        <div class="mt-6">
          <a href="{{ route('products.index') }}" class="rounded-full bg-rose-700 text-white px-5 py-2 text-sm hover:opacity-90">Jelajahi Produk</a>
        </div>
      </div>
    </div>
  </div>
@endsection
