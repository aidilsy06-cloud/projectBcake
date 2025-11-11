@extends('layouts.app')
@section('title', ($meta['title'] ?? ($store->name.' — B’cake')))

@push('head')
<style>
  :root{ --bcake-wine:#890524; --bcake-deep:#57091d; --bcake-cocoa:#362320 }
  .hero{
    background:
      radial-gradient(780px 360px at 80% -10%, rgba(255,233,240,.9), transparent 60%),
      linear-gradient(180deg,#fff,#fff8f2);
  }
  .card{background:#fff;border-radius:1rem;box-shadow:0 24px 48px rgba(137,5,36,.08)}
  .btn{background:var(--bcake-wine);color:#fff;padding:.55rem .9rem;border-radius:.7rem;transition:.2s}
  .btn:hover{filter:brightness(.95);transform:translateY(-1px)}
  .price-grad{
    background: linear-gradient(90deg, var(--bcake-cocoa), var(--bcake-wine));
    -webkit-background-clip:text;background-clip:text;color:transparent;font-weight:700
  }
</style>
@endpush

@section('content')
@php
  // Aman untuk image fallback
  $logo = $store->logo_url
      ?? ($store->logo ?? null ? asset('storage/'.$store->logo) : Vite::asset('resources/images/default-store.png'));

  // produk: dukung $products (paginasi dari controller) atau $store->products (tanpa paginasi)
  $list = isset($products) ? $products : ($store->products ?? collect());

  // route "kembali": pilih buyer.stores.index jika ada, kalau tidak pakai publik stores.index
  $backRoute = Route::has('buyer.stores.index') ? route('buyer.stores.index') : route('stores.index');

  // nilai sort aktif (jika controller mengirim)
  $sort = $sort ?? request('sort','latest');
@endphp

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

<div class="max-w-6xl mx-auto px-4 py-8">
  {{-- BAR TOOLS: sort + info jumlah --}}
  <div class="bg-white rounded-xl p-4 shadow-sm ring-1 ring-rose-200/40 flex flex-col sm:flex-row sm:items-center gap-4">
    <div class="text-sm text-gray-600">
      Menampilkan
      <strong>{{ $list instanceof \Illuminate\Pagination\AbstractPaginator ? $list->total() : $list->count() }}</strong>
      produk{{ $list instanceof \Illuminate\Pagination\AbstractPaginator ? '' : ' (tanpa paginasi)' }}
    </div>

    {{-- FORM SORT --}}
    <form method="get" class="sm:ml-auto flex items-center gap-2">
      @foreach(request()->except('sort','page') as $k => $v)
        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
      @endforeach
      <label for="sort" class="text-sm text-gray-600">Urutkan:</label>
      <select id="sort" name="sort" class="rounded-lg border-rose-200 bg-white h-10 px-3" onchange="this.form.submit()">
        <option value="latest"     {{ $sort==='latest'?'selected':'' }}>Terbaru</option>
        <option value="price_asc"  {{ $sort==='price_asc'?'selected':'' }}>Harga termurah</option>
        <option value="price_desc" {{ $sort==='price_desc'?'selected':'' }}>Harga termahal</option>
      </select>
    </form>
  </div>

  {{-- GRID PRODUK --}}
  @if(($list instanceof \Illuminate\Support\Collection && $list->count()) || ($list instanceof \Illuminate\Pagination\AbstractPaginator && $list->count()))
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6">
      @foreach($list as $p)
        @php
          // cover product fallback
          $cover = $p->cover_url
            ?? ($p->image_url ?? null)
            ?? (isset($p->image) ? asset('storage/'.$p->image) : null)
            ?? Vite::asset('resources/images/placeholder/product.jpg');

          // link produk: utamakan slug
          $productLink = route('products.show', $p->slug ?? $p->id);
          // link add cart: nama rute cart.add sudah ada di web.php
          $cartAddLink = route('cart.add', $p->slug ?? $p->id);
        @endphp

        <article class="card p-4 hover:-translate-y-0.5 transition">
          <a href="{{ $productLink }}">
            <img src="{{ $cover }}" class="w-full h-44 object-cover rounded-lg" alt="{{ $p->name }}">
          </a>

          <div class="mt-3">
            <a href="{{ $productLink }}" class="font-medium line-clamp-1">{{ $p->name }}</a>
            <div class="mt-1 price-grad">Rp {{ number_format($p->price ?? 0,0,',','.') }}</div>
            @if(!empty($p->short_desc))
              <p class="text-sm text-gray-500 line-clamp-2 mt-1">{{ $p->short_desc }}</p>
            @endif
          </div>

          <form method="post" action="{{ $cartAddLink }}" class="mt-3">
            @csrf
            <button class="btn w-full">Tambah ke Keranjang</button>
          </form>
        </article>
      @endforeach
    </div>

    {{-- PAGINASI (kalau $products dikirim sebagai paginator dari controller) --}}
    @if($list instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-8">{{ $list->links() }}</div>
    @endif
  @else
    <div class="text-gray-500 mt-6">Belum ada produk di toko ini.</div>
  @endif
</div>
@endsection
