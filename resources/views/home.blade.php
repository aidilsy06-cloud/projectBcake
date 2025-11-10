@extends('layouts.app')

@section('title','B’cake — Elegant Bakery')

@section('content')

{{-- ============ HERO ============ --}}
<section class="relative overflow-hidden bg-rose-50">
  <div class="max-w-7xl mx-auto px-6 py-16 md:py-20">
    <div class="relative min-h-[260px] md:min-h-[320px]">
      {{-- side photos (pakai public/cake.jpg) --}}
      <img src="{{ asset('cake.jpg') }}" alt="" class="hidden md:block absolute -left-12 top-1/2 -translate-y-1/2 w-72 h-72 object-cover rounded-3xl shadow-soft ring-1 ring-rose-200/60 z-0">
      <img src="{{ asset('cake.jpg') }}" alt="" class="hidden md:block absolute -right-12 top-1/2 -translate-y-1/2 w-80 h-80 object-cover rounded-3xl shadow-soft ring-1 ring-rose-200/60 z-0">

      {{-- center content --}}
      <div class="relative z-10 max-w-xl mx-auto text-center">
        <p class="inline-flex items-center gap-2 text-xs tracking-wider uppercase text-rose-700/80">
          <span class="h-1.5 w-1.5 rounded-full bg-rose-700"></span> Handcrafted • Since 2025
        </p>

        <h1 class="font-display text-4xl md:text-5xl leading-tight mt-4">
          Delight in <br><span class="text-rose-800">every bite!</span>
        </h1>

        <p class="mt-4 text-gray-700/90">
          Kue artisanal lembut, macarons cantik, dan koleksi cupcake — dibuat segar setiap hari.
        </p>

        <div class="mt-7 flex items-center justify-center gap-3">
          <a href="{{ route('products.index') }}" class="rounded-full bg-rose-600 text-white px-6 py-3 hover:bg-rose-700">Order Now</a>
          <a href="#signature" class="rounded-full border border-rose-200/70 px-6 py-3 hover:border-rose-300">Lihat Signature</a>
        </div>
      </div>
    </div>
  </div>
  <div class="bcake-divider max-w-7xl mx-auto"></div>
</section>

{{-- ============ TEST GAMBAR (hapus kalau sudah ok) ============ --}}
<div class="max-w-7xl mx-auto px-6 py-6 border border-red-300 bg-white rounded-xl">
  <p class="font-semibold text-red-600 mb-3">🔍 Test gambar — semua pakai asset('cake.jpg')</p>
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 text-xs">
    @for ($i=1;$i<=6;$i++)
    <div class="text-center">
      <img src="{{ asset('cake.jpg') }}" class="w-full h-32 object-cover rounded-lg border">
      cake.jpg (#{{ $i }})
    </div>
    @endfor
  </div>
</div>

{{-- ============ SIGNATURE ============ --}}
<section id="signature" class="max-w-7xl mx-auto px-6 py-14">
  <h2 class="font-display text-3xl text-center">Signature</h2>
  <p class="text-center text-gray-600 mt-2">Favorit pelanggan kami — manis, elegan, dan berkesan.</p>

  <div class="relative mt-8">
    <button class="hidden md:flex absolute -left-4 top-1/2 -translate-y-1/2 h-9 w-9 items-center justify-center rounded-full ring-1 ring-rose-200 bg-white shadow hover:bg-rose-50">‹</button>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ([['Custom Cakes'],['Macarons'],['Cupcake Collections']] as $card)
        <a href="{{ route('products.index') }}" class="group rounded-3xl bg-white border border-rose-200 shadow-soft overflow-hidden">
          <img src="{{ asset('cake.jpg') }}" alt="{{ $card[0] }}" class="h-56 w-full object-cover group-hover:scale-[1.02] transition">
          <div class="p-5">
            <div class="font-display text-xl">{{ $card[0] }}</div>
            <p class="text-sm text-gray-600 mt-1">Lezat & elegan untuk momen spesial.</p>
          </div>
        </a>
      @endforeach
    </div>

    <button class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 h-9 w-9 items-center justify-center rounded-full ring-1 ring-rose-200 bg-white shadow hover:bg-rose-50">›</button>
  </div>
</section>

{{-- ============ BANNER PROMO ============ --}}
<section class="max-w-7xl mx-auto px-6 pb-16">
  <div class="rounded-3xl overflow-hidden border border-rose-200 shadow-soft grid md:grid-cols-2 bg-rose-50">
    <img src="{{ asset('cake.jpg') }}" alt="Holiday cake" class="w-full h-[260px] md:h-full object-cover">
    <div class="p-8 md:p-10 bg-white/80 backdrop-blur">
      <h3 class="font-display text-3xl">Holiday Collection</h3>
      <p class="text-gray-700 mt-2 max-w-md">Kue edisi spesial dengan dekor elegan. Stok terbatas!</p>
      <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-rose-200 bg-white px-5 py-3">
        <span class="text-rose-900 font-semibold text-xl">20% OFF</span>
        <span class="text-gray-600 text-sm">untuk pembelian paket</span>
      </div>
      <div class="mt-6">
        <a href="{{ route('products.index') }}" class="rounded-full bg-rose-700 text-white px-6 py-3 hover:opacity-90">Order Today</a>
      </div>
    </div>
  </div>
</section>

@endsection
