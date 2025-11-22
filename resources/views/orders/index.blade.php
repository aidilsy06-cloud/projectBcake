@extends('layouts.app')

@section('title', 'Dashboard Admin — B’cake')

@push('head')
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
  }
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }
  .card-soft{
    background: linear-gradient(145deg,#ffffff,#fff6f7 55%,#ffecef 100%);
    box-shadow:0 18px 40px rgba(137,5,36,.12);
    border-radius:24px;
  }
  .btn-pill{
    border-radius:999px;
    padding:.55rem 1.3rem;
    font-size:.85rem;
    font-weight:600;
  }
</style>
@endpush

@section('content')
<div class="page-bg min-h-screen pb-16">
    <div class="max-w-6xl mx-auto pt-10 px-4 sm:px-6 lg:px-0">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-rose-900 tracking-tight">
                Dashboard Admin
            </h1>
            <p class="mt-1 text-sm text-rose-500">
                Pantau aktivitas dan data sistem B’cake dengan cepat 🍰
            </p>
        </div>

        {{-- STAT CARDS --}}
        <div class="grid gap-5 md:grid-cols-3 mb-10">
            {{-- Total Produk --}}
            <div class="card-soft px-8 py-6 flex flex-col justify-between">
                <div class="text-sm text-rose-400 font-semibold mb-2">Total Produk</div>
                <div class="text-4xl font-bold text-rose-900 mb-1">
                    {{ $stats['total_products'] ?? 0 }}
                </div>
                <p class="text-sm text-rose-400">
                    Jumlah seluruh produk aktif di sistem
                </p>
            </div>

            {{-- Total Pengguna --}}
            <div class="card-soft px-8 py-6 flex flex-col justify-between">
                <div class="text-sm text-rose-400 font-semibold mb-2">Total Pengguna</div>
                <div class="text-4xl font-bold text-rose-900 mb-1">
                    {{ $stats['users'] ?? 0 }}
                </div>
                <p class="text-sm text-rose-400">
                    Total akun terdaftar di B’cake
                </p>
            </div>

            {{-- Pesanan --}}
            <div class="card-soft px-8 py-6 flex flex-col justify-between">
                <div class="text-sm text-rose-400 font-semibold mb-2">Pesanan</div>
                <div class="text-4xl font-bold text-rose-900 mb-1">
                    {{ $stats['orders'] ?? 0 }}
                </div>
                <p class="text-sm text-rose-400 mb-3">
                    Total pesanan yang tercatat di B’cake
                </p>
                <a href="{{ route('admin.orders.index') }}"
                   class="inline-flex items-center text-sm font-semibold text-rose-600 hover:text-rose-700">
                    Lihat Semua Pesanan
                    <span class="ml-1">→</span>
                </a>
            </div>
        </div>

        {{-- AKSI CEPAT --}}
        <div class="card-soft px-8 py-6 mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-rose-900">Aksi Cepat</h2>
                    <p class="text-xs text-rose-400 mt-1">
                        Kelola data utama B’cake hanya dengan sekali klik.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.products.index') }}"
                       class="btn-pill bg-rose-700 text-white hover:bg-rose-800">
                        Kelola Produk
                    </a>
                    <a href="{{ route('admin.stores.index') }}"
                       class="btn-pill border border-rose-200 text-rose-700 bg-white hover:bg-rose-50">
                        Kelola Toko
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       class="btn-pill border border-rose-200 text-rose-700 bg-white hover:bg-rose-50">
                        Kelola User
                    </a>
                    <a href="{{ route('home') }}"
                       class="btn-pill border border-rose-100 text-rose-500 bg-white hover:bg-rose-50">
                        Lihat Landing
                    </a>
                </div>
            </div>
        </div>

        {{-- LIST TERBARU --}}
        <div class="grid gap-6 md:grid-cols-2">
            {{-- Pengguna Terbaru --}}
            <div class="card-soft px-6 py-5">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-semibold text-rose-900">Pengguna Terbaru</h2>
                    <a href="{{ route('admin.users.index') }}"
                       class="text-xs font-semibold text-rose-500 hover:text-rose-600">
                        Lihat Semua
                    </a>
                </div>

                @if($users->count())
                    <div class="divide-y divide-rose-50">
                        @foreach ($users as $user)
                            <div class="py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-rose-900">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-xs text-rose-400">
                                        {{ $user->email }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[11px] font-semibold
                                             {{ $user->role === 'seller'
                                                ? 'bg-amber-100 text-amber-800'
                                                : ($user->role === 'admin'
                                                    ? 'bg-rose-100 text-rose-800'
                                                    : 'bg-emerald-100 text-emerald-800') }}">
                                    {{ ucfirst($user->role ?? 'buyer') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-rose-300">Belum ada data pengguna.</p>
                @endif
            </div>

            {{-- Produk Terbaru --}}
            <div class="card-soft px-6 py-5">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-semibold text-rose-900">Produk Terbaru</h2>
                    <a href="{{ route('admin.products.index') }}"
                       class="text-xs font-semibold text-rose-500 hover:text-rose-600">
                        Lihat Semua
                    </a>
                </div>

                @if($products->count())
                    <div class="divide-y divide-rose-50">
                        @foreach ($products as $product)
                            <div class="py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-rose-900">
                                        {{ $product->name }}
                                    </p>
                                    <p class="text-xs text-rose-400">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <span class="text-[11px] text-rose-300">
                                    {{ $product->created_at?->format('d M Y') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-rose-300">Belum ada data produk.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
