@extends('layouts.app')
@section('title', ($store->name ?? 'Toko Saya').' — B’cake')

@push('head')
<style>
  :root{ --wine:#890524; --deep:#57091d; --cocoa:#362320 }
  .shadow-soft{box-shadow:0 20px 40px rgba(54,35,32,.10)}
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

  {{-- ================= HEADER (Banner + Profil Singkat) ================= --}}
  @php
    // Fallback LINK kalau banner/logo toko belum diisi
    $fallbackBanner = 'https://files.oaiusercontent.com/file-376dbc67-5b80-4620-9431-23ee75f037c0.jpg';
    $fallbackLogo   = 'https://files.oaiusercontent.com/file-8f86fb16-01cb-4c1f-be0b-d40bac1488e4.jpg';

    $bannerUrl = isset($store) && $store?->banner
      ? asset('storage/'.$store->banner)
      : $fallbackBanner;

    $logoUrl = isset($store) && $store?->logo
      ? asset('storage/'.$store->logo)
      : $fallbackLogo;

    $storeName = $store->name ?? 'Toko Saya';
    $storeTag  = $store->tagline ?? ($store->description ?? 'Sweet & Elegant');
  @endphp

  <div class="rounded-2xl overflow-hidden shadow-soft">
    <div class="h-44 bg-cover bg-center"
         style="background-image:url('{{ $bannerUrl }}')"></div>

    <div class="flex items-center gap-4 p-5 bg-white">
      <img src="{{ $logoUrl }}"
           alt="{{ $storeName }}"
           class="h-16 w-16 rounded-xl object-cover ring-1 ring-rose-200/60">
      <div class="min-w-0">
        <h1 class="font-semibold text-lg truncate">{{ $storeName }}</h1>
        <p class="text-sm text-rose-900/70 truncate">{{ $storeTag }}</p>
      </div>
      <a href="{{ route('seller.store.edit') }}"
         class="ml-auto border px-3 py-1 rounded-lg text-sm hover:bg-rose-50">
        Edit Profil
      </a>
    </div>
  </div>

  {{-- ================= FILTER BAR ================= --}}
  <div class="mt-6 flex items-center justify-between">
    <h2 class="font-semibold text-lg">Produk Saya</h2>
    <form method="get" class="hidden md:block">
      <select name="sort" class="rounded-lg border-rose-200 bg-white h-10 px-3" onchange="this.form.submit()">
        <option value="latest"     {{ ($sort ?? 'latest')==='latest'?'selected':'' }}>Terbaru</option>
        <option value="price_asc"  {{ ($sort ?? '')==='price_asc'?'selected':'' }}>Harga termurah</option>
        <option value="price_desc" {{ ($sort ?? '')==='price_desc'?'selected':'' }}>Harga termahal</option>
      </select>
    </form>
  </div>

  {{-- ================= GRID PRODUK ================= --}}
  @php
    // Placeholder 4 kue pakai LINK yang kamu minta
    $cakes = [
      ['name'=>'Cake Pinky',   'price'=>26000,'img'=>'https://files.oaiusercontent.com/file-8f86fb16-01cb-4c1f-be0b-d40bac1488e4.jpg'],
      ['name'=>'Cake Rainbow', 'price'=>28000,'img'=>'https://files.oaiusercontent.com/file-76da927e-9cd9-488a-9c54-786f40c65199.jpg'],
      ['name'=>'Cake Pink',    'price'=>32000,'img'=>'https://files.oaiusercontent.com/file-ca883852-7a08-46d4-bbc0-fa6c619defea.jpg'],
      ['name'=>'Cake Softpink','price'=>22000,'img'=>'https://files.oaiusercontent.com/file-376dbc67-5b80-4620-9431-23ee75f037c0.jpg'],
    ];
  @endphp

  @if(isset($products) && $products->count())
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
      @foreach($products as $p)
        @php
          $img = $p->cover_url
               ?? $p->image_url
               ?? (isset($p->image) ? asset('storage/'.$p->image) : 'https://files.oaiusercontent.com/file-ca883852-7a08-46d4-bbc0-fa6c619defea.jpg');
          $showUrl = route('products.show', $p->slug ?? $p->id);
        @endphp

        <article class="bg-white rounded-2xl shadow-soft p-4 hover:-translate-y-0.5 transition">
          <a href="{{ $showUrl }}">
            <img src="{{ $img }}" alt="{{ $p->name }}" class="w-full h-48 object-cover rounded-xl">
          </a>
          <div class="mt-3 flex justify-between items-start gap-3">
            <div class="min-w-0">
              <a href="{{ $showUrl }}" class="font-medium line-clamp-1">{{ $p->name }}</a>
              <div class="text-[var(--wine)] font-semibold mt-1">
                Rp {{ number_format($p->price ?? 0,0,',','.') }}
              </div>
            </div>
            <a href="{{ $showUrl }}" class="text-xs border px-2 py-1 rounded-lg whitespace-nowrap">Lihat</a>
          </div>
        </article>
      @endforeach
    </div>

    {{-- paginate kalau controller kasih pagination --}}
    @if(method_exists($products, 'links'))
      <div class="mt-6">{{ $products->links() }}</div>
    @endif

  @else
    {{-- Fallback pakai 4 kue LINK --}}
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
      @foreach($cakes as $c)
        <div class="bg-white rounded-2xl shadow-soft p-4">
          <img src="{{ $c['img'] }}" alt="{{ $c['name'] }}" class="w-full h-48 object-cover rounded-xl">
          <div class="mt-3 flex justify-between items-start gap-3">
            <div>
              <div class="font-medium">{{ $c['name'] }}</div>
              <div class="text-[var(--wine)] font-semibold mt-1">
                Rp {{ number_format($c['price'],0,',','.') }}
              </div>
            </div>
            <a href="#" class="text-xs border px-2 py-1 rounded-lg whitespace-nowrap">Beli</a>
          </div>
        </div>
      @endforeach
    </div>
  @endif

</div>
@endsection
