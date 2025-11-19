@extends('layouts.app')
@section('title', 'Katalog Toko — B’cake')

@push('head')
<style>
  :root{
    --wine:#890524;
    --deep:#57091d;
    --cocoa:#362320;
  }
  .shadow-soft{box-shadow:0 26px 60px rgba(137,5,36,.13)}

  .hero-seller{
    background:
      radial-gradient(900px 480px at 80% -10%,rgba(255,233,240,.95),transparent 60%),
      linear-gradient(135deg,#fff7f8,#ffe8cf);
  }
  .pill{
    display:inline-flex;
    align-items:center;
    gap:.4rem;
    border-radius:999px;
    padding:.3rem .8rem;
    font-size:.7rem;
    background:#fff;
    border:1px solid rgba(248,113,113,.25);
    color:#9f1239;
  }
  .btn-primary{
    border-radius:999px;
    padding:.55rem 1.2rem;
    font-size:.85rem;
    font-weight:600;
    background:linear-gradient(135deg,#fb7185,#f97316);
    color:#fff;
    box-shadow:0 14px 30px rgba(249,113,113,.4);
    transition:.2s;
  }
  .btn-primary:hover{
    filter:brightness(.97);
    transform:translateY(-1px);
  }
  .btn-soft{
    border-radius:999px;
    padding:.45rem .95rem;
    font-size:.8rem;
    border:1px solid rgba(248,113,113,.25);
    background:#fff;
    color:#9f1239;
    transition:.2s;
  }
  .btn-soft:hover{
    background:#fff1f2;
  }

  /* BADGE MENU YANG BISA DIKLIK */
  .stat-menu{
    display:flex;
    align-items:center;
    justify-content:space-between;
    min-width:150px;
    padding:.7rem 1rem;
    border-radius:999px;
    background:#fff;
    border:1px solid rgba(248,113,113,.25);
    box-shadow:0 16px 30px rgba(248,113,113,.08);
    font-size:.8rem;
    color:#9f1239;
    transition:.2s;
  }
  .stat-menu:hover{
    background:#fff1f2;
    transform:translateY(-2px);
  }
  .stat-menu:active{
    background:#ffe4e6;
    transform:scale(.98);
  }
</style>
@endpush

@section('content')
@php
  $storeName   = $store->name ?? 'Toko B’cake';
  $storeTag    = $store->tagline ?? 'Glam Sweet Boutique';
  $description = $store->description
      ?? 'Etalase glam untuk semua kreasi manismu. Biar pembeli langsung jatuh cinta di pandangan pertama. 🧁💖';

  $logo = $store->logo_url
      ?? ($store->logo ? asset('storage/'.$store->logo) : asset('image/logo_bcake.jpg'));

  $productsCount = isset($products)
      ? (is_countable($products) ? count($products) : $products->count())
      : 0;
@endphp

<div class="bg-rose-50/60">
  <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-10 space-y-8">

    {{-- ================ HERO SELLER ================ --}}
    <section class="hero-seller rounded-3xl shadow-soft border border-rose-100/70 px-6 md:px-9 py-7 md:py-9">
      <div class="flex flex-col gap-6">

        <div class="flex items-start gap-4">
          {{-- Avatar toko --}}
          <div class="relative shrink-0">
            <div class="h-16 w-16 md:h-20 md:w-20 rounded-full bg-white border-2 border-rose-200 overflow-hidden">
              <img src="{{ $logo }}" class="h-full w-full object-cover" alt="{{ $storeName }}">
            </div>
            <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-rose-600 text-[10px] text-white px-2 py-0.5 rounded-full shadow">
              Seller
            </span>
          </div>

          {{-- Info toko --}}
          <div class="flex-1 space-y-1">
            <p class="text-[11px] uppercase tracking-[.25em] text-rose-500/90">
              {{ $storeTag }}
            </p>
            <h1 class="text-2xl md:text-3xl font-semibold text-[color:var(--cocoa)]">
              {{ $storeName }}
            </h1>
            <p class="text-sm md:text-[0.95rem] text-rose-900/80 max-w-2xl">
              {{ $description }}
            </p>
            <div class="flex flex-wrap gap-2 mt-2">
              <span class="pill">🎂 Premium Cakes</span>
              <span class="pill">🎉 Birthday Glam</span>
              <span class="pill">☕ Tea-time Desserts</span>
            </div>
          </div>

          {{-- Tombol kanan: Tambah Produk + Logout tulisan saja --}}
          <div class="flex flex-col items-end gap-2">
            @if(Route::has('seller.products.create'))
              <a href="{{ route('seller.products.create') }}" class="btn-primary inline-flex items-center gap-2">
                ✨ Tambah Produk
              </a>
            @endif

            @auth
              <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit"
                        class="px-4 py-2 rounded-full text-xs font-medium
                               bg-white border border-rose-200/70 text-rose-700
                               hover:bg-rose-50 transition">
                  Logout
                </button>
              </form>
            @endauth
          </div>
        </div>

        {{-- ========== BARIS BADGE YANG BISA DIKLIK ========== --}}
        <div class="flex flex-wrap gap-3 mt-3">
          {{-- Total Produk --}}
          <a href="{{ route('seller.products.index') }}" class="stat-menu">
            <span class="text-[13px]">🧁 Total Produk</span>
            <span class="font-semibold">{{ $productsCount }}</span>
          </a>

          {{-- Status --}}
          <a href="#" class="stat-menu">
            <span class="text-[13px]">💡 Status</span>
            <span class="text-emerald-600 font-semibold">Aktif</span>
          </a>

          {{-- Toko --}}
          @if(Route::has('seller.store.show'))
            <a href="{{ route('seller.store.show') }}" class="stat-menu">
              <span class="text-[13px]">🏪 Toko</span>
              <span class="font-semibold">{{ $storeName }}</span>
            </a>
          @else
            <div class="stat-menu">
              <span class="text-[13px]">🏪 Toko</span>
              <span class="font-semibold">{{ $storeName }}</span>
            </div>
          @endif

          {{-- Mode --}}
          <a href="{{ route('seller.products.index') }}" class="stat-menu">
            <span class="text-[13px]">📁 Mode</span>
            <span class="font-semibold">Katalog</span>
          </a>

          {{-- Katalog --}}
          <a href="{{ route('seller.products.index') }}" class="stat-menu">
            <span class="text-[13px]">📚 Katalog</span>
            <span class="font-semibold">Lihat</span>
          </a>
        </div>

      </div>
    </section>

    {{-- ================ KATALOG PRODUK ================ --}}
    <section class="space-y-4">
      <div class="flex items-center justify-between gap-3">
        <div>
          <h2 class="text-lg md:text-xl font-semibold text-[color:var(--cocoa)]">
            Katalog Manis Kamu 🧁
          </h2>
          <p class="text-sm text-rose-800/80">
            Susun kue-kue terbaikmu dengan tampilan yang glam & tertata rapi.
          </p>
        </div>

        @if(Route::has('seller.products.create'))
          <a href="{{ route('seller.products.create') }}" class="btn-soft hidden sm:inline-flex items-center gap-1">
            + Tambah Produk
          </a>
        @endif
      </div>

      @if($productsCount === 0)
        {{-- EMPTY STATE --}}
        <div class="rounded-3xl bg-gradient-to-br from-rose-50 via-rose-100/80 to-amber-50/70 border border-rose-100 px-6 md:px-10 py-10 text-center shadow-soft">
          <div class="text-4xl mb-2">🧁✨</div>
          <h3 class="text-[1.05rem] md:text-lg font-semibold text-amber-800 mb-1">
            Etalase-mu masih kosong, sayang~
          </h3>
          <p class="text-sm text-rose-700/90 max-w-xl mx-auto">
            Belum ada produk di etalase kamu. Yuk tambahkan kue pertama kamu
            dan buat etalase B’cake-mu bersinar. 💗
          </p>

          @if(Route::has('seller.products.create'))
            <a href="{{ route('seller.products.create') }}"
               class="mt-5 inline-flex btn-primary">
              + Tambah Produk Pertama
            </a>
          @endif
        </div>
      @else
        {{-- GRID PRODUK --}}
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-3">
          @foreach($products as $product)
            @php
              $img = $product->cover_url
                    ?? ($product->image_url ?? null)
                    ?? (isset($product->image) ? asset('storage/'.$product->image) : asset('image/Cake-Pinky.jpg'));
            @endphp

            <article class="bg-white rounded-3xl shadow-soft border border-rose-100 p-4 flex flex-col">
              <a href="{{ route('seller.products.edit', $product->id) }}"
                 class="block rounded-2xl overflow-hidden mb-3">
                <img src="{{ $img }}"
                     alt="{{ $product->name }}"
                     class="w-full h-40 md:h-44 object-cover transition duration-300 hover:scale-105">
              </a>
              <div class="flex-1 flex flex-col gap-2">
                <h3 class="text-sm font-semibold text-[color:var(--cocoa)] line-clamp-2">
                  {{ $product->name }}
                </h3>
                <p class="text-[11px] text-rose-600/80 line-clamp-2">
                  {{ $product->short_description ?? 'Kue manis pilihan untuk momen spesial.' }}
                </p>
                <p class="text-sm font-semibold text-rose-700 mt-1">
                  Rp {{ number_format($product->price ?? 0,0,',','.') }}
                </p>

                <div class="mt-2 flex items-center justify-between gap-2">
                  <a href="{{ route('seller.products.edit', $product->id) }}"
                     class="btn-soft text-[11px]">
                    Edit
                  </a>
                  @if(Route::has('products.show'))
                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                       class="btn-soft text-[11px]">
                      Lihat di publik
                    </a>
                  @endif
                </div>
              </div>
            </article>
          @endforeach
        </div>
      @endif
    </section>

  </div>
</div>
@endsection
