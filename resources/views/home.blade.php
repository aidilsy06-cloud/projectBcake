@extends('layouts.app')

@section('title', 'B’cake — Elegant Bakery')

@section('content')
<section class="relative grain">
    <div class="max-w-6xl mx-auto px-4 pt-16 pb-24 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="font-display text-4xl md:text-5xl leading-tight">
                Elegan di Setiap Gigitan 🍒
            </h1>
            <p class="mt-4 text-bcake-truffle">
                Cupcake cherry, brownies premium, dan kue artisanal — dibuat segar dengan bahan terbaik.
            </p>
            <div class="mt-8 flex gap-4">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-xl2 shadow-soft bg-bcake-cherry text-white font-medium tracking-wide hover:bg-bcake-wine transition">
                    Lihat Katalog
                </a>
                <a href="#" class="inline-flex items-center px-5 py-3 rounded-xl2 border border-bcake-truffle/30 hover:border-bcake-cherry text-bcake-bitter">
                    Tentang Kami
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="aspect-[4/3] rounded-xl2 shadow-soft overflow-hidden ring-1 ring-bcake-truffle/10">
                <img src="https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=1200" alt="Cupcake cherry" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    {{-- strip warna --}}
    <div class="h-2 bg-gradient-to-r from-bcake-bitter via-bcake-wine to-bcake-cherry"></div>
</section>

{{-- Produk Favorit --}}
<section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="font-display text-3xl mb-6">Favorit Minggu Ini</h2>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $p)
        <a href="{{ route('products.show', $p->slug) }}"
            class="group rounded-xl2 bg-white shadow-soft border border-bcake-truffle/10 overflow-hidden">
            <img src="{{ $p->image_url }}" class="h-44 w-full object-cover group-hover:scale-[1.02] transition" alt="{{ $p->name }}">
            <div class="p-4">
                <div class="font-medium">{{ $p->name }}</div>
                <div class="mt-3 font-semibold text-bcake-wine">Rp {{ number_format($p->price,0,',','.') }}</div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-xl2 shadow-soft bg-bcake-cherry text-white font-medium hover:bg-bcake-wine transition">
            Lihat Semua Produk
        </a>
    </div>
</section>
@endsection
