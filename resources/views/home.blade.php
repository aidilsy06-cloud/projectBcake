@extends('layouts.app')

@section('title', 'B’cake — Elegant Bakery')

@push('head')
<style>
  /* ——— Animasi sprinkle kecil (dipakai di hero) ——— */
  @keyframes sprinkleFloat {
    0%,100% { transform: translateY(0) }
    50%     { transform: translateY(-6px) }
  }
  .animate-sprinkle { animation: sprinkleFloat 3.6s ease-in-out infinite; }

  /* ——— Animasi welcome cake (opsional) ——— */
  @keyframes bcake-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
  @keyframes bcake-fadein { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
  @keyframes bcake-flicker { 0%,100%{opacity:.9;transform:translateY(0) scale(1)} 50%{opacity:1;transform:translateY(-1px) scale(1.02)} }
  @keyframes bcake-sparkle { 0%{opacity:0;transform:translateY(4px) scale(.85)} 50%{opacity:1;transform:translateY(-2px) scale(1)} 100%{opacity:0;transform:translateY(-6px) scale(.9)} }
  .bcake-anim-floating{animation:bcake-float 4.5s ease-in-out infinite}
  .bcake-anim-fade{animation:bcake-fadein .8s ease forwards}
  .bcake-anim-flame{animation:bcake-flicker 1.4s ease-in-out infinite;transform-origin:center}
  .bcake-anim-sparkle{animation:bcake-sparkle 1.8s ease-in-out infinite}
</style>
@endpush

@section('content')

{{-- ========== HERO SECTION ========== --}}
<section class="relative">
  <div class="max-w-6xl mx-auto px-4 pt-16 pb-24 grid md:grid-cols-2 gap-10 items-center">

    <div>
      <div class="inline-flex items-center gap-2 text-xs tracking-wider uppercase text-bcake-wine/80">
        <span class="h-1.5 w-1.5 rounded-full bg-bcake-cherry"></span> Handcrafted · Since 2025
      </div>

      <h1 class="font-display text-4xl md:text-5xl leading-tight mt-3">
        Elegan di <span class="text-bcake-wine">Setiap Gigitan</span> 🍒
      </h1>

      <p class="mt-4 text-bcake-truffle max-w-md">
        Cupcake cherry, brownies premium, dan kue artisanal — dibuat segar setiap hari
        dengan bahan pilihan terbaik.
      </p>

      <div class="mt-8 flex flex-wrap gap-3">
        <x-button href="{{ route('products.index') }}">Lihat Katalog</x-button>
        <x-button variant="outline" href="#about">Tentang Kami</x-button>
      </div>
    </div>

    <div class="relative">
      <div class="aspect-[4/3] rounded-2xl shadow overflow-hidden ring-1 ring-bcake-truffle/10">
        <img
          src="https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=1200"
          alt="Cupcake cherry"
          class="w-full h-full object-cover">
      </div>

      {{-- sprinkle animasi kecil --}}
      <div class="pointer-events-none absolute inset-0">
        <span class="absolute left-6 top-0 text-bcake-cherry/70 animate-sprinkle">•</span>
        <span class="absolute right-14 top-4 text-bcake-wine/70 animate-sprinkle [animation-delay:.5s]">•</span>
        <span class="absolute right-8 top-1 text-bcake-truffle/70 animate-sprinkle [animation-delay:1s]">•</span>
      </div>
    </div>

  </div>

  <div class="h-1.5 bg-bcake-gradient"></div>
</section>

{{-- ========== PRODUK FAVORIT ========== --}}
<section class="max-w-6xl mx-auto px-4 py-16">
  <div class="flex items-end justify-between mb-6">
    <h2 class="font-display text-3xl">Favorit Minggu Ini</h2>
    <a href="{{ route('products.index') }}" class="text-sm hover:underline text-bcake-wine">Lihat semua</a>
  </div>

  @isset($products)
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse ($products as $p)
        <a href="{{ route('products.show', $p->slug) }}"
           class="card group border rounded-xl overflow-hidden bg-white hover:shadow transition">
          <img
            src="{{ $p->image_url ?? 'https://picsum.photos/640/360' }}"
            alt="{{ $p->name }}"
            class="h-44 w-full object-cover group-hover:scale-[1.02] transition">
          <div class="p-4">
            <div class="font-medium">{{ $p->name }}</div>
            <div class="mt-3 font-semibold text-bcake-wine">
              @if(!is_null($p->price))
                Rp {{ number_format($p->price, 0, ',', '.') }}
              @else
                Hubungi kami
              @endif
            </div>
          </div>
        </a>
      @empty
        <p class="text-gray-500">Belum ada produk.</p>
      @endforelse
    </div>
  @endisset

  <div class="text-center mt-10">
    <x-button href="{{ route('products.index') }}">Lihat Semua Produk</x-button>
  </div>
</section>

@endsection
