@extends('layouts.app')
@section('title', ($meta['title'] ?? (($store->name ?? 'Toko Saya').' — B’cake')))

@push('head')
<style>
  :root{ --wine:#890524; --deep:#57091d; --cocoa:#362320 }
  .hero{
    background:
      radial-gradient(780px 360px at 80% -10%, rgba(255,233,240,.9), transparent 60%),
      linear-gradient(180deg,#fff,#fff8f2);
  }
  .card{background:#fff;border-radius:1rem;box-shadow:0 24px 48px rgba(137,5,36,.08)}
  .btn{background:var(--wine);color:#fff;padding:.55rem .9rem;border-radius:.7rem;transition:.2s}
  .btn:hover{filter:brightness(.95);transform:translateY(-1px)}
  .price-grad{
    background: linear-gradient(90deg, var(--cocoa), var(--wine));
    -webkit-background-clip:text;background-clip:text;color:transparent;font-weight:700
  }
  .shadow-soft{box-shadow:0 20px 40px rgba(54,35,32,.10)}
</style>
@endpush

@section('content')
@php
  // === logo & banner toko ===
  $logo = $store->logo_url
      ?? ($store->logo ? asset('storage/'.$store->logo) : asset('image/Cake-Pinky.jpg'));

  $headerBanner = $store->banner
      ? asset('storage/'.$store->banner)
      : asset('image/Cake-Softpink.jpg');

  // === produk dari controller ===
  $list = $products ?? collect();

  $backRoute = Route::has('buyer.stores.index') ? route('buyer.stores.index') : route('stores.index');
@endphp

{{-- ================= HERO ================= --}}
<div class="hero">
  <div class="max-w-6xl mx-auto px-4 py-10">
    <div class="rounded-2xl overflow-hidden shadow-soft">
      <div class="h-44 bg-cover bg-center" style="background-image:url('{{ $headerBanner }}')"></div>
      <div class="flex items-center gap-4 p-5 bg-white">
        <img src="{{ $logo }}" class="w-16 h-16 rounded-xl object-cover ring-1 ring-rose-200/60" alt="{{ $store->name }}">
        <div class="min-w-0">
          <p class="uppercase tracking-[.25em] text-xs text-rose-600/80">B’cake Store</p>
          <h1 class="font-semibold text-xl text-[var(--cocoa)] truncate">{{ $store->name ?? 'Toko Saya' }}</h1>
          <p class="text-sm text-rose-900/70 truncate">{{ $store->tagline ?? ($store->description ?? 'Sweet & Elegant') }}</p>
        </div>
        <div class="ml-auto flex items-center gap-2">
          <a href="{{ route('seller.store.edit') }}" class="border px-3 py-1 rounded-lg text-sm hover:bg-rose-50">Edit Profil</a>
          <a href="{{ $backRoute }}" class="inline-flex items-center gap-2 px-3 py-1 rounded-lg border border-rose-200/60 bg-white text-sm">← Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ================= TOOLBAR ================= --}}
<div class="max-w-6xl mx-auto px-4">
  <div class="bg-white rounded-xl p-4 shadow-soft ring-1 ring-rose-200/40 flex flex-col sm:flex-row sm:items-center gap-4">
    <div class="text-sm text-gray-600">
      Menampilkan
      <strong>{{ $list instanceof \Illuminate\Pagination\AbstractPaginator ? $list->total() : $list->count() }}</strong>
      produk
    </div>

    <form method="get" class="sm:ml-auto flex items-center gap-2">
      @foreach(request()->except('sort','page') as $k => $v)
        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
      @endforeach
      <label for="sort" class="text-sm text-gray-600">Urutkan:</label>
      <select id="sort" name="sort" class="rounded-lg border-rose-200 bg-white h-10 px-3" onchange="this.form.submit()">
        <option value="latest"     {{ ($sort ?? request('sort','latest'))==='latest'?'selected':'' }}>Terbaru</option>
        <option value="price_asc"  {{ ($sort ?? request('sort'))==='price_asc'?'selected':'' }}>Harga termurah</option>
        <option value="price_desc" {{ ($sort ?? request('sort'))==='price_desc'?'selected':'' }}>Harga termahal</option>
      </select>
    </form>
  </div>
</div>

{{-- ================= GRID PRODUK ================= --}}
<div class="max-w-6xl mx-auto px-4 pb-8">
  @if(($list instanceof \Illuminate\Support\Collection && $list->count()) || ($list instanceof \Illuminate\Pagination\AbstractPaginator && $list->count()))
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6">
      @foreach($list as $p)
        @php
          $cover = $p->cover_url
            ?? ($p->image_url ?? null)
            ?? (isset($p->image) ? asset('storage/'.$p->image) : null)
            ?? asset('image/Cake-Pinky.jpg');
          $productLink = route('products.show', $p->slug ?? $p->id);
          $cartAddLink = route('cart.add',     $p->slug ?? $p->id);
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

    @if($list instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-8">{{ $list->links() }}</div>
    @endif

  @else
    {{-- fallback: 4 kue dari public/image (pakai tanda minus sesuai nama file kamu) --}}
    @php
      $cakes = [
        ['Cake Pinky',    26000, asset('image/Cake-Pinky.jpg'),    url('/product/cake-pinky')],
        ['Cake Rainbow',  28000, asset('image/Cake-Rainbow.jpg'),  url('/product/cake-rainbow')],
        ['Cake Pink',     32000, asset('image/Cake-Pink.jpg'),     url('/product/cake-pink')],
        ['Cake Softpink', 22000, asset('image/Cake-Softpink.jpg'), url('/product/cake-softpink')],
      ];
    @endphp

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6">
      @foreach($cakes as [$name,$price,$img,$url])
        <article class="card p-4 hover:-translate-y-0.5 transition">
          <a href="{{ $url }}">
            <img src="{{ $img }}" class="w-full h-44 object-cover rounded-lg" alt="{{ $name }}">
          </a>
          <div class="mt-3">
            <a href="{{ $url }}" class="font-medium line-clamp-1">{{ $name }}</a>
            <div class="mt-1 price-grad">Rp {{ number_format($price,0,',','.') }}</div>
            <p class="text-sm text-gray-500 line-clamp-2 mt-1">Kue manis lembut khas B’cake, rasa elegan dan lembut.</p>
          </div>
          <a href="{{ $url }}" class="btn w-full mt-3 text-center">Lihat Detail</a>
        </article>
      @endforeach
    </div>
  @endif
</div>
@endsection
