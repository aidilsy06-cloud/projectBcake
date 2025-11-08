@extends('layouts.app')

@section('title','B’cake — Elegant Bakery')

@push('head')
<style>
  .bcake-divider{height:4px;background:linear-gradient(90deg,#362320,#57091d 40%,#890524);border-radius:999px}
</style>
@endpush

@section('content')

{{-- ================= HERO (center text + side photos) ================= --}}
<section class="relative overflow-hidden">
  <div class="max-w-6xl mx-auto px-4 py-16 md:py-20">
    <div class="relative">
      {{-- foto kiri --}}
      <img
        src="{{ Vite::asset('resources/images/hero-left.jpg') }}"
        alt=""
        class="hidden md:block absolute -left-16 top-1/2 -translate-y-1/2 w-72 h-72 object-cover rounded-3xl shadow-soft ring-1 ring-bcake-truffle/10">

      {{-- foto kanan --}}
      <img
        src="{{ Vite::asset('resources/images/hero-right.jpg') }}"
        alt=""
        class="hidden md:block absolute -right-16 top-1/2 -translate-y-1/2 w-80 h-80 object-cover rounded-3xl shadow-soft ring-1 ring-bcake-truffle/10">

      {{-- konten tengah --}}
      <div class="relative max-w-xl mx-auto text-center">
        <p class="inline-flex items-center gap-2 text-xs tracking-wider uppercase text-bcake-wine/80">
          <span class="h-1.5 w-1.5 rounded-full bg-bcake-cherry"></span>
          Handcrafted • Since 2025
        </p>

        <h1 class="font-display text-4xl md:text-5xl leading-tight mt-4">
          Delight in <br><span class="text-bcake-wine">every bite!</span>
        </h1>

        <p class="mt-4 text-bcake-truffle/90">
          Kue artisanal lembut, macarons cantik, dan koleksi cupcake — dibuat segar setiap hari.
        </p>

        <div class="mt-7 flex items-center justify-center gap-3">
          <x-button href="{{ route('products.index') }}" class="bg-bcake-cherry hover:bg-bcake-wine text-white">
            Order Now
          </x-button>
          <x-button variant="outline" href="#signature" class="border-bcake-truffle/25">Lihat Signature</x-button>
        </div>
      </div>
    </div>
  </div>
  <div class="bcake-divider max-w-6xl mx-auto"></div>
</section>

{{-- ================= TEST GAMBAR (hapus setelah berhasil) ================= --}}
<div class="max-w-6xl mx-auto px-4 py-6 border border-red-400 bg-white rounded-xl">
  <p class="font-semibold text-red-600 mb-3">🔍 Test gambar Vite</p>
  <div class="grid grid-cols-3 gap-3 text-xs">
    <div class="text-center">
      <img src="{{ Vite::asset('resources/images/hero-left.jpg') }}" class="w-full h-32 object-cover rounded-lg border">
      hero-left.jpg
    </div>
    <div class="text-center">
      <img src="{{ Vite::asset('resources/images/hero-right.jpg') }}" class="w-full h-32 object-cover rounded-lg border">
      hero-right.jpg
    </div>
    <div class="text-center">
      <img src="{{ Vite::asset('resources/images/sig1.jpg') }}" class="w-full h-32 object-cover rounded-lg border">
      sig1.jpg
    </div>
    <div class="text-center">
      <img src="{{ Vite::asset('resources/images/sig2.jpg') }}" class="w-full h-32 object-cover rounded-lg border">
      sig2.jpg
    </div>
    <div class="text-center">
      <img src="{{ Vite::asset('resources/images/sig3.jpg') }}" class="w-full h-32 object-cover rounded-lg border">
      sig3.jpg
    </div>
    <div class="text-center">
      <img src="{{ Vite::asset('resources/images/promo.jpg') }}" class="w-full h-32 object-cover rounded-lg border">
      promo.jpg
    </div>
  </div>
</div>

{{-- ================= SIGNATURE ================= --}}
<section id="signature" class="max-w-6xl mx-auto px-4 py-14">
  <h2 class="font-display text-3xl text-center">Signature</h2>
  <p class="text-center text-bcake-truffle/80 mt-2">Favorit pelanggan kami — manis, elegan, dan berkesan.</p>

  <div class="relative mt-8">
    {{-- tombol panah kiri (non-aktif/placeholder) --}}
    <button class="hidden md:flex absolute -left-4 top-1/2 -translate-y-1/2 h-9 w-9 items-center justify-center rounded-full ring-1 ring-bcake-truffle/20 bg-white shadow hover:bg-rose-50">
      ‹
    </button>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      {{-- kartu 1 --}}
      <a href="{{ route('products.index') }}" class="group rounded-3xl bg-white border border-bcake-truffle/10 shadow-soft overflow-hidden">
        <img src="{{ Vite::asset('resources/images/sig1.jpg') }}" alt="Custom Cakes"
             class="h-56 w-full object-cover group-hover:scale-[1.02] transition">
        <div class="p-5">
          <div class="font-display text-xl">Custom Cakes</div>
          <p class="text-sm text-bcake-truffle/80 mt-1">Pesan desain kue sesuai tema acara.</p>
        </div>
      </a>

      {{-- kartu 2 --}}
      <a href="{{ route('products.index') }}" class="group rounded-3xl bg-white border border-bcake-truffle/10 shadow-soft overflow-hidden">
        <img src="{{ Vite::asset('resources/images/sig2.jpg') }}" alt="Macarons"
             class="h-56 w-full object-cover group-hover:scale-[1.02] transition">
        <div class="p-5">
          <div class="font-display text-xl">Macarons</div>
          <p class="text-sm text-bcake-truffle/80 mt-1">Warna pastel, rasa premium.</p>
        </div>
      </a>

      {{-- kartu 3 --}}
      <a href="{{ route('products.index') }}" class="group rounded-3xl bg-white border border-bcake-truffle/10 shadow-soft overflow-hidden">
        <img src="{{ Vite::asset('resources/images/sig3.jpg') }}" alt="Cupcake Collections"
             class="h-56 w-full object-cover group-hover:scale-[1.02] transition">
        <div class="p-5">
          <div class="font-display text-xl">Cupcake Collections</div>
          <p class="text-sm text-bcake-truffle/80 mt-1">Kotak 6/12 pcs — cocok untuk hadiah.</p>
        </div>
      </a>
    </div>

    {{-- tombol panah kanan (non-aktif/placeholder) --}}
    <button class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 h-9 w-9 items-center justify-center rounded-full ring-1 ring-bcake-truffle/20 bg-white shadow hover:bg-rose-50">
      ›
    </button>
  </div>
</section>

{{-- ================= HOLIDAY COLLECTION (banner) ================= --}}
<section class="max-w-6xl mx-auto px-4 pb-16">
  <div class="rounded-3xl overflow-hidden border border-bcake-truffle/10 shadow-soft grid md:grid-cols-2 bg-rose-50">
    {{-- gambar --}}
    <img src="{{ Vite::asset('resources/images/promo.jpg') }}" alt="Holiday cake"
         class="w-full h-[260px] md:h-full object-cover">

    {{-- teks --}}
    <div class="p-8 md:p-10 bg-white/80 backdrop-blur">
      <h3 class="font-display text-3xl">Holiday Collection</h3>
      <p class="text-bcake-truffle/80 mt-2 max-w-md">Kue edisi spesial dengan dekor elegan. Stok terbatas!</p>

      <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-bcake-truffle/15 bg-white px-5 py-3">
        <span class="text-bcake-bitter font-semibold text-xl">20% OFF</span>
        <span class="text-bcake-truffle/70 text-sm">untuk pembelian paket</span>
      </div>

      <div class="mt-6">
        <x-button href="{{ route('products.index') }}" class="bg-bcake-wine hover:opacity-90 text-white">
          Order Today
        </x-button>
      </div>
    </div>
  </div>
</section>

@endsection


