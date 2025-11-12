@extends('layouts.app')
@section('title', ($meta['title'] ?? ($store->name.' — B’cake')))

@push('head')
<style>
  :root {
    --bcake-wine:#890524; 
    --bcake-deep:#57091d; 
    --bcake-cocoa:#362320;
  }
  .hero {
    background:
      radial-gradient(780px 360px at 80% -10%, rgba(255,233,240,.9), transparent 60%),
      linear-gradient(180deg,#fff,#fff8f2);
  }
  .card {
    background:#fff;
    border-radius:1rem;
    box-shadow:0 24px 48px rgba(137,5,36,.08);
    transition:.25s ease;
  }
  .card:hover {
    transform:translateY(-3px);
    box-shadow:0 28px 60px rgba(137,5,36,.12);
  }
  .btn {
    background:var(--bcake-wine);
    color:#fff;
    padding:.55rem .9rem;
    border-radius:.7rem;
    transition:.2s;
  }
  .btn:hover {
    filter:brightness(.95);
    transform:translateY(-1px);
  }
  .price-grad {
    background:linear-gradient(90deg,var(--bcake-cocoa),var(--bcake-wine));
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    font-weight:700;
  }
</style>
@endpush

@section('content')
@php
  $logo = $store->logo_url
      ?? ($store->logo ? asset('storage/'.$store->logo) : asset('image/Cake Pinky.jpg'));
  $list = isset($products) ? $products : ($store->products ?? collect());
  $backRoute = Route::has('buyer.stores.index') ? route('buyer.stores.index') : route('stores.index');
  $sort = $sort ?? request('sort','latest');
@endphp

{{-- ===== HERO HEADER ===== --}}
<div class="hero">
  <div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex flex-col md:flex-row md:items-center gap-6">
      <img src="{{ $logo }}" class="w-20 h-20 rounded-2xl object-cover ring-2 ring-rose-200/70" alt="{{ $store->name }}">
      <div class="flex-1">
        <p class="uppercase tracking-[.25em] text-xs text-rose-600/80">B’cake Store</p>
        <h1 class="text-3xl md:text-4xl font-semibold text-[var(--bcake-cocoa)]">{{ $store->name }}</h1>
        <p class="text-gray-600 mt-1">{{ $store->tagline ?? $store->description ?? 'Sweet & Elegant' }}</p>
        <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
          <span>Sejak {{ optional($store->created_at)->format('Y') ?? '—' }}</span>
          <span>•</span>
          <span>{{ $store->products_count ?? (method_exists($store,'products') ? $store->products()->count() : 0) }} produk</span>
        </div>
      </div>
      <div class="md:text-right">
        <a href="{{ $backRoute }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-rose-200/60 bg-white">
          ← Kembali ke daftar toko
        </a>
      </div>
    </div>
  </div>
</div>

{{-- ===== STORE HEADER SELLER ===== --}}
<div class="max-w-7xl mx-auto px-6 py-8">
  <div class="rounded-2xl overflow-hidden shadow p-6 bg-white flex items-center gap-4">
    <img src="{{ $logo }}" class="h-16 w-16 rounded-xl object-cover ring-1 ring-rose-200/60">
    <div>
      <h1 class="font-semibold text-lg">{{ $store->name ?? 'B’cake Seller Store' }}</h1>
      <p class="text-sm text-rose-900/70">{{ $store->tagline ?? 'Sweet & Elegant' }}</p>
    </div>
    <a href="{{ route('seller.store.edit') }}" class="ml-auto border px-3 py-1 rounded-lg text-sm hover:bg-rose-50">Edit Profil</a>
  </div>

  {{-- ===== PRODUK GRID ===== --}}
  <h2 class="mt-8 font-semibold text-lg">Produk Saya</h2>

  @php
    $fallback = [
      ['Cake Pinky',   26000, asset('image/Cake Pinky.jpg'),    url('/product/cake-pinky')],
      ['Cake Rainbow', 28000, asset('image/Cake Rainbow.jpg'),  url('/product/cake-rainbow')],
      ['Cake Pink',    32000, asset('image/Cake Pink.jpg'),     url('/product/cake-pink')],
      ['Cake Softpink',22000, asset('image/Cake Softpink.jpg'), url('/product/cake-softpink')],
    ];
  @endphp

  @if(($list instanceof \Illuminate\Support\Collection && $list->count()) || ($list instanceof \Illuminate\Pagination\AbstractPaginator && $list->count()))
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
      @foreach($list as $p)
        @php
          $img = $p->cover_url
              ?? ($p->image_url ?? null)
              ?? (isset($p->image) ? asset('storage/'.$p->image) : asset('image/Cake Pinky.jpg'));
          $to  = route('products.show', $p->slug ?? $p->id);
        @endphp
        <div class="card p-4">
          <a href="{{ $to }}">
            <img src="{{ $img }}" class="w-full h-48 object-cover rounded-xl" alt="{{ $p->name }}">
          </a>
          <div class="mt-3 flex justify-between items-start">
            <div>
              <a href="{{ $to }}" class="font-medium hover:underline line-clamp-1">{{ $p->name }}</a>
              <div class="text-rose-700 font-semibold mt-1">Rp {{ number_format($p->price ?? 0,0,',','.') }}</div>
            </div>
            <a href="{{ $to }}" class="text-xs border px-2 py-1 rounded-lg">Beli</a>
          </div>
        </div>
      @endforeach
    </div>

    @if($list instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-6">{{ $list->links() }}</div>
    @endif

  @else
    {{-- fallback jika produk kosong --}}
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
      @foreach($fallback as [$name,$price,$img,$url])
        <div class="card p-4">
          <a href="{{ $url }}">
            <img src="{{ $img }}" class="w-full h-48 object-cover rounded-xl" alt="{{ $name }}">
          </a>
          <div class="mt-3 flex justify-between items-start">
            <div>
              <a href="{{ $url }}" class="font-medium hover:underline">{{ $name }}</a>
              <div class="text-rose-700 font-semibold mt-1">Rp {{ number_format($price,0,',','.') }}</div>
            </div>
            <a href="{{ $url }}" class="text-xs border px-2 py-1 rounded-lg">Beli</a>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
