@extends('layouts.app')
@section('title','Toko Saya — B’cake')

@push('head')
<style>
  :root{ --wine:#890524; --deep:#57091d; --cocoa:#362320 }
  .card{background:#fff;border-radius:1rem;box-shadow:0 24px 48px rgba(137,5,36,.08)}
  .btn{background:var(--wine);color:#fff;padding:.55rem .9rem;border-radius:.7rem;transition:.2s}
  .btn:hover{filter:brightness(.95);transform:translateY(-1px)}
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
  <div class="flex items-start justify-between gap-4">
    <div class="flex items-center gap-4">
      <img src="{{ $store->logo ? asset('storage/'.$store->logo) : Vite::asset('resources/images/default-store.png') }}"
           class="w-16 h-16 rounded-xl object-cover ring-1 ring-rose-200/60" alt="{{ $store->name }}">
      <div>
        <h1 class="text-2xl font-semibold text-[var(--cocoa)]">{{ $store->name }}</h1>
        <p class="text-gray-600">{{ $store->tagline ?? $store->description ?? 'Sweet & Elegant' }}</p>
        <a href="{{ route('seller.store.edit') }}" class="inline-block mt-2 text-sm text-[var(--wine)] underline">Edit profil toko</a>
      </div>
    </div>

    <form method="get" class="hidden md:block">
      <select name="sort" class="rounded-lg border-rose-200 bg-white h-10 px-3" onchange="this.form.submit()">
        <option value="latest"     {{ $sort==='latest'?'selected':'' }}>Terbaru</option>
        <option value="price_asc"  {{ $sort==='price_asc'?'selected':'' }}>Harga termurah</option>
        <option value="price_desc" {{ $sort==='price_desc'?'selected':'' }}>Harga termahal</option>
      </select>
    </form>
  </div>

  {{-- Banner --}}
  <div class="mt-6 rounded-2xl overflow-hidden ring-1 ring-rose-200/60">
    <img src="{{ $store->banner ? asset('storage/'.$store->banner) : Vite::asset('resources/images/placeholder/banner.jpg') }}"
         class="w-full h-56 object-cover" alt="Banner toko">
  </div>

  {{-- Produk saya --}}
  <h2 class="mt-8 font-semibold text-lg">Produk Saya</h2>
  @if($products->count())
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
      @foreach($products as $p)
        <article class="card p-4 hover:-translate-y-0.5 transition">
          <a href="{{ route('products.show', $p->slug ?? $p->id) }}">
            <img src="{{ $p->cover_url ?? $p->image_url ?? (isset($p->image) ? asset('storage/'.$p->image) : Vite::asset('resources/images/placeholder/product.jpg')) }}"
                class="w-full h-44 object-cover rounded-lg" alt="{{ $p->name }}">
          </a>
          <div class="mt-3">
            <a href="{{ route('products.show', $p->slug ?? $p->id) }}" class="font-medium line-clamp-1">{{ $p->name }}</a>
            <div class="text-[var(--wine)] font-semibold mt-1">Rp {{ number_format($p->price ?? 0,0,',','.') }}</div>
          </div>
          <div class="mt-3 flex items-center gap-2">
            <a href="{{ route('products.show', $p->slug ?? $p->id) }}" class="btn flex-1 text-center">Lihat</a>
            {{-- link ke halaman kelola produk (kalau ada route seller.products.index) --}}
            @if (Route::has('seller.products.index'))
              <a href="{{ route('seller.products.index') }}" class="px-3 py-2 rounded-lg border border-rose-200/70">Kelola</a>
            @endif
          </div>
        </article>
      @endforeach
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
  @else
    <div class="mt-4 text-gray-500">Belum ada produk. Mulai tambahkan di menu <em>Produk</em>.</div>
  @endif
</div>
@endsection
