@extends('layouts.app')
@section('title','Seller Dashboard — B’cake')

@push('head')
<style>
  :root{
    --wine:#890524;--deep:#57091d;--cocoa:#362320;--gold:#c7a869;
    --petal:#ffe9f0;--cream:#fff8f2;
  }
  body{background:linear-gradient(180deg,#fff,#fff8f2);}
  .soft-card{background:#fff;border-radius:18px;box-shadow:0 18px 36px rgba(54,35,32,.10)}
  .btn{background:var(--wine);color:#fff;border-radius:999px;padding:.6rem 1.1rem;transition:.2s}
  .btn:hover{filter:brightness(.95)}
  .btn-ghost{background:#fff;border:1px solid rgba(137,5,36,.18);color:var(--deep);border-radius:999px;padding:.6rem 1.1rem}
  .chip{border:1px solid rgba(199,168,105,.45);background:linear-gradient(#fff,#fff8f2);padding:.45rem .8rem;border-radius:999px;font-size:.85rem}
  .gold-pill{border:1px dashed rgba(199,168,105,.6);background:linear-gradient(#fffdf8,#fff7ee);color:var(--deep)}
  .text-grad{background:linear-gradient(90deg,var(--cocoa),var(--wine));-webkit-background-clip:text;color:transparent}
  .stat-k{font-weight:700;font-size:1.75rem;color:var(--deep)}
  .nav-link{color:#6b6b6b}
  .nav-link.active{color:var(--deep);font-weight:600}
  .avatar{width:34px;height:34px;border-radius:999px;object-fit:cover}
</style>
@endpush

@section('content')
<div class="min-h-screen">

  {{-- ==== TOP NAV ==== --}}
  <header class="bg-white/70 backdrop-blur border-b border-rose-200/60 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-6 h-14 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="font-semibold text-[15px]" style="color:var(--deep)">
          B’cake <span class="opacity-70">Seller</span>
        </a>
        <nav class="hidden md:flex items-center gap-4 text-sm">
          <a class="nav-link {{ request()->routeIs('seller.dashboard')?'active':'' }}" href="{{ route('seller.dashboard') }}">Dashboard</a>
          <a class="nav-link" href="#">Products</a>
          <a class="nav-link" href="#">Orders</a>
          <a class="nav-link" href="#">Promos</a>
          <a class="nav-link" href="#">Settings</a>
        </nav>
      </div>

      <div class="flex items-center gap-3">
        {{-- Tombol View Store (sementara tanpa route biar gak error) --}}
        <a href="#" class="hidden sm:inline-flex btn-ghost text-sm">View Store</a>

        {{-- Tombol Logout --}}
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn text-sm">Logout</button>
        </form>

        {{-- Avatar Seller --}}
        @if(isset($seller) && ($seller->avatar ?? false))
          <img src="{{ $seller->avatar }}" class="avatar" alt="me">
        @endif
      </div>
    </div>
  </header>

  {{-- ==== HERO ==== --}}
  <section class="max-w-7xl mx-auto px-6 py-10 md:py-14 grid md:grid-cols-2 gap-10 items-center">
    <div>
      <p class="uppercase tracking-[.3em] text-xs text-[var(--gold)]">Welcome to</p>
      <h1 class="font-display text-4xl md:text-5xl leading-tight text-grad">
        {{ $store->name ?? 'Your Cute Little Bakery' }}
      </h1>
      <p class="mt-3 text-gray-600">
        Kelola etalase, promo, dan pesanan kamu di satu tempat — manis, elegan, dan cepat.
      </p>
      <div class="mt-6 flex flex-wrap gap-3">
        @foreach($categories as $c)
          <span class="chip inline-flex items-center gap-2">
            <span>{{ $c['icon'] ?? '🍰' }}</span> {{ $c['name'] ?? 'Kategori' }}
          </span>
        @endforeach
      </div>
      <div class="mt-8 flex gap-3">
        <a href="#" class="btn">Kelola Toko</a>
        <a href="#" class="gold-pill px-5 py-3 rounded-full inline-flex items-center">Lihat Pesanan</a>
      </div>
    </div>

    <div class="relative">
      <div class="absolute -top-6 -left-6 gold-pill px-4 py-2 rounded-full text-xs text-[var(--gold)] shadow">Cakes fit for Queen</div>
      <img src="{{ $store->logo_url ?? 'https://files.oaiusercontent.com/file-8f86fb16-01cb-4c1f-be0b-d40bac1488e4.jpg' }}"
           alt="Cake" class="w-full max-w-md mx-auto rounded-3xl soft-card ring-1 ring-rose-200/40">
    </div>
  </section>

  {{-- ==== STATISTICS ==== --}}
  <section class="max-w-7xl mx-auto px-6 grid sm:grid-cols-3 gap-5 mb-8">
    <div class="soft-card p-5 text-center">
      <div class="text-sm text-rose-900/70">Produk</div>
      <div class="stat-k mt-1">{{ $stats['products'] ?? 0 }}</div>
    </div>
    <div class="soft-card p-5 text-center">
      <div class="text-sm text-rose-900/70">Pesanan Bulan Ini</div>
      <div class="stat-k mt-1">{{ $stats['orders_month'] ?? 0 }}</div>
    </div>
    <div class="soft-card p-5 text-center">
      <div class="text-sm text-rose-900/70">Promo Aktif</div>
      <div class="stat-k mt-1">{{ $stats['promos'] ?? 0 }}</div>
    </div>
  </section>

  {{-- ==== PRODUK TERBARU ==== --}}
  <section class="max-w-7xl mx-auto px-6 mb-10">
    <div class="flex items-end justify-between mb-4">
      <h2 class="text-xl font-semibold text-[var(--deep)]">Produk Terbaru</h2>
      <a href="#" class="btn-ghost text-sm">Kelola Produk</a>
    </div>

    @php
      $cards = ($latestProducts ?? collect())->count()
        ? $latestProducts->map(fn($p)=>[
            'name'=>$p->name,
            'price'=>$p->price ?? 0,
            'img'=>$p->image_url ?? $p->cover_url ?? 'https://placehold.co/640x400',
            'url'=>'#',
          ])
        : collect($placeholders ?? [])->map(fn($p)=>[
            'name'=>$p['name'],
            'price'=>$p['price'],
            'img'=>$p['img'],
            'url'=>'#',
          ]);
    @endphp

    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
      @foreach($cards as $p)
        <article class="soft-card overflow-hidden group">
          <a href="{{ $p['url'] }}">
            <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}"
                 class="h-44 w-full object-cover group-hover:scale-[1.03] transition">
          </a>
          <div class="p-4">
            <h3 class="font-medium line-clamp-1">{{ $p['name'] }}</h3>
            <div class="mt-2 flex items-center justify-between">
              <span class="font-semibold text-[var(--deep)]">Rp{{ number_format($p['price'],0,',','.') }}</span>
              <a href="{{ $p['url'] }}" class="chip text-xs">Lihat Detail</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  </section>

  {{-- ==== OUR CREATIONS ==== --}}
  <section class="bg-[var(--petal)]/40 mt-10">
    <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-8 items-center">
      <div class="flex items-center gap-6">
        <img src="https://files.oaiusercontent.com/file-76da927e-9cd9-488a-9c54-786f40c65199.jpg" class="w-28 h-28 rounded-full object-cover ring-1 ring-rose-200/50" alt="">
        <img src="https://files.oaiusercontent.com/file-376dbc67-5b80-4620-9431-23ee75f037c0.jpg" class="w-40 h-40 rounded-full object-cover ring-1 ring-rose-200/50" alt="">
      </div>
      <div>
        <h3 class="font-display text-2xl text-[var(--deep)]">Our <span class="text-[var(--gold)]">Creations</span></h3>
        <p class="text-gray-600 mt-2">Tuliskan deskripsi singkat tentang bahan premium, cita rasa, dan cerita di balik kue andalanmu. Bikin pembeli jatuh cinta 💕</p>
        <div class="mt-4">
          <a href="#" class="btn">Tulis Story Produk</a>
        </div>
      </div>
    </div>
  </section>

</div>
@endsection
