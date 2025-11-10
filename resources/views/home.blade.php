@extends('layouts.app')

@section('title','B’cake — Elegant Bakery')

@section('content')

{{-- ============ HERO ============ --}}
<section class="bg-rose-50">
  <div class="max-w-7xl mx-auto px-4">
    <div class="rounded-3xl overflow-hidden shadow-[0_20px_40px_rgba(0,0,0,0.06)]">
      <svg viewBox="0 0 1440 640" class="w-full h-[640px] block">
        <defs>
          <mask id="bookNotch">
            <rect width="1440" height="640" fill="#fff"/>

            <!-- 🔻 Notch runcing di tengah -->
            <path fill="#000"
                  d="M520 0
                     C 640 0, 680 40, 720 100
                     C 760 40, 800 0, 920 0
                     Z" />
          </mask>
        </defs>

        <image
          href="{{ asset('image/cake.jpg') }}"
          width="1440" height="640"
          preserveAspectRatio="xMidYMid slice"
          mask="url(#bookNotch)" />
      </svg>
    </div>
  </div>
</section>

{{-- ========= WHY + FEATURED GRID (pakai cake.jpg sementara) ========= --}}
<section class="py-10 md:py-14">
  <div class="max-w-[90rem] mx-auto px-4">

    {{-- ROW 1: image – text – image --}}
    <div class="grid md:grid-cols-12 gap-6 items-stretch">
      {{-- Left image --}}
      <div class="md:col-span-3">
        <div class="card h-full">
          <img src="{{ asset('image/cake.jpg') }}" alt="Cake" class="w-full aspect-[4/3] object-cover">
        </div>
      </div>

      {{-- Center text card --}}
      <div class="md:col-span-6">
        <div class="card h-full flex flex-col items-center justify-center text-center p-8">
          <p class="uppercase tracking-widest text-bcake-truffle/60 text-xs">Since 2025</p>
          <h2 class="font-display text-3xl md:text-4xl mt-2">Why Choose Us?</h2>
          <p class="mt-3 text-bcake-truffle/80 max-w-xl">
            Kue kami dibuat dari bahan premium, dengan resep artisan dan cita rasa khas B’cake —
            lembut, elegan, dan selalu segar setiap hari.
          </p>
          <a href="{{ route('products.index') }}" class="btn btn-ghost mt-6">Lihat Menu Kami</a>
        </div>
      </div>

      {{-- Right image --}}
      <div class="md:col-span-3">
        <div class="card h-full">
          <img src="{{ asset('image/cake.jpg') }}" alt="Cake" class="w-full aspect-[4/3] object-cover">
        </div>
      </div>
    </div>

    {{-- ROW 2: 3 product tiles + right promo --}}
    <div class="grid md:grid-cols-12 gap-6 mt-6">
      {{-- Product 1 --}}
      <div class="md:col-span-3">
        <div class="card group">
          <img src="{{ asset('image/cake.jpg') }}" alt="Cake" class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-[1.02]">
          <div class="p-4">
            <h3 class="text-sm tracking-wide text-bcake-truffle/70">Artisan Breads</h3>
          </div>
        </div>
      </div>

      {{-- Product 2 --}}
      <div class="md:col-span-3">
        <div class="card group">
          <img src="{{ asset('image/cake.jpg') }}" alt="Cake" class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-[1.02]">
          <div class="p-4">
            <h3 class="text-sm tracking-wide text-bcake-truffle/70">Sweet Pastries</h3>
          </div>
        </div>
      </div>

      {{-- Product 3 --}}
      <div class="md:col-span-3">
        <div class="card group">
          <img src="{{ asset('image/cake.jpg') }}" alt="Cake" class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-[1.02]">
          <div class="p-4">
            <h3 class="text-sm tracking-wide text-bcake-truffle/70">Custom Cakes</h3>
          </div>
        </div>
      </div>

      {{-- Right promo text block --}}
      <div class="md:col-span-3">
        <div class="card h-full p-6 flex flex-col justify-between">
          <div>
            <p class="uppercase tracking-widest text-bcake-truffle/60 text-xs">Daily Fresh</p>
            <h3 class="font-display text-2xl mt-1 leading-tight">Sweety, Sweet Bakes…</h3>
            <p class="mt-3 text-bcake-truffle/80">
              Koleksi musiman dengan bahan pilihan, buah segar, dan krim premium khas B’cake.
              Siap membuat harimu manis!
            </p>
          </div>
          <a href="{{ route('products.index') }}" class="btn btn-primary mt-6 self-start">
            Order Now
          </a>
        </div>
      </div>
    </div>

  </div>
</section>
{{-- ============ SIGNATURE ============ --}}
<section id="signature" class="max-w-7xl mx-auto px-6 py-14">
  <h2 class="font-display text-3xl text-center">Signature</h2>
  <p class="text-center text-gray-600 mt-2">Favorit pelanggan kami — manis, elegan, dan berkesan.</p>

  <div class="relative mt-8">
    <button class="hidden md:flex absolute -left-4 top-1/2 -translate-y-1/2 h-9 w-9 items-center justify-center rounded-full ring-1 ring-rose-200 bg-white shadow hover:bg-rose-50">‹</button>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ([['Custom Cakes'],['Macarons'],['Cupcake Collections']] as $card)
        <a href="{{ route('products.index') }}" class="group rounded-3xl bg-white border border-rose-200 shadow-soft overflow-hidden">
          <img src="{{ asset('image/cake.jpg') }}" alt="{{ $card[0] }}" class="h-56 w-full object-cover group-hover:scale-[1.02] transition">
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
    <img src="{{ asset('image/cake.jpg') }}" alt="Holiday cake" class="w-full h-[260px] md:h-full object-cover">
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

<footer class="relative mt-16 w-full bg-[#f7e3e7] text-bcake-truffle pt-10 pb-6 overflow-hidden">
  {{-- Lace border atas --}}
  <div class="absolute top-0 left-0 w-full h-6 bg-repeat-x"
       style="background-image: url('{{ asset('image/lace-border.png') }}'); background-size: auto 100%;">
  </div>

  {{-- isi footer di tengah --}}
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6 md:gap-12">

      {{-- kolom kiri --}}
      <div class="text-center md:text-left">
        <h2 class="font-display text-3xl text-bcake-wine">B’cake</h2>
        <p class="mt-2 italic text-bcake-truffle/80">“Because elegance can be sweet.”</p>
      </div>

      {{-- kolom tengah --}}
      <div class="text-center">
        <h3 class="font-medium uppercase tracking-widest text-sm text-bcake-truffle/70 mb-2">
          Contact &amp; Socials
        </h3>
        <div class="flex justify-center md:justify-start gap-4 mt-3">
          <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-white hover:bg-bcake-wine hover:text-white transition">
            <i class="fa-brands fa-instagram text-lg"></i>
          </a>
          <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-white hover:bg-bcake-wine hover:text-white transition">
            <i class="fa-brands fa-whatsapp text-lg"></i>
          </a>
          <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-white hover:bg-bcake-wine hover:text-white transition">
            <i class="fa-brands fa-tiktok text-lg"></i>
          </a>
          <a href="mailto:hello@bcake.local" class="w-10 h-10 rounded-full flex items-center justify-center bg-white hover:bg-bcake-wine hover:text-white transition">
            <i class="fa-solid fa-envelope text-lg"></i>
          </a>
        </div>
      </div>

      {{-- kolom kanan --}}
      <div class="text-center md:text-right">
        <p class="text-sm text-bcake-truffle/70">© {{ date('Y') }} B’cake Bakery. All rights reserved.</p>
        <p class="text-xs text-bcake-truffle/60">Designed with 🍒 by Team B’cake</p>
      </div>
    </div>
  </div>
</footer>

@endsection
