@extends('layouts.seller')

@section('title','Seller Dashboard — B’cake')

@push('head')
<style>
  .hero-wrap{
    background:
      radial-gradient(1000px 420px at 82% -10%, rgba(255,233,240,.9), transparent 60%),
      linear-gradient(180deg,#fff,#fff8f2);
  }
  .hero-badge{
    border:1px dashed rgba(199,168,105,.7);
    background:linear-gradient(#fffdf8,#fff7ee);
  }
  .category-pill{
    border:1px solid rgba(199,168,105,.45);
    background:linear-gradient(#fff,#fff8f2);
  }
</style>
@endpush

@section('content')
  {{-- HERO --}}
  <section class="hero-wrap relative">
    <div class="max-w-7xl mx-auto px-4 py-10 md:py-14">
      <div class="grid md:grid-cols-2 gap-10 items-center">
        <div>
          <p class="uppercase tracking-[.3em] text-xs gold-text">Welcome to</p>
          <h1 class="font-display text-4xl md:text-5xl leading-tight text-bcake-deep">
            Our <span class="gold-text">Cute</span> Little <span class="gold-text">Bakery</span>
          </h1>
          <p class="mt-3 text-gray-600">Kelola etalase, promo, dan pesanan kamu di satu tempat. Manis, elegan, dan cepat.</p>

          <div class="mt-6 flex flex-wrap gap-3">
            @foreach($categories as $c)
              <span class="category-pill px-4 py-2 rounded-full text-sm inline-flex items-center gap-2">
                <span>{{ $c['icon'] }}</span> {{ $c['name'] }}
              </span>
            @endforeach
          </div>

          <div class="mt-8 flex gap-3">
            <a href="#" class="inline-flex items-center px-5 py-3 rounded-full text-white bg-bcake-wine shadow-soft hover:brightness-110">Buat Produk Baru</a>
            <a href="#" class="inline-flex items-center px-5 py-3 rounded-full gold-pill text-bcake-deep">Lihat Pesanan</a>
          </div>
        </div>

        {{-- gambar hero kanan (kue + macarons) --}}
        <div class="relative">
          <div class="absolute -top-6 -left-6 hero-badge px-4 py-2 rounded-full text-xs gold-text shadow">Cakes fit for Queen</div>
          <img src="{{ Vite::asset('resources/images/seller/hero-cake.png') }}"
               alt="Pink cake" class="w-full max-w-md mx-auto rounded-3xl shadow-soft ring-1 ring-rose-200/40">
        </div>
      </div>
    </div>
  </section>

  {{-- GRID “Shop by Category” (ikon besar 4 kolom) --}}
  <section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 py-10">
      <h2 class="text-center font-display text-2xl">Shop by <span class="gold-text">Category</span></h2>
      <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-5">
        @foreach($categories as $c)
          <div class="card p-5 text-center">
            <div class="h-16 w-16 mx-auto rounded-2xl bg-bcake-petal flex items-center justify-center text-2xl">{{ $c['icon'] }}</div>
            <div class="mt-3 font-medium">{{ $c['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- GRID produk (foto kotak 4 kolom, ala referensi) --}}
  <section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 pb-4">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        @forelse($products as $p)
          <article class="card overflow-hidden group">
            <img
              src="{{ $p->cover_url ?? Vite::asset('resources/images/placeholder/product.jpg') }}"
              alt="{{ $p->name }}"
              class="h-48 w-full object-cover group-hover:scale-105 transition">
            <div class="p-4">
              <h3 class="font-medium line-clamp-1">{{ $p->name }}</h3>
              <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $p->short_desc ?? '—' }}</p>
              <div class="mt-3 flex items-center justify-between">
                <span class="font-semibold text-bcake-deep">Rp{{ number_format($p->price ?? 0,0,',','.') }}</span>
                <a href="#" class="text-sm px-3 py-1 rounded-full gold-pill hover:brightness-105">Edit</a>
              </div>
            </div>
          </article>
        @empty
          <div class="col-span-2 md:col-span-4">
            <div class="card p-8 text-center">
              <p class="text-gray-600">Belum ada produk. Yuk tambah yang pertama!</p>
              <a href="#" class="inline-flex mt-4 px-5 py-3 rounded-full text-white bg-bcake-wine">Tambah Produk</a>
            </div>
          </div>
        @endforelse
      </div>

      <div class="mt-8 text-center">
        <a href="#" class="inline-flex items-center px-6 py-3 rounded-full gold-pill">Lihat Semua Produk</a>
      </div>
    </div>
  </section>

  {{-- Section “Our Creations” (teks + 2 foto bulat) --}}
  <section class="bg-bcake-petal/50">
    <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-8 items-center">
      <div class="flex items-center gap-6">
        <img src="{{ Vite::asset('resources/images/seller/stack-macarons.jpg') }}" class="w-28 h-28 rounded-full object-cover ring-1 ring-rose-200/50" alt="">
        <img src="{{ Vite::asset('resources/images/seller/mini-cake.jpg') }}" class="w-40 h-40 rounded-full object-cover ring-1 ring-rose-200/50" alt="">
      </div>
      <div>
        <h3 class="font-display text-2xl">Our <span class="gold-text">Creations</span></h3>
        <p class="text-gray-600 mt-2">Tulis deskripsi pendek, highlight bahan premium, ukuran, dan tips penyajian. Deskripsi yang jujur & estetik = konversi naik.</p>
        <div class="mt-4">
          <a href="#" class="inline-flex items-center px-5 py-3 rounded-full bg-bcake-wine text-white">Tulis Story Produk</a>
        </div>
      </div>
    </div>
  </section>
@endsection
