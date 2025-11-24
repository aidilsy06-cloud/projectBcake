@extends('layouts.app')

@section('title', $product->name . ' — B’cake')

@section('content')

{{-- ===================== TOMBOL KEMBALI (ATAS KIRI) ===================== --}}
<div class="max-w-6xl mx-auto px-4 mt-6 mb-4">
    <a href="{{ route('products.index') }}"
       class="inline-flex items-center gap-2 px-4 py-1.5 
              rounded-full bg-rose-100 text-bcake-wine text-sm 
              hover:bg-rose-200 transition shadow-sm">
        ← Kembali ke Katalog Produk
    </a>
</div>

<section class="max-w-6xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-10">
    
    {{-- GAMBAR PRODUK --}}
    <div class="rounded-xl2 overflow-hidden shadow-soft border border-bcake-truffle/10">
        <img src="{{ $product->image_url }}" 
             class="w-full h-[420px] object-cover" 
             alt="{{ $product->name }}">
    </div>

    {{-- DETAIL PRODUK --}}
    <div>
        <h1 class="font-display text-4xl">{{ $product->name }}</h1>

        <div class="text-bcake-wine font-semibold text-2xl mt-2">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        <p class="mt-4 text-bcake-truffle">{{ $product->description }}</p>

        {{-- FORM TAMBAH KE KERANJANG --}}
        <form method="POST" action="{{ route('cart.add', $product) }}" 
              class="mt-6 flex items-center gap-3">
            @csrf

            <input type="number" name="qty" value="1" min="1"
                class="w-20 rounded-xl2 border-bcake-truffle/30 px-3 py-2">

            <button class="px-5 py-3 rounded-xl2 bg-bcake-cherry text-white hover:bg-bcake-wine shadow-soft">
                Tambah ke Keranjang
            </button>
        </form>
    </div>
</section>

@endsection

