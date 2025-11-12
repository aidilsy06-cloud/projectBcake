@extends('layouts.seller')
@section('title','Seller Dashboard — B’cake')

@push('head')
<style>
  :root{
    --wine:#890524;--deep:#57091d;--cocoa:#362320;--gold:#c7a869;
    --petal:#ffe9f0;--cream:#fff8f2;
  }
  .hero-wrap{
    background:
      radial-gradient(1000px 420px at 82% -10%, rgba(255,233,240,.9), transparent 60%),
      linear-gradient(180deg,#fff,#fff8f2);
  }
  .soft-card{background:#fff;border-radius:18px;box-shadow:0 18px 36px rgba(54,35,32,.10)}
  .chip{border:1px solid rgba(199,168,105,.45);background:linear-gradient(#fff,#fff8f2);padding:.5rem .75rem;border-radius:999px;font-size:.85rem}
  .btn{background:var(--wine);color:#fff;border-radius:999px;padding:.7rem 1.1rem}
  .btn:hover{filter:brightness(.96)}
  .gold-text{color:var(--gold)}
  .gold-pill{border:1px dashed rgba(199,168,105,.7);background:linear-gradient(#fffdf8,#fff7ee);color:var(--deep)}
  .text-grad{background:linear-gradient(90deg,var(--cocoa),var(--wine));-webkit-background-clip:text;color:transparent}
</style>
@endpush

@section('content')

{{-- ===== TOP NAV BAR (kecil) ===== --}}
<div class="soft-card px-4 py-3 mb-5 flex items-center gap-5 text-sm text-rose-900/90">
  <div class="font-medium">B’cake <span class="opacity-70">Seller</span></div>
  <a href="{{ route('seller.dashboard') }}" class="hover:underline">Dashboard</a>
  <a href="{{ route('products.index') }}" class="hover:underline">Products</a>
  <a href="#" class="hover:underline">Orders</a>
  <a href="#" class="hover:underline">Promos</a>
  <a href="{{ route('seller.store.show') }}" class="hover:underline ml-auto">Lihat Toko →</a>
</div>

{{-- ===== HERO ===== --}}
<section class="hero-wrap relative">
  <div class="max-w-7xl mx-auto px-4 py-10 md:py-14">
    <div class="grid md:grid-cols-2 gap-10 items-center">
      <div>
        <p class="uppercase tracking-[.3em] text-xs gold-text">Welcome to</p>
        <h1 class="font-display text-4xl md:text-5xl leading-tight text-grad">
          Our Cute Little Bakery
        </h1>
        <p class="mt-3 text-gray-600">Kelola etalase, promo, dan pesanan kamu di satu tempat — manis, elegan, dan cepat.</p>

        <div class="mt-6 flex flex-wrap gap-3">
          @foreach($categories as $c)
            <span class="chip inline-flex items-center gap-2">
              <span>{{ $c['icon'] }}</span> {{ $c['name'] }}
            </span>
          @endforeach
        </div>

        <div class="mt-8 flex gap-3">
          <a href="{{ route('seller.store.show') }}" class="btn">Kelola Toko</a>
          <a href="#" class="gold-pill px-5 py-3 rounded-full inline-flex items-center">Lihat Pesanan</a>
        </div>
      </div>

      {{-- gambar hero kanan (pakai link fotomu) --}}
      <div class="relative">
        <div class="absolute -top-6 -left-6 gold-pill px-4 py-2 rounded-full text-xs gold-text shadow">Cakes fit for Queen</div>
        <img src="https://files.oaiusercontent.com/file-8f86fb16-01cb-4c1f-be0b-d40bac1488e4.jpg"
             alt="Pink cake" class="w-full max-w-md mx-auto rounded-3xl soft-card ring-1 ring-rose-200/40">
      </div>
    </div>
  </div>
</section>

{{-- ===== SIDEBAR TOKO + HERO KECIL ===== --}}
<div class="max-w-7xl mx-auto px-4 mt-6 grid lg:grid-cols-[1fr_320px] gap-6">
  <section class="soft-card p-6 md:p-8">
    <div class="grid sm:grid-cols-3 gap-5 text-center">
      <div>
        <div class="text-sm text-rose-900/70">Produk</div>
        <div class="text-2xl font-semibold">{{ $stats['products'] }}</div>
      </div>
      <div>
        <div class="text-sm text-rose-900/70">Pesanan</div>
        <div class="text-2xl font-semibold">{{ $stats['orders'] }}</div>
      </div>
      <div>
        <div class="text-sm text-rose-900/70">Promo</div>
        <div class="text-2xl font-semibold">{{ $stats['promos'] }}</div>
      </div>
    </div>
  </section>

  <aside class="soft-card p-5">
    <div class="flex items-center gap-3">
      <img src="https://files.oaiusercontent.com/file-ca883852-7a08-46d4-bbc0-fa6c619defea.jpg"
           class="h-12 w-12 rounded-xl object-cover ring-1 ring-rose-200/60" alt="">
      <div class="min-w-0">
        <div class="font-semibold truncate">Toko Saya</div>
        <div class="text-xs text-rose-900/70">Sweet & Elegant</div>
      </div>
    </div>
    <a href="{{ route('seller.store.show') }}" class="btn mt-4 block text-center">Lihat Toko</a>
    <a href="{{ route('seller.store.edit') }}" class="chip mt-3 block text-center">Edit Profil</a>
  </aside>
</div>

{{-- ===== SHOP BY CATEGORY ===== --}}
<section class="bg-white mt-8">
  <div class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="text-center font-display text-2xl">Shop by <span class="gold-text">Category</span></h2>
    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-5">
      @foreach($categories as $c)
        <div class="soft-card p-5 text-center">
          <div class="h-16 w-16 mx-auto rounded-2xl bg-[var(--petal)] flex items-center justify-center text-2xl">{{ $c['icon'] }}</div>
          <div class="mt-3 font-medium">{{ $c['name'] }}</div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== GRID PRODUK (fallback ke placeholders kalau kosong) ===== --}}
<section class="bg-white">
  <div class="max-w-7xl mx-auto px-4 pb-4">
    @php
      $cards = $products->count()
        ? $products->map(fn($p)=>[
            'name'=>$p->name,
            'price'=>$p->price ?? 0,
            'img'=>$p->image_url ?? $p->cover_url ?? 'https://files.oaiusercontent.com/file-ca883852-7a08-46d4-bbc0-fa6c619defea.jpg',
            'url'=> route('seller.store.show'),
          ])
        : collect($placeholders)->map(fn($p)=>[
            'name'=>$p['name'],
            'price'=>$p['price'],
            'img'=>$p['img'],
            'url'=> route('seller.store.show'),
          ]);
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
      @foreach($cards as $p)
        <article class="soft-card overflow-hidden group">
          <a href="{{ $p['url'] }}">
            <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}"
                 class="h-48 w-full object-cover group-hover:scale-[1.03] transition">
          </a>
          <div class="p-4">
            <h3 class="font-medium line-clamp-1">{{ $p['name'] }}</h3>
            <div class="mt-3 flex items-center justify-between">
              <span class="font-semibold text-[var(--deep)]">Rp{{ number_format($p['price'],0,',','.') }}</span>
              <a href="{{ route('seller.store.show') }}" class="chip text-xs">Lihat di Toko</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    <div class="mt-8 text-center">
      <a href="{{ route('seller.store.show') }}" class="gold-pill inline-flex items-center px-6 py-3 rounded-full">Lihat Semua Produk</a>
    </div>
  </div>
</section>

{{-- ===== OUR CREATIONS ===== --}}
<section class="bg-[var(--petal)]/50 mt-8">
  <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-8 items-center">
    <div class="flex items-center gap-6">
      <img src="https://files.oaiusercontent.com/file-76da927e-9cd9-488a-9c54-786f40c65199.jpg" class="w-28 h-28 rounded-full object-cover ring-1 ring-rose-200/50" alt="">
      <img src="https://files.oaiusercontent.com/file-376dbc67-5b80-4620-9431-23ee75f037c0.jpg" class="w-40 h-40 rounded-full object-cover ring-1 ring-rose-200/50" alt="">
    </div>
    <div>
      <h3 class="font-display text-2xl">Our <span class="gold-text">Creations</span></h3>
      <p class="text-gray-600 mt-2">Tulis deskripsi pendek: highlight bahan premium, ukuran, dan tips penyajian. Estetik & jelas = konversi naik.</p>
      <div class="mt-4">
        <a href="{{ route('seller.store.edit') }}" class="btn">Tulis Story Produk</a>
      </div>
    </div>
  </div>
</section>

@endsection
