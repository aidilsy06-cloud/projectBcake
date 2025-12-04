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

  .shadow-soft{
    box-shadow:0 22px 44px rgba(137,5,36,.08);
  }

  .card {
    background:#fff;
    border-radius:1.25rem;
    box-shadow:0 18px 40px rgba(137,5,36,.06);
    transition:.25s ease;
  }
  .card:hover {
    transform:translateY(-3px);
    box-shadow:0 26px 60px rgba(137,5,36,.13);
  }

  .btn-primary {
    background:var(--bcake-wine);
    color:#fff;
    padding:.55rem 1rem;
    border-radius:999px;
    font-size:.85rem;
    font-weight:600;
    transition:.2s;
  }
  .btn-primary:hover {
    filter:brightness(.96);
    transform:translateY(-1px);
  }

  .btn-soft {
    border-radius:999px;
    border:1px solid rgba(244,63,94,.25);
    background:#fff;
    padding:.5rem 1rem;
    font-size:.8rem;
    transition:.2s;
  }
  .btn-soft:hover {
    background:#fff1f2;
  }

  .price-grad {
    background:linear-gradient(90deg,var(--bcake-cocoa),var(--bcake-wine));
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    font-weight:700;
  }

  .pill {
    display:inline-flex;
    align-items:center;
    gap:.25rem;
    border-radius:999px;
    padding:.2rem .65rem;
    font-size:.7rem;
    background:#fff;
    border:1px solid rgba(248,113,113,.25);
    color:rgba(127,29,29,.9);
  }
</style>
@endpush

@section('content')
@php
  // fallback logo
  $logo = $store->logo_url
      ?? ($store->logo ? asset('storage/'.$store->logo) : asset('image/Cake-Pinky.jpg'));

  $list = isset($products) ? $products : ($store->products ?? collect());

  $backRoute = Route::has('buyer.stores.index')
      ? route('buyer.stores.index')
      : route('stores.index');

  $sort = $sort ?? request('sort','latest');
@endphp

<div class="bg-rose-50/60">
  <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-10 space-y-8">

    {{-- ================= HERO HEADER ================= --}}
    <section class="hero rounded-3xl shadow-soft border border-rose-100/80 px-5 md:px-8 py-7 md:py-9">
      <div class="flex flex-col md:flex-row md:items-center gap-6 md:gap-8">
        {{-- Logo --}}
        <div class="shrink-0">
          <img
            src="{{ $logo }}"
            class="w-20 h-20 md:w-24 md:h-24 rounded-2xl object-cover ring-2 ring-rose-200/70 bg-white"
            alt="{{ $store->name }}">
        </div>

        {{-- Info utama --}}
        <div class="flex-1 space-y-2">
          <p class="uppercase tracking-[.25em] text-[0.65rem] text-rose-600/80">
            B’cake Store
          </p>
          <h1 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-[var(--bcake-cocoa)] leading-tight">
            {{ $store->name }}
          </h1>
          <p class="text-sm md:text-base text-gray-700 max-w-2xl">
            {{ $store->tagline ?? $store->description ?? 'Sweet & Elegant — kue segar untuk setiap momen spesial.' }}
          </p>

          <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
            <div class="pill">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
              Sweet &amp; Elegant
            </div>
            <span>
              Sejak {{ optional($store->created_at)->format('Y') ?? '—' }}
            </span>
            <span>•</span>
            <span>
              {{ $store->products_count ?? (method_exists($store,'products') ? $store->products()->count() : 0) }} produk
            </span>
          </div>
        </div>

        {{-- Tombol kembali --}}
        <div class="md:text-right">
          <a href="{{ $backRoute }}" class="btn-soft inline-flex items-center gap-2">
            ← Kembali ke daftar toko
          </a>
        </div>
      </div>
    </section>

    {{-- ================= HEADER SELLER / PROFIL SINGKAT ================= --}}
    <section class="rounded-3xl bg-white shadow-soft border border-rose-100/80 px-5 py-4 flex items-center gap-4">
      <img
        src="{{ $logo }}"
        class="h-14 w-14 rounded-2xl object-cover ring-1 ring-rose-200/60 bg-rose-50"
        alt="{{ $store->name }}">
      <div>
        <h2 class="font-semibold text-base md:text-lg text-[var(--bcake-cocoa)]">
          {{ $store->name ?? 'B’cake Seller Store' }}
        </h2>
        <p class="text-xs md:text-sm text-rose-900/70">
          {{ $store->tagline ?? 'Sweet & Elegant' }}
        </p>
      </div>

      <div class="ml-auto flex items-center gap-3">
        <span class="hidden sm:inline-flex pill">
          ⭐ Belanja aman &amp; nyaman di B’cake
        </span>

        <a href="{{ route('seller.store.edit') }}"
           class="btn-soft text-xs md:text-sm">
          Edit profil toko
        </a>
      </div>
    </section>

    {{-- ================= PRODUK DARI TOKO INI ================= --}}
    <section class="space-y-4">
      <div class="flex items-center justify-between gap-3">
        <div>
          <h3 class="font-semibold text-lg text-[var(--bcake-cocoa)]">
            Produk dari {{ $store->name }}
          </h3>
          <p class="text-xs md:text-sm text-rose-800/80">
            Koleksi kue pilihan dari {{ $store->name }}.
          </p>
        </div>

        @if(Route::has('seller.products.create'))
          <a href="{{ route('seller.products.create') }}" class="hidden sm:inline-flex btn-primary items-center gap-1">
            + Tambah produk
          </a>
        @endif
      </div>

      @php
        $fallback = [
          ['Cake Pinky',    26000, asset('image/Cake-Pinky.jpg'),    url('/product/cake-pinky')],
          ['Cake Rainbow',  28000, asset('image/Cake-Rainbow.jpg'),  url('/product/cake-rainbow')],
          ['Cake Pink',     32000, asset('image/Cake-Pink.jpg'),     url('/product/cake-pink')],
          ['Cake Softpink', 22000, asset('image/Cake-Softpink.jpg'), url('/product/cake-softpink')],
        ];
      @endphp

      @if(
        ($list instanceof \Illuminate\Support\Collection && $list->count()) ||
        ($list instanceof \Illuminate\Pagination\AbstractPaginator && $list->count())
      )
        {{-- ==== GRID PRODUK ASLI ==== --}}
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-2">
          @foreach($list as $p)
            @php
                // ambil path gambar mentah
                $raw = $p->image_url
                    ?? $p->cover_url
                    ?? $p->photo
                    ?? $p->image
                    ?? null;

                $debugRaw = $raw;

                if ($raw) {
                    $raw = ltrim($raw, '/');

                    if (substr($raw, 0, 4) === 'http') {
                        // URL penuh (Unsplash, dll)
                        $img = $raw;
                    } elseif (strpos($raw, 'storage/') === 0) {
                        // sudah diawali "storage/"
                        $img = asset($raw);
                    } else {
                        // contoh di DB: "products/xxx.png" → "/storage/products/xxx.png"
                        $img = asset('storage/'.$raw);
                    }
                } else {
                    // placeholder kalau belum ada gambar
                    $img = asset('image/Cake-Pinky.jpg');
                }

                $to  = route('products.show', $p->slug ?? $p->id);
            @endphp

            <article class="card p-4 flex flex-col">
              <a href="{{ $to }}" class="block overflow-hidden rounded-xl">
                <img src="{{ $img }}"
                     class="w-full h-44 md:h-48 object-cover rounded-xl transition duration-300 hover:scale-105"
                     alt="{{ $p->name }}">
              </a>

              <div class="mt-3 flex-1 flex flex-col gap-2">
                <a href="{{ $to }}" class="font-medium text-[var(--bcake-cocoa)] text-sm md:text-[0.95rem] hover:underline line-clamp-1">
                  {{ $p->name }}
                </a>

                <div class="price-grad text-sm md:text-base">
                  Rp {{ number_format($p->price ?? 0,0,',','.') }}
                </div>

                {{-- DEBUG: tampilkan path mentah dan path final --}}
                <span class="text-[10px] text-gray-400 break-all">
                  raw: {{ $debugRaw ?? 'null' }}
                </span>
                <span class="text-[10px] text-gray-400 break-all">
                  src: {{ $img }}
                </span>

                <div class="mt-1 flex items-center justify-between gap-2">
                  <span class="text-[0.7rem] text-rose-500/80">
                    {{ $store->name }}
                  </span>

                  <a href="{{ $to }}"
                     class="text-[0.7rem] md:text-xs border border-rose-200 px-3 py-1 rounded-full text-[var(--bcake-wine)] bg-rose-50 hover:bg-[var(--bcake-wine)] hover:text-white transition">
                    Beli
                  </a>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        @if($list instanceof \Illuminate\Pagination\AbstractPaginator)
          <div class="mt-6">
            {{ $list->links() }}
          </div>
        @endif
      @else
        {{-- ==== EMPTY STATE / FALLBACK ==== --}}
        <div class="rounded-3xl border border-dashed border-rose-200 bg-white/60 px-6 py-10 text-center mb-4">
          <p class="text-sm font-medium text-rose-700">
            Belum ada produk yang ditambahkan.
          </p>
          <p class="text-xs text-rose-600 mt-1">
            Tambahkan beberapa kue favoritmu agar etalase toko terlihat lebih hidup.
          </p>

          @if(Route::has('seller.products.create'))
            <a href="{{ route('seller.products.create') }}" class="mt-4 inline-flex btn-primary">
              + Tambah produk pertama
            </a>
          @endif
        </div>

        <h4 class="text-xs uppercase tracking-[.2em] text-rose-500 mb-1">
          Inspirasi etalase (dummy)
        </h4>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-2">
          @foreach($fallback as [$name,$price,$img,$url])
            <article class="card p-4 flex flex-col">
              <a href="{{ $url }}" class="block overflow-hidden rounded-xl">
                <img src="{{ $img }}"
                     class="w-full h-44 md:h-48 object-cover rounded-xl"
                     alt="{{ $name }}">
              </a>
              <div class="mt-3 flex-1 flex flex-col gap-2">
                <a href="{{ $url }}" class="font-medium text-[var(--bcake-cocoa)] text-sm md:text-[0.95rem] hover:underline">
                  {{ $name }}
                </a>
                <div class="price-grad text-sm md:text-base">
                  Rp {{ number_format($price,0,',','.') }}
                </div>
                <div class="mt-1 flex items-center justify-between gap-2">
                  <span class="text-[0.7rem] text-rose-500/80">
                    Contoh produk
                  </span>
                  <a href="{{ $url }}"
                     class="text-[0.7rem] md:text-xs border border-rose-200 px-3 py-1 rounded-full text-[var(--bcake-wine)] bg-rose-50">
                    Lihat
                  </a>
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
