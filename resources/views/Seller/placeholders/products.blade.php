@extends('layouts.app')

@section('title','Katalog Toko — B’cake')

@push('head')
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
  }
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }
  .card-soft{
    background: linear-gradient(145deg,#fff7f9,#ffe4ec);
    box-shadow:0 18px 40px rgba(137,5,36,.15);
  }
  .pill{
    background:rgba(255,255,255,.7);
    backdrop-filter:blur(6px);
  }
</style>
@endpush

@section('content')
<div class="page-bg min-h-screen py-10">
  <div class="max-w-7xl mx-auto px-4 md:px-8">

    {{-- HEADER TOKO / SELLER --}}
    <div class="flex flex-col md:flex-row items-center gap-6">
      <div class="relative">
        <div class="h-24 w-24 rounded-full border-4 border-rose-200 overflow-hidden shadow-lg">
          <img
            src="{{ $store->logo_url ?? 'https://via.placeholder.com/300x300.png?text=B%27cake' }}"
            alt="Logo Toko"
            class="w-full h-full object-cover">
        </div>
        <span class="absolute -bottom-2 -right-2 text-xs px-2 py-1 rounded-full pill text-rose-700 font-medium">
          Seller
        </span>
      </div>

      <div class="text-center md:text-left">
        <h1 class="font-display text-3xl md:text-4xl text-rose-900">
          {{ $store->name ?? 'Toko B’cake' }}
        </h1>
        <p class="mt-1 text-rose-600 text-sm md:text-base max-w-xl">
          Ruang manis untuk menampilkan setiap kreasi kue favorit pembeli. Atur produkmu,
          pantau pesanan, dan buat etalase toko yang bikin lapar mata. 🍰
        </p>
        @if(!empty($store->address))
          <p class="mt-2 text-xs md:text-sm text-rose-500">
            📍 {{ $store->address }}
          </p>
        @endif
      </div>
    </div>

    {{-- INFO BAR --}}
    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-3 text-xs md:text-sm">
      <div class="pill px-4 py-3 rounded-2xl flex items-center justify-between">
        <span class="text-rose-500">Total Produk</span>
        <span class="font-semibold text-rose-800">{{ $products->count() }}</span>
      </div>
      <div class="pill px-4 py-3 rounded-2xl flex items-center justify-between">
        <span class="text-rose-500">Status</span>
        <span class="font-semibold text-emerald-600">Aktif</span>
      </div>
      <div class="pill px-4 py-3 rounded-2xl flex items-center justify-between">
        <span class="text-rose-500">Toko</span>
        <span class="font-semibold text-rose-800">B’cake Seller</span>
      </div>
      <div class="pill px-4 py-3 rounded-2xl flex items-center justify-between">
        <span class="text-rose-500">Mode</span>
        <span class="font-semibold text-rose-800">Katalog</span>
      </div>
    </div>

    {{-- JUDUL KATALOG --}}
    <div class="mt-10 flex items-center justify-between gap-4">
      <div>
        <h2 class="font-display text-2xl md:text-3xl text-rose-900">
          Katalog Manis Kamu 🍮
        </h2>
        <p class="text-sm text-rose-500 mt-1">
          Atur tampilan produk, biar pembeli jatuh cinta dari pandangan pertama.
        </p>
      </div>
      <a
        href="{{ route('seller.products.create') }}"
        class="hidden md:inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-rose-600 to-amber-400 text-white text-sm font-medium px-5 py-2.5 shadow-lg hover:scale-[1.02] transition">
        + Tambah Produk
      </a>
    </div>

    {{-- GRID PRODUK --}}
    @if($products->count())
      <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($products as $product)
          <div class="card-soft rounded-3xl overflow-hidden relative">
            {{-- Gambar produk --}}
            <div class="relative aspect-[4/3] overflow-hidden">
              <img
                src="{{ $product->image_url ?? asset('image/cake.jpg') }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover hover:scale-105 transition">
              <div class="absolute top-3 left-3 pill px-3 py-1 rounded-full text-[11px] text-rose-700 font-medium">
                {{ $product->category->name ?? 'Cake' }}
              </div>
              <div class="absolute bottom-3 right-3 pill px-3 py-1 rounded-full text-xs font-semibold text-rose-900">
                Rp{{ number_format($product->price,0,',','.') }}
              </div>
            </div>

            {{-- Detail singkat --}}
            <div class="px-4 pt-3 pb-4">
              <h3 class="text-base md:text-lg font-semibold text-rose-900 line-clamp-1">
                {{ $product->name }}
              </h3>
              <p class="mt-1 text-xs md:text-sm text-rose-600 line-clamp-2">
                {{ $product->short_description ?? 'Kue lembut dengan rasa manis seimbang, pas jadi teman teh soremu.' }}
              </p>

              <div class="mt-4 flex items-center justify-between gap-2">
                <a
                  href="{{ route('products.show',$product) }}"
                  class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-rose-600 text-white text-xs md:text-sm font-medium shadow hover:bg-rose-700 transition">
                  Lihat Detail
                </a>

                <a
                  href="{{ route('seller.products.edit',$product) }}"
                  class="inline-flex items-center justify-center px-3 py-2 rounded-full border border-rose-300 text-[11px] md:text-xs text-rose-700 hover:bg-rose-50">
                  Edit Produk
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      {{-- kalau belum ada produk --}}
      <div class="mt-12 text-center">
        <p class="text-rose-500 text-sm">
          Belum ada produk di etalase kamu. Yuk mulai tambahkan kue pertama kamu 🍰
        </p>
        <a
          href="{{ route('seller.products.create') }}"
          class="inline-flex mt-4 items-center gap-2 rounded-full bg-gradient-to-r from-rose-600 to-amber-400 text-white text-sm font-medium px-6 py-2.5 shadow-lg hover:scale-[1.02] transition">
          + Tambah Produk Pertama
        </a>
      </div>
    @endif

  </div>
</div>
@endsection
