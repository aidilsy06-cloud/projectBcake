@extends('layouts.app')

@section('title', 'Dashboard Seller — B’cake')

@section('content')
<section class="bg-rose-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- HEADER --}}
        <div class="bg-white rounded-3xl shadow-xl px-6 py-6">
            <h1 class="text-2xl font-semibold text-rose-900">
                Halo, {{ $user->name ?? 'Seller' }} ✨
            </h1>
            <p class="text-rose-500 text-sm mt-1">
                Selamat datang di dashboard seller B’cake. Kelola toko & katalogmu dengan mudah.
            </p>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl px-5 py-4 shadow-md">
                <p class="text-xs text-rose-400 mb-1">Total Produk</p>
                <p class="text-3xl font-semibold text-rose-900">
                    {{ $my_products }}
                </p>
            </div>

            <div class="bg-white rounded-2xl px-5 py-4 shadow-md">
                <p class="text-xs text-rose-400 mb-1">Katalog</p>
                <p class="text-sm text-rose-900 font-semibold">Kelola Produk</p>
                <a href="{{ route('seller.products.index') }}"
                   class="text-xs inline-block mt-2 px-3 py-1 rounded-full
                   border border-rose-200 text-rose-700 hover:bg-rose-50">
                    Buka Katalog →
                </a>
            </div>

            <div class="bg-white rounded-2xl px-5 py-4 shadow-md">
                <p class="text-xs text-rose-400 mb-1">Profil Toko</p>
                <p class="text-sm text-rose-900 font-semibold">Edit Toko</p>
                <a href="{{ route('seller.store.edit') }}"
                   class="text-xs inline-block mt-2 px-3 py-1 rounded-full
                   border border-rose-200 text-rose-700 hover:bg-rose-50">
                    Edit Profil →
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
