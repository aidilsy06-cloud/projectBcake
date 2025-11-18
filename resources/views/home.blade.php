@extends('layouts.app')

@section('title','B’cake — Elegant Bakery')

@section('content')

{{-- ================= HERO / SLIDER (book-notch pakai SVG mask) ================= --}}
<section class="bg-rose-50 pt-0 pb-10 -mt-[1px]">
  <div
    x-data="{
      active: 0,
      slides: [
        { image: '{{ asset('image/slicecake.jpg') }}', title: 'Sweet. Stunning. So You.' },
        { image: '{{ asset('image/longcake.jpg') }}', title: 'Cantik di mata, manis di rasa.' },
      ],
      next(){ this.active = (this.active+1) % this.slides.length },
      prev(){ this.active = (this.active-1+this.slides.length) % this.slides.length },
    }"
    x-init="setInterval(()=>next(), 5000)"
    class="relative max-w-6xl mx-auto -mt-4 md:-mt-6 lg:-mt-8"
  >
    <div class="relative rounded-[28px] overflow-hidden shadow-[0_20px_40px_rgba(0,0,0,0.08)]">
      <template x-for="(s, i) in slides" :key="i">
        <div
          x-show="active === i"
          x-transition:enter="transition ease-out duration-700"
          x-transition:enter-start="opacity-0 scale-[1.02]"
          x-transition:enter-end="opacity-100 scale-100"
          class="relative"
        >
          {{-- POTONG GAMBAR DENGAN BOOK-NOTCH --}}
          <svg viewBox="0 0 1920 680" class="w-full h-[460px] md:h-[560px] lg:h-[680px] block">
            <defs>
              <mask :id="`bookNotch-${i}`">
                <rect width="1920" height="680" fill="#fff"/>
                <path fill="#000"
                      d="M720 0
                         C 880 0, 940 60, 960 130
                         C 980 60, 1040 0, 1200 0
                         Z" />
              </mask>
            </defs>
            <image
              :href="s.image"
              width="1920" height="680"
              preserveAspectRatio="xMidYMid slice"
              class="scale-125 origin-center"
              :mask="`url(#bookNotch-${i})`" />
          </svg>

          {{-- =============== OVERLAY TEKS + LOGO =============== --}}
          <div class="absolute inset-0 flex flex-col items-center justify-center text-center z-20 px-4">

            {{-- LOGO hanya untuk slide pertama --}}
            <template x-if="i === 0">
              <div class="mb-4 flex flex-col items-center">
                <div class="rounded-3xl bg-white/12 border border-white/30 p-3 md:p-4 shadow-[0_18px_40px_rgba(0,0,0,0.45)] backdrop-blur-md">
                  <img 
                    src="{{ asset('image/logo_bcake.jpg') }}"
                    class="w-16 md:w-20 rounded-2xl object-contain"
                    alt="Bcake Logo">
                </div>
              </div>
            </template>

            {{-- TEKS UTAMA --}}
            <h2
              class="font-display text-3xl md:text-5xl leading-tight
                     bg-gradient-to-r from-[#e78b2d] to-[#c74e51]
                     bg-clip-text text-transparent
                     drop-shadow-[0_4px_14px_rgba(0,0,0,0.45)]"
              x-text="s.title">
            </h2>

            {{-- BUTTON --}}
            <a href="{{ route('products.index') }}" 
               class="mt-6 px-7 py-3 rounded-full bg-bcake-cherry hover:bg-bcake-wine text-white font-medium shadow-soft">
              Order Now
            </a>
          </div>
        </div>
      </template>

      {{-- Panah --}}
      <button @click="prev()"
              class="absolute left-3 top-1/2 -translate-y-1/2 h-9 w-9 rounded-full bg-white/80 hover:bg-white shadow grid place-items-center">‹</button>
      <button @click="next()"
              class="absolute right-3 top-1/2 -translate-y-1/2 h-9 w-9 rounded-full bg-white/80 hover:bg-white shadow grid place-items-center">›</button>
  
      {{-- Dots --}}
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
        <template x-for="(s, i) in slides" :key="i">
          <button @click="active=i"
                  :class="active===i ? 'bg-bcake-wine' : 'bg-white/80'"
                  class="h-2.5 w-2.5 rounded-full shadow"></button>
        </template>

      </div>
    </div>
  </div>
</section>

{{-- ========= WHY + FEATURED GRID (pakai cake.jpg sementara) ========= --}}
<section class="py-10 md:py-14">
  <div class="max-w-[90rem] mx-auto px-4">

    {{-- ROW 1 --}}
    <div class="grid md:grid-cols-12 gap-6 items-stretch">

      {{-- Left category --}}
      <div class="md:col-span-3">
        <div class="rounded-3xl shadow-sm overflow-hidden" style="background-color:#6a4e4a4d;">
          <img src="{{ asset('image/cakemodern.jpg') }}"
               alt="Modern & Custom Cake"
               class="w-full aspect-[4/3] object-cover">
          <div class="py-4 text-center">
            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
              Custom Cake & Modern Cake
            </h3>
          </div>
        </div>
      </div>

      {{-- Center content --}}
      <div class="md:col-span-6">
        <div class="card h-full flex flex-col items-center justify-center text-center p-8">
          <p class="uppercase tracking-widest text-bcake-truffle/60 text-xs">Since 2025</p>
          <h2 class="font-display text-3xl md:text-4xl mt-2">Kenapa Harus B'cake?</h2>
          <p class="mt-3 text-bcake-truffle/80 max-w-xl">
            B'cake menghadirkan ruang istemewa bagi para pembuat kue untuk menampilkan kreasi terbaik mereka.
            Kami menghubungkan para pembuat kue dengan menampilkan kreasi terbaik mereka dan pecinta kue dalam
            satu tempat yang hangat, dan penuh cita rasa.
          </p>
          <a href="{{ route('products.index') }}" class="btn btn-ghost mt-6">Lihat Menu Kami</a>
        </div>
      </div>

      {{-- Right category --}}
      <div class="md:col-span-3">
        <div class="rounded-3xl shadow-sm overflow-hidden" style="background-color:#6a4e4a4d;">
          <img src="{{ asset('image/cupcake.jpg') }}"
               alt="Cupcake & Brownies"
               class="w-full aspect-[4/3] object-cover">
          <div class="py-4 text-center">
            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
              Cupcake & Brownies
            </h3>
          </div>
        </div>
      </div>

    </div>

    {{-- ROW 2 --}}
    <div class="grid md:grid-cols-12 gap-6 mt-6">

      {{-- Product 1 --}}
      <div class="md:col-span-3">
        <div class="rounded-3xl shadow-sm overflow-hidden group" style="background-color:#6a4e4a4d;">
          <img src="{{ asset('image/Pastry.jpg') }}"
               alt="Pastry & Roti"
               class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-[1.02]">
          <div class="py-4 text-center">
            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
              Pastry & Roti
            </h3>
          </div>
        </div>
      </div>

      {{-- Product 2 --}}
      <div class="md:col-span-3">
        <div class="rounded-3xl shadow-sm overflow-hidden group" style="background-color:#6a4e4a4d;">
          <img src="{{ asset('image/dessertbox.jpg') }}"
               alt="Dessertbox"
               class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-[1.02]">
          <div class="py-4 text-center">
            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
              Dessert Box
            </h3>
          </div>
        </div>
      </div>

      {{-- Product 3 --}}
      <div class="md:col-span-3">
        <div class="rounded-3xl shadow-sm overflow-hidden group" style="background-color:#6a4e4a4d;">
          <img src="{{ asset('image/snack.jpg') }}"
               alt="Snack"
               class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-[1.02]">
          <div class="py-4 text-center">
            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
              Snack
            </h3>
          </div>
        </div>
      </div>

      {{-- Right promo (biarkan seperti sebelumnya) --}}
      <div class="md:col-span-3">
        <div class="card h-full p-6 flex flex-col justify-between">
          <div>
            <p class="uppercase tracking-widest text-bcake-truffle/60 text-xs">Daily Fresh</p>
            <h3 class="font-display text-2xl mt-1 leading-tight">Explore. Taste. Celebrate.</h3>
            <p class="mt-3 text-bcake-truffle/80">
              Temukan, pilih, dan pesan kue hingga nikmatin manisnya.
              Semudah itu di B'cake 💗
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
{{-- ============ REKOMENDASI SPESIAL ============ --}}
<section id="rekomendasi" class="max-w-7xl mx-auto px-6 py-14">
  <h2 class="font-display text-3xl text-center">Rekomendasi Spesial</h2>
  <p class="text-center text-gray-600 mt-2">
    Deretan pilihan kue terbaik yang direkomendasikan untuk kamu.
  </p>

  <div class="relative mt-8">
    <!-- Tombol kiri -->
    <button class="hidden md:flex absolute -left-4 top-1/2 -translate-y-1/2 h-9 w-9
                    items-center justify-center rounded-full ring-1 ring-rose-200
                    bg-white shadow hover:bg-rose-50">
      ‹
    </button>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse ($bestSellers as $product)
        <div class="rounded-lg shadow bg-white overflow-hidden">
          <img
            src="{{ asset('image/dessertbox.jpg') }}"
            class="w-full h-56 object-cover"
          >

          <div class="p-4">
            <h3 class="font-semibold text-lg text-bcake-cocoa">
              {{ $product->name }}
            </h3>
            <p class="text-sm text-gray-500 mt-1">
              Rekomendasi pilihan B’cake
            </p>
          </div>
        </div>
      @empty
        <p class="col-span-3 text-center text-gray-400 py-6">
          Belum ada produk yang bisa ditampilkan saat ini.
        </p>
      @endforelse
    </div>

    <!-- Tombol kanan -->
    <button class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 h-9 w-9
                    items-center justify-center rounded-full ring-1 ring-rose-200
                    bg-white shadow hover:bg-rose-50">
      ›
    </button>
  </div>
</section>

    <!-- Tombol kanan -->
    <button class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 h-9 w-9 
                    items-center justify-center rounded-full ring-1 ring-rose-200 
                    bg-white shadow hover:bg-rose-50">
      ›
    </button>
  </div>
</section>

{{-- ============ BANNER PROMO (HARI BESAR — SLIDER) ============ --}}
<section 
  class="max-w-7xl mx-auto px-6 pb-16"
  x-data="{
    active: 0,
    max: 3,
    touchStartX: 0,
    touchEndX: 0,
    next() { this.active = (this.active === this.max) ? 0 : this.active + 1 },
    prev() { this.active = (this.active === 0) ? this.max : this.active - 1 },
    onTouchStart(e) { this.touchStartX = e.touches[0].clientX },
    onTouchEnd(e) {
      this.touchEndX = e.changedTouches[0].clientX;
      const diff = this.touchEndX - this.touchStartX;
      if (Math.abs(diff) > 50) diff < 0 ? this.next() : this.prev();
    }
  }"
>
  <div 
    class="relative rounded-3xl overflow-hidden border border-rose-200 shadow-soft bg-white"
    @touchstart.passive="onTouchStart"
    @touchend.passive="onTouchEnd"
  >

    {{-- ===== Slide 1 – Valentine / Anniversary ===== --}}
    <div x-show="active === 0" x-transition>
      <div class="grid md:grid-cols-2">
        <img src="{{ asset('image/Cake-Pink.jpg') }}" class="w-full h-[260px] md:h-full object-cover">
        <div class="p-8 md:p-10 bg-rose-50/80 backdrop-blur">
          <h3 class="font-display text-3xl">Valentine Collection</h3>
          <p class="text-gray-700 mt-2 max-w-md">Rayakan momen spesial dengan kue pastel romantis pilihan para seller terbaik.</p>
          <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-rose-200 bg-white px-5 py-3">
            <span class="text-rose-900 font-semibold text-xl">Sweet Deals</span>
            <span class="text-gray-600 text-sm">slot terbatas!</span>
          </div>
          <div class="mt-6">
            <a href="{{ route('products.index') }}" class="rounded-full bg-rose-700 text-white px-6 py-3 hover:opacity-90">
              Pesan Sekarang
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== Slide 2 – Holiday / Christmas / New Year ===== --}}
    <div x-show="active === 1" x-transition>
      <div class="grid md:grid-cols-2">
        <img src="{{ asset('image/Cake-Pinky.jpg') }}" class="w-full h-[260px] md:h-full object-cover">
        <div class="p-8 md:p-10 bg-rose-50/80 backdrop-blur">
          <h3 class="font-display text-3xl">Holiday Collection</h3>
          <p class="text-gray-700 mt-2 max-w-md">Kue elegan untuk merayakan liburan akhir tahun bersama keluarga.</p>
          <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-rose-200 bg-white px-5 py-3">
            <span class="text-rose-900 font-semibold text-xl">20% OFF</span>
            <span class="text-gray-600 text-sm">untuk pembelian paket</span>
          </div>
          <div class="mt-6">
            <a href="{{ route('products.index') }}" class="rounded-full bg-rose-700 text-white px-6 py-3 hover:opacity-90">
              Order Today
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== Slide 3 – Birthday Collection ===== --}}
    <div x-show="active === 2" x-transition>
      <div class="grid md:grid-cols-2">
        <img src="{{ asset('image/Cake-Rainbow.jpg') }}" class="w-full h-[260px] md:h-full object-cover">
        <div class="p-8 md:p-10 bg-rose-50/80 backdrop-blur">
          <h3 class="font-display text-3xl">Birthday Collection</h3>
          <p class="text-gray-700 mt-2 max-w-md">Kue warna-warni meriah untuk rayakan ulang tahun dengan cara paling manis.</p>
          <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-rose-200 bg-white px-5 py-3">
            <span class="text-rose-900 font-semibold text-xl">Best Seller</span>
            <span class="text-gray-600 text-sm">disukai banyak pembeli</span>
          </div>
          <div class="mt-6">
            <a href="{{ route('products.index') }}" class="rounded-full bg-rose-700 text-white px-6 py-3 hover:opacity-90">
              Lihat Kue Ulang Tahun
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== Slide 4 – Mother’s Day / Hari Ibu ===== --}}
    <div x-show="active === 3" x-transition>
      <div class="grid md:grid-cols-2">
        <img src="{{ asset('image/Cake-Softpink.jpg') }}" class="w-full h-[260px] md:h-full object-cover">
        <div class="p-8 md:p-10 bg-rose-50/80 backdrop-blur">
          <h3 class="font-display text-3xl">Mother’s Day</h3>
          <p class="text-gray-700 mt-2 max-w-md">Kue lembut pastel untuk hadiah manis penuh cinta buat ibu tersayang.</p>
          <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-rose-200 bg-white px-5 py-3">
            <span class="text-rose-900 font-semibold text-xl">Special Gift</span>
            <span class="text-gray-600 text-sm">siap kirim</span>
          </div>
          <div class="mt-6">
            <a href="{{ route('products.index') }}" class="rounded-full bg-rose-700 text-white px-6 py-3 hover:opacity-90">
              Kirim ke Ibu
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== TOMBOL KIRI / KANAN ===== --}}
    <button
      type="button"
      class="hidden md:flex absolute left-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-white/90 hover:bg-white shadow-soft border border-rose-200 text-[#890524]"
      @click="prev()"
    >‹</button>

    <button
      type="button"
      class="hidden md:flex absolute right-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-white/90 hover:bg-white shadow-soft border border-rose-200 text-[#890524]"
      @click="next()"
    >›</button>

    {{-- ===== DOTS ===== --}}
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
      <template x-for="i in 4">
        <button
          class="h-2.5 rounded-full transition-all"
          :class="active === (i-1) ? 'w-6 bg-[#890524]' : 'w-2.5 bg-rose-200 hover:bg-rose-300'"
          @click="active=i-1"
        ></button>
      </template>
    </div>

  </div>
</section>

<footer class="relative mt-16 w-full bg-[#f7e3e7] text-bcake-truffle pt-10 pb-6 overflow-hidden">
  <div class="absolute top-0 left-0 w-full h-6 bg-repeat-x"
       style="background-image: url('{{ asset('image/lace-border.png') }}'); background-size: auto 100%;">
  </div>

  <div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6 md:gap-12">
      <div class="text-center md:text-left">
        <h2 class="font-display text-3xl text-bcake-wine">B’cake</h2>
        <p class="mt-2 italic text-bcake-truffle/80">“Because elegance can be sweet.”</p>
      </div>

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

      <div class="text-center md:text-right">
        <p class="text-sm text-bcake-truffle/70">© {{ date('Y') }} B’cake Bakery. All rights reserved.</p>
        <p class="text-xs text-bcake-truffle/60">Designed with 🍒 by Team B’cake</p>
      </div>
    </div>
  </div>
</footer>

@endsection
