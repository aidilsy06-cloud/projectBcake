@extends('layouts.app')

@section('title','Dashboard Pembeli — B’cake')

@push('head')
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
  }
  /* latar halus dengan gradiasi lembut */
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }
  /* gradiasi utama khas B’cake */
  .bg-bcake-grad{
    background: linear-gradient(135deg, var(--bcake-deep) 0%, var(--bcake-wine) 55%, var(--bcake-cocoa) 100%);
  }
  /* kartu dengan gradiasi lembut */
  .card-soft{
    background: linear-gradient(145deg, #fff, #fff6f7 60%, #ffecef 100%);
  }
  .shadow-soft{box-shadow:0 18px 40px rgba(54,35,32,.10)}
  .ring-soft{box-shadow:inset 0 0 0 1px rgba(244, 63, 94, .25)}
  .text-bcake-grad{
    background: linear-gradient(90deg, var(--bcake-cocoa), var(--bcake-wine));
    -webkit-background-clip:text;background-clip:text;color:transparent;
  }

  /* ====== Layout fixed sidebar (desktop ≥1024px) ====== */
  @media (min-width: 1024px){
    .dash-shell{ --sbw: 320px; /* lebar sidebar */ }
    .dash-shell{ padding-left: calc(var(--sbw) + 28px); } /* ruang konten kanan + gap 28px */
    .dash-aside{
      width: var(--sbw);
      position: fixed;
      left: 16px;
      top: 96px;
      bottom: 24px;
      overflow: auto;
      z-index: 40;
    }
  }
</style>
@endpush

@section('content')
<div class="page-bg min-h-[calc(100vh-4rem)]">
  {{-- Shell: atur padding-left agar konten geser saat sidebar fixed --}}
  <div class="dash-shell mx-auto px-4 lg:px-10 py-8 max-w-[1200px] xl:max-w-[1360px] 2xl:max-w-[1440px]">

    {{-- ============ SIDEBAR (fixed on desktop) ============ --}}
    <aside class="dash-aside bg-white rounded-2xl shadow-soft ring-soft p-5">
      <div class="flex items-center gap-3 mb-4">
        <img src="{{ asset('image/cake.jpg') }}" class="h-12 w-12 rounded-xl object-cover" alt="Logo B’cake">
        <div>
          <div class="font-semibold text-bcake-grad">B’cake</div>
          <div class="text-xs text-gray-500">Sweet & Elegant</div>
        </div>
      </div>

      <nav class="space-y-2">
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-rose-50 focus:bg-rose-50 focus:outline-none">
          🏠 Home
        </a>
        <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-rose-50 focus:bg-rose-50 focus:outline-none">
          🧁 Produk
        </a>

        {{-- MENU TOKO (PUBLIK) --}}
        <a href="{{ route('stores.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-rose-50 focus:bg-rose-50 focus:outline-none">
          🏪 Toko
        </a>

        <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-rose-50 focus:bg-rose-50 focus:outline-none">
          🧺 Keranjang
        </a>

        {{-- Bantuan: pakai versi buyer kalau ada, fallback ke publik --}}
        @if (Route::has('buyer.help'))
          <a href="{{ route('buyer.help') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-rose-50 focus:bg-rose-50 focus:outline-none">
            🆘 Bantuan
          </a>
        @else
          <a href="{{ route('help') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-rose-50 focus:bg-rose-50 focus:outline-none">
            🆘 Bantuan
          </a>
        @endif
      </nav>

      <div class="mt-6 p-5 rounded-2xl bg-bcake-grad text-white shadow-soft">
        <div class="text-sm opacity-95">Undang teman & dapatkan</div>
        <div class="text-2xl font-bold mt-1">Diskon 15%</div>
        <a href="#" class="mt-3 inline-flex items-center gap-2 bg-white text-[var(--bcake-wine)] px-3 py-1.5 rounded-xl text-sm hover:brightness-95 focus:outline-none">
          Dapatkan Kode →
        </a>
      </div>

      <form method="POST" action="{{ route('logout') }}" class="mt-6">@csrf
        <button class="w-full px-3 py-2 rounded-xl bg-rose-100 text-rose-700 hover:bg-rose-200 focus:outline-none">
          ↩ Log out
        </button>
      </form>
    </aside>

    {{-- ============ MAIN ============ --}}
    <main class="space-y-8">
      {{-- TOP BAR --}}
      <div class="bg-white rounded-2xl shadow-soft ring-soft p-4 flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="inline-flex bg-rose-100 text-rose-700 px-2 py-1 rounded-full text-xs font-medium w-max">
          Dashboard
        </div>
        <form action="{{ route('products.index') }}" class="sm:ml-auto w-full" method="get">
          <div class="relative">
            <input name="q" placeholder="Search cakes…" class="w-full rounded-xl border-rose-200 bg-white px-4 h-11 focus:ring-2 focus:ring-rose-300 focus:outline-none"/>
            <button class="absolute right-2 top-1/2 -translate-y-1/2 text-[var(--bcake-wine)]" aria-label="Cari">🔎</button>
          </div>
        </form>
        <div class="h-11 w-11 rounded-xl bg-bcake-grad ring-2 ring-white ml-auto sm:ml-0"></div>
      </div>

      {{-- HERO + PRODUK --}}
      <div class="grid md:grid-cols-3 gap-8">
        <div class="rounded-3xl bg-bcake-grad text-white p-8 min-h-[260px] flex flex-col justify-between shadow-soft">
          <div class="text-sm opacity-90">Promo Minggu Ini</div>
          <div class="text-3xl font-bold mt-2 leading-tight">GET UP TO 30% OFF SHORTS</div>
          <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center gap-2 bg-white text-[var(--bcake-wine)] px-5 py-2.5 rounded-xl font-medium w-max hover:brightness-95 focus:outline-none">
            Belanja Sekarang →
          </a>
        </div>

        {{-- kartu produk 1 --}}
        <div class="rounded-3xl card-soft p-5 shadow-soft ring-soft hover:-translate-y-0.5 transition">
          <div class="aspect-[4/3] md:aspect-[16/10] rounded-2xl overflow-hidden mb-4 bg-white">
            <img src="{{ asset('image/cake.jpg') }}" alt="Signature Cake" class="w-full h-full object-cover">
          </div>
          <div class="flex items-start justify-between">
            <div>
              <div class="font-semibold">Signature Cake</div>
              <div class="text-sm text-gray-500">Best Seller</div>
            </div>
            <div class="text-right">
              <div class="text-xs line-through text-gray-400">Rp96.000</div>
              <div class="font-bold text-bcake-grad">Rp78.000</div>
            </div>
          </div>
        </div>

        {{-- kartu produk 2 --}}
        <div class="rounded-3xl card-soft p-5 shadow-soft ring-soft hover:-translate-y-0.5 transition">
          <div class="aspect-[4/3] md:aspect-[16/10] rounded-2xl overflow-hidden mb-4 bg-white">
            <img src="{{ asset('image/lovecake.jpg') }}" alt="Love Cake" class="w-full h-full object-cover">
          </div>
          <div class="flex items-start justify-between">
            <div>
              <div class="font-semibold">Love Cake</div>
              <div class="text-sm text-gray-500">New</div>
            </div>
            <div class="text-right">
              <div class="text-xs line-through text-gray-400">Rp92.000</div>
              <div class="font-bold text-bcake-grad">Rp82.000</div>
            </div>
          </div>
        </div>
      </div>

      {{-- ============ TOKO POPULER (BARU DITAMBAH) ============ --}}
      <section class="bg-white rounded-2xl shadow-soft ring-soft p-6">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold">Toko Populer</h3>

          {{-- Tombol ke halaman semua toko --}}
          <a href="{{ route('stores.index') }}"
             class="text-sm px-3 py-1.5 rounded-full border border-rose-200/60 bg-white hover:bg-rose-50">
            Lihat Semua →
          </a>
        </div>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
          @php
            // aman walau controller belum kirim $stores
            $storesSafe = collect($stores ?? [])->take(8);
          @endphp

          @forelse($storesSafe as $s)
            <article class="rounded-2xl p-4 card-soft shadow-soft ring-soft">
              <div class="flex items-center gap-3">
                <img
                  src="{{ $s->logo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($s->name).'&background=ffe9f0&color=890524' }}"
                  class="h-12 w-12 rounded-xl object-cover ring-1 ring-rose-200/60" alt="">
                <div>
                  <div class="font-medium line-clamp-1">{{ $s->name }}</div>
                  <div class="text-xs text-gray-500 line-clamp-1">{{ $s->tagline ?? 'Sweet & Elegant' }}</div>
                </div>
              </div>
              <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-gray-500">
                  {{ $s->products_count ?? ($s->products_count ?? '-') }} produk
                </span>
                @if (Route::has('stores.show'))
                  {{-- jika pakai slug binding {store:slug}, cukup kirim $s --}}
                  <a href="{{ route('stores.show', $s->slug ?? $s) }}"
                     class="inline-flex items-center px-3 py-1.5 rounded-full bg-bcake-grad text-white text-sm hover:brightness-110">
                    Kunjungi
                  </a>
                @endif
              </div>
            </article>
          @empty
            <div class="col-span-full text-center text-gray-500 py-6">
              Belum ada toko untuk ditampilkan.
            </div>
          @endforelse
        </div>
      </section>

      {{-- ARTICLES + ORDERS --}}
      <div class="grid lg:grid-cols-3 gap-8">
        <section class="bg-white rounded-2xl shadow-soft ring-soft p-6 lg:col-span-2">
          <div class="flex items-center justify-between">
            <h3 class="font-semibold">Our Articles</h3>
            <div class="flex gap-2 text-xs">
              <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700">New</span>
              <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700">Best</span>
              <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700">Archive</span>
            </div>
          </div>
          <div class="mt-4 grid md:grid-cols-[140px,1fr] gap-4">
            <img src="{{ asset('image/cake.jpg') }}" class="h-32 w-32 object-cover rounded-xl" alt="Artikel B’cake">
            <div>
              <div class="font-medium">The Best Fashion Instagrams of the Week (Dessert Edition)</div>
              <p class="text-sm text-gray-600 mt-1 line-clamp-2">Tekstur lembut dan kombinasi rasa manis-elegan khas B’cake.</p>
              <a href="#" class="text-sm text-[var(--bcake-wine)] mt-2 inline-flex items-center gap-1 hover:underline">Read more →</a>
            </div>
          </div>
        </section>

        <section class="bg-white rounded-2xl shadow-soft ring-soft p-6">
          <h3 class="font-semibold mb-3">Latest Orders</h3>
          <div class="overflow-hidden rounded-xl ring-1 ring-rose-200/60">
            <table class="w-full text-sm">
              <thead class="bg-rose-50 text-gray-600">
                <tr>
                  <th class="text-left px-3 py-2">ID</th>
                  <th class="text-left px-3 py-2">Items</th>
                  <th class="text-left px-3 py-2">Date</th>
                  <th class="text-right px-3 py-2">Amount</th>
                </tr>
              </thead>
              <tbody>
                @forelse(($orders ?? []) as $o)
                  <tr class="border-t">
                    <td class="px-3 py-2">{{ $o->code }}</td>
                    <td class="px-3 py-2">{{ $o->items_count }} item</td>
                    <td class="px-3 py-2">{{ $o->created_at->format('d/m/Y') }}</td>
                    <td class="px-3 py-2 text-right">@money($o->total)</td>
                  </tr>
                @empty
                  <tr><td colspan="4" class="px-3 py-6 text-center text-gray-500">Belum ada pesanan.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>
      </div>

    </main>
  </div>
</div>
@endsection
