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

  /* ——— Animasi welcome cake ——— */
  @keyframes bcake-float {
    0%,100% { transform: translateY(0) }
    50%     { transform: translateY(-8px) }
  }
  @keyframes bcake-fadein {
    from { opacity: 0; transform: translateY(8px) }
    to   { opacity: 1; transform: translateY(0) }
  }
  @keyframes bcake-flicker {
    0%,100% { opacity: .9; transform: translateY(0) scale(1) }
    50%     { opacity: 1;  transform: translateY(-1px) scale(1.02) }
  }
  @keyframes bcake-sparkle {
    0%   { opacity: 0; transform: translateY(4px) scale(.85) }
    50%  { opacity: 1; transform: translateY(-2px) scale(1) }
    100% { opacity: 0; transform: translateY(-6px) scale(.9) }
  }
  .bcake-anim-floating { animation: bcake-float 4.5s ease-in-out infinite; }
  .bcake-anim-fade     { animation: bcake-fadein .8s ease forwards; }
  .bcake-anim-flame    { animation: bcake-flicker 1.4s ease-in-out infinite; transform-origin: center; }
  .bcake-anim-sparkle  { animation: bcake-sparkle 1.8s ease-in-out infinite; }
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

<<<<<<< HEAD
      <p class="mt-4 text-bcake-truffle max-w-md">
        Cupcake cherry, brownies premium, dan kue artisanal — dibuat segar setiap hari
        dengan bahan pilihan terbaik.
      </p>
=======
            <p class="mt-4 text-bcake-truffle max-w-md">
                Cupcake cherry, brownies premium, dan kue artisanal — dibuat segar setiap hari
                dengan bahan pilihan terbaik.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <x-button href="{{ route('products.index') }}">Lihat Katalog</x-button>
                <x-button variant="outline" href="#welcome">Tentang Kami</x-button>
            </div>
        </div>

        <div class="relative">
            <div class="aspect-[4/3] rounded-xl2 shadow-soft overflow-hidden ring-1 ring-bcake-truffle/10">
                <img src="https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=1200"
                     alt="Cupcake cherry" class="w-full h-full object-cover">
            </div>

            {{-- sprinkle animasi --}}
            <div class="pointer-events-none absolute inset-0">
                <span class="absolute left-6 top-0 text-bcake-cherry/70 animate-sprinkle">•</span>
                <span class="absolute right-14 top-4 text-bcake-wine/70 animate-sprinkle [animation-delay:.5s]">•</span>
                <span class="absolute right-8 top-1 text-bcake-truffle/70 animate-sprinkle [animation-delay:1s]">•</span>
            </div>
        </div>
>>>>>>> 4d90c4ad623bd78f0dd68ac276f3e62933ee6b22

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


<<<<<<< HEAD
{{-- ========== PRODUK FAVORIT ========== --}}
=======
{{-- WELCOME CAKE (Animasi elegan) --}}
<section id="welcome" class="relative max-w-6xl mx-auto px-4 mt-10">
  <div class="relative overflow-hidden rounded-3xl border border-bcake-truffle/10 bg-white/70 backdrop-blur p-6 md:p-8 shadow">
    <div class="flex items-center gap-6 md:gap-10">
      {{-- Kue SVG animasi --}}
      <div class="shrink-0 bcake-anim-floating">
        <svg viewBox="0 0 140 140" class="w-24 h-24 md:w-32 md:h-32 drop-shadow" aria-hidden="true">
          <!-- Piring -->
          <ellipse cx="70" cy="112" rx="46" ry="8" fill="#c7c2bf"></ellipse>

          <!-- Layer bawah -->
          <rect x="28" y="76" width="84" height="28" rx="8" fill="#f4d9df" />
          <rect x="28" y="76" width="84" height="10" rx="6" fill="#e9bec8" />
          <path d="M28,86 h84 v10 c-6,6 -12,-4 -18,0 s-12,4 -18,0 s-12,4 -18,0 s-12,4 -18,0 s-6,6 -12,0 z" fill="#fff0f3"/>

          <!-- Layer tengah -->
          <rect x="36" y="58" width="68" height="22" rx="8" fill="#f2c0c9"/>
          <rect x="36" y="58" width="68" height="8"  rx="6" fill="#e9a9b6"/>
          <path d="M36,66 h68 v6 c-6,5 -12,-4 -17,0 s-11,4 -17,0 s-11,4 -17,0 s-11,4 -17,0 z" fill="#fff3f6"/>

          <!-- Layer atas -->
          <rect x="44" y="42" width="52" height="18" rx="7" fill="#ffe5ea"/>
          <rect x="44" y="42" width="52" height="7"  rx="5" fill="#ffd2dc"/>
          <path d="M44,49 h52 v6 c-5,4 -10,-3 -14,0 s-9,3 -14,0 s-9,3 -14,0 s-5,4 -10,0 z" fill="#ffffff"/>

          <!-- Lilin -->
          <rect x="68" y="30" width="4" height="12" rx="2" fill="#6a4e4a"/>
          <!-- Api -->
          <path class="bcake-anim-flame" d="M70 24 c4 4 -2 8 -2 8 s-6 -4 -2 -8 c1.3 -1.3 2.7 -1.3 4 0z" fill="#ffa728"/>
          <circle class="bcake-anim-flame" cx="70" cy="28" r="2" fill="#ffd166"/>

          <!-- Ceri kecil (sparkle) -->
          <g class="bcake-anim-sparkle" style="animation-delay:.2s">
            <circle cx="100" cy="52" r="3.2" fill="#b0123b"/>
            <path d="M100 48 q6 -6 10 -2" stroke="#7e0b28" stroke-width="1.2" fill="none"/>
          </g>
          <g class="bcake-anim-sparkle" style="animation-delay:.6s">
            <circle cx="46" cy="70" r="2.8" fill="#b0123b"/>
            <path d="M46 67 q-6 -6 -10 -2" stroke="#7e0b28" stroke-width="1.2" fill="none"/>
          </g>
        </svg>
      </div>

      {{-- Teks Welcome --}}
      <div class="min-w-0 bcake-anim-fade">
        <h2 class="text-2xl md:text-3xl font-semibold" style="font-family:'Playfair Display',serif;">
          Selamat datang di <span class="text-bcake-wine">B’cake</span>
        </h2>
        <p class="mt-2 text-bcake-truffle">
          Maniskan harimu dengan kue artisan—lembut, elegan, dan selalu segar.
        </p>

        <div class="mt-4 flex items-center gap-3">
          <x-button href="{{ route('products.index') }}">Lihat Katalog</x-button>
          <x-button variant="outline" href="{{ route('help') }}">Bantuan</x-button>
        </div>
      </div>
    </div>
  </div>
</section>



{{-- PRODUK FAVORIT --}}
>>>>>>> 4d90c4ad623bd78f0dd68ac276f3e62933ee6b22
<section class="max-w-6xl mx-auto px-4 py-16">
  <div class="flex items-end justify-between mb-6">
    <h2 class="font-display text-3xl">Favorit Minggu Ini</h2>
    <a href="{{ route('products.index') }}" class="text-sm hover:underline text-bcake-wine">Lihat semua</a>
  </div>

  @isset($products)
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse ($products as $p)
        <a href="{{ route('products.show', $p) }}" class="card group border rounded-xl overflow-hidden bg-white hover:shadow transition">
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
