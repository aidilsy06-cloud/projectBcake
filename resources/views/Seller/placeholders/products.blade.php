@extends('layouts.app')

@section('title','Katalog Toko — B’cake')

@push('head')
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
    --bcake-gold:#f6b846;
  }

  .page-bg{
    background:
      radial-gradient(1200px 600px at 0% 0%, #ffe6f0 0%, transparent 60%),
      radial-gradient(1200px 600px at 100% 0%, #fff4e8 0%, transparent 60%),
      #fff9fb;
  }

  .pill{
    background:rgba(255,255,255,.8);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,.6);
    box-shadow:0 8px 24px rgba(137,5,36,.06);
    border-radius:999px;
  }

  .btn-main{
    background: linear-gradient(135deg, #e01e5a, #ff9f45);
    box-shadow:0 14px 34px rgba(224, 30, 90, .32);
  }
  .btn-main:hover{
    transform: translateY(-1px) scale(1.02);
    filter: brightness(1.06);
  }

  .card-soft{
    background: linear-gradient(150deg,#ffffff,#fff6f8 60%,#ffe9f1);
    box-shadow:0 18px 40px rgba(137,5,36,.12);
    border-radius: 24px;
  }

  .card-empty{
    background: radial-gradient(circle at top,#fff5f9 0,#ffe9f3 40%,#ffe1f0 80%);
    box-shadow:0 18px 40px rgba(137,5,36,.12);
    border-radius: 28px;
  }

  .text-gold{ color:var(--bcake-gold); }
</style>
@endpush

@section('content')
<div class="page-bg min-h-screen py-10">
  <div class="max-w-7xl mx-auto px-4 md:px-8 space-y-10">

    {{-- ========== HEADER TOKO GLAM ========== --}}
    <div class="rounded-[28px] p-[2px] bg-gradient-to-r from-[#ffe0f0] via-[#fff4d9] to-[#ffd1e3] shadow-[0_22px_60px_rgba(137,5,36,.16)]">
      <div class="bg-white/85 rounded-[26px] px-6 md:px-10 py-6 md:py-8 flex flex-col md:flex-row md:items-center gap-6 relative overflow-hidden">

        {{-- dekor garis halus di atas --}}
        <div class="absolute inset-x-8 -top-3 h-1 rounded-full bg-gradient-to-r from-[#ffc3e0] via-[#ffe58f] to-[#ffb3d5] opacity-70"></div>

        {{-- avatar / logo --}}
        <div class="relative shrink-0">
          <div class="h-24 w-24 md:h-28 md:w-28 rounded-full border-[5px] border-rose-200/80 overflow-hidden shadow-xl bg-white">
            <img
              src="{{ $store->logo_url ?? asset('image/cake.jpg') }}"
              class="w-full h-full object-cover"
              alt="Logo Toko">
          </div>
          <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 text-[11px] px-3 py-1 pill text-rose-700 font-medium">
            Seller ✨
          </span>
        </div>

        {{-- info toko --}}
        <div class="flex-1 space-y-3 md:space-y-4">
          <div class="inline-flex items-center gap-2 text-xs text-rose-500 pill px-3 py-1">
            <span>✨ Glam Sweet Boutique</span>
          </div>

          <div>
            <h1 class="font-display text-3xl md:text-4xl text-gold leading-tight">
              {{ $store->name ?? 'Toko B’cake' }}
            </h1>
            <p class="mt-1 text-rose-600 text-sm md:text-base max-w-xl">
              Etalase glam untuk semua kreasi manismu. Biar pembeli langsung jatuh cinta dari pandangan pertama. 🍰💖
            </p>
          </div>

          {{-- tags manis --}}
          <div class="flex flex-wrap gap-2 text-[11px] md:text-xs">
            <span class="pill px-3 py-1 flex items-center gap-1">
              🧁 <span>Premium Cakes</span>
            </span>
            <span class="pill px-3 py-1 flex items-center gap-1">
              🎂 <span>Birthday Glam</span>
            </span>
            <span class="pill px-3 py-1 flex items-center gap-1">
              🍰 <span>Tea-time Desserts</span>
            </span>
          </div>
        </div>

        {{-- tombol tambah produk --}}
        <div class="md:self-start md:ml-auto">
          <a href="{{ route('seller.products.create') }}"
             class="inline-flex items-center gap-2 rounded-full px-5 md:px-6 py-2.5 text-sm font-medium text-white btn-main transition relative z-10">
            ✨ Tambah Produk
          </a>
        </div>

      </div>
    </div>

    {{-- ========== INFO BAR ========== --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs md:text-sm">
      <div class="pill px-4 py-3 flex items-center justify-between">
        <span class="text-rose-500 flex items-center gap-1">🧁 <span>Total Produk</span></span>
        <span class="font-semibold text-rose-800">{{ $products->count() }}</span>
      </div>

      <div class="pill px-4 py-3 flex items-center justify-between">
        <span class="text-rose-500 flex items-center gap-1">💡 <span>Status</span></span>
        <span class="font-semibold text-emerald-600">Aktif</span>
      </div>

      <div class="pill px-4 py-3 flex items-center justify-between">
        <span class="text-rose-500 flex items-center gap-1">🏪 <span>Toko</span></span>
        <span class="font-semibold text-rose-800">B’cake Seller</span>
      </div>

      <div class="pill px-4 py-3 flex items-center justify-between">
        <span class="text-rose-500 flex items-center gap-1">📂 <span>Mode</span></span>
        <span class="font-semibold text-rose-800">Katalog</span>
      </div>
    </div>

    {{-- ========== JUDUL KATALOG ========== --}}
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="font-display text-2xl md:text-3xl text-gold flex items-center gap-2">
          Katalog Manis Kamu
          <span>👒</span>
        </h2>
        <p class="text-sm text-rose-500">
          Susun kue-kue terbaikmu dengan tampilan yang glam & tertata rapi.
        </p>
      </div>

      {{-- tombol versi desktop (cadangan kalau mau ada 2 tombol) --}}
      <a href="{{ route('seller.products.create') }}"
         class="hidden md:inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium text-white btn-main transition">
        + Tambah Produk
      </a>
    </div>

    {{-- ========== GRID / EMPTY STATE ========== --}}
    @if($products->count())
      <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
          <div class="card-soft overflow-hidden">

            {{-- Foto --}}
            <div class="relative aspect-[4/3] overflow-hidden">
              <img
                src="{{ $product->image_url ?? asset('image/cake.jpg') }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover hover:scale-105 transition">
              <div class="absolute top-3 left-3 pill px-3 py-1 text-[11px] text-rose-700 font-medium">
                {{ $product->category->name ?? 'Cake' }}
              </div>
              <div class="absolute bottom-3 right-3 pill px-3 py-1 text-xs font-semibold text-rose-900">
                Rp{{ number_format($product->price,0,',','.') }}
              </div>
            </div>

            {{-- Detail --}}
            <div class="px-4 pt-3 pb-5">
              <h3 class="font-semibold text-rose-900 text-lg line-clamp-1">
                {{ $product->name }}
              </h3>
              <p class="mt-1 text-rose-600 text-sm line-clamp-2">
                {{ $product->short_description ?? 'Kue lembut dengan rasa manis seimbang.' }}
              </p>

              <div class="mt-4 flex items-center justify-between gap-2">
                <a href="{{ route('products.show',$product) }}"
                   class="px-4 py-2 rounded-full bg-rose-600 text-white text-xs md:text-sm hover:bg-rose-700 transition">
                  Lihat Detail
                </a>
                <a href="{{ route('seller.products.edit',$product) }}"
                   class="px-3 py-2 rounded-full border border-rose-300 text-[11px] md:text-xs text-rose-700 hover:bg-rose-50">
                  Edit Produk
                </a>
              </div>
            </div>

          </div>
        @endforeach
      </div>
    @else
      {{-- EMPTY STATE GLAM --}}
      <div class="mt-6 card-empty px-6 md:px-10 py-10 text-center">
        <div class="text-3xl mb-2">🧁 ✨</div>
        <h3 class="font-display text-xl md:text-2xl text-gold mb-1">
          Etalase-mu masih kosong, sayang~
        </h3>
        <p class="text-sm md:text-base text-rose-600 max-w-xl mx-auto">
          Belum ada produk di etalase kamu. Yuk tambahkan kue pertama kamu dan buat etalase B’cake-mu bersinar. 💗
        </p>

        <a href="{{ route('seller.products.create') }}"
           class="inline-flex mt-6 items-center gap-2 rounded-full px-6 py-2.5 text-sm font-medium text-white btn-main transition">
          + Tambah Produk Pertama
        </a>
      </div>
    @endif

  </div>
</div>
@endsection
