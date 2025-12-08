@extends('layouts.app')

@section('title', ($product->name ?? 'Detail Produk').' — B’cake')

@push('head')
<style>
  :root {
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
  }

  body{
    background:#ffeef6;
  }

  .detail-shell{
    max-width:72rem;
    margin:0 auto;
    padding:2.5rem 1.25rem 3.5rem;
  }

  .detail-card{
    background:#fff;
    border-radius:1.75rem;
    box-shadow:0 22px 55px rgba(137,5,36,.12);
    border:1px solid rgba(248,113,150,.18);
    padding:1.75rem 1.5rem;
  }

  @media (min-width:768px){
    .detail-card{
      padding:2.25rem 2rem;
    }
  }

  .pill{
    display:inline-flex;
    align-items:center;
    gap:.25rem;
    border-radius:999px;
    padding:.2rem .7rem;
    font-size:.7rem;
    background:#fff5f7;
    border:1px solid rgba(248,113,150,.4);
    color:#b91c1c;
  }

  .btn-primary{
    background:var(--bcake-wine);
    color:#fff;
    border-radius:999px;
    padding:.65rem 1.4rem;
    font-size:.9rem;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:.5rem;
    transition:.2s;
  }
  .btn-primary:hover{
    filter:brightness(.96);
    transform:translateY(-1px);
  }

  .btn-soft{
    background:#fff;
    border-radius:999px;
    padding:.55rem 1.1rem;
    border:1px solid rgba(248,113,150,.3);
    font-size:.8rem;
    display:inline-flex;
    align-items:center;
    gap:.4rem;
    transition:.2s;
  }
  .btn-soft:hover{
    background:#fff1f2;
  }

  .price-grad{
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
    // =========================
    // AMBIL FOTO PRODUK
    // =========================
    $raw = $product->image_url
        ?? $product->cover_url
        ?? $product->photo
        ?? $product->image
        ?? null;

    if ($raw) {
        $raw = ltrim($raw, '/');

        if (substr($raw, 0, 4) === 'http') {
            // full URL (unsplash dll)
            $img = $raw;
        } elseif (strpos($raw, 'storage/') === 0) {
            // sudah mengandung "storage/" di depan → langsung asset
            $img = asset($raw);
        } else {
            // contoh di DB: "products/xxx.png" → jadi "/storage/products/xxx.png"
            $img = asset('storage/'.$raw);
        }
    } else {
        // fallback placeholder
        $img = asset('image/Cake-Pinky.jpg');
    }

    $store   = $product->store ?? null;
    $backUrl = url()->previous();
@endphp

<div class="bg-rose-50/60">
  <div class="detail-shell">

    {{-- BREADCRUMB + BACK --}}
    <div class="flex items-center justify-between gap-3 mb-4">
      <div class="text-xs md:text-sm text-rose-700/80">
        <a href="{{ url('/') }}" class="hover:underline">Home</a>
        <span class="mx-1">/</span>
        <a href="{{ route('stores.index') }}" class="hover:underline">Toko</a>
        @if($store)
          <span class="mx-1">/</span>
          <a href="{{ route('stores.show', $store->slug ?? $store->id) }}" class="hover:underline">
            {{ $store->name }}
          </a>
        @endif
        <span class="mx-1">/</span>
        <span class="font-semibold">{{ $product->name }}</span>
      </div>

      <a href="{{ $backUrl }}" class="btn-soft">
        ← Kembali
      </a>
    </div>

    {{-- KARTU DETAIL --}}
    <div class="detail-card">
      <div class="grid md:grid-cols-2 gap-8 md:gap-10 items-start">
        {{-- FOTO PRODUK --}}
        <div>
          <div class="rounded-2xl overflow-hidden bg-rose-50 border border-rose-100/80">
            <img
              src="{{ $img }}"
              alt="{{ $product->name }}"
              class="w-full h-72 md:h-80 object-cover">
          </div>

          @if($store)
            <div class="mt-4 flex items-center gap-3">
              <img
                src="{{ $store->logo_url ?? ($store->logo ? asset('storage/'.$store->logo) : asset('image/Cake-Pinky.jpg')) }}"
                alt="{{ $store->name }}"
                class="w-10 h-10 rounded-xl object-cover ring-1 ring-rose-200/70 bg-white">
              <div class="text-xs">
                <p class="font-semibold text-[var(--bcake-cocoa)]">
                  {{ $store->name }}
                </p>
                <p class="text-rose-600/80">
                  Toko di B’cake
                </p>
              </div>
            </div>
          @endif
        </div>

        {{-- INFORMASI PRODUK --}}
        <div class="space-y-3">
          <div class="flex flex-wrap items-center gap-2">
            @if($product->category ?? false)
              <span class="pill">
                {{ $product->category->name }}
              </span>
            @endif

            @if(isset($product->status))
              <span class="pill" style="background:#ecfdf3;border-color:#6ee7b7;color:#166534;">
                {{ strtoupper($product->status) }}
              </span>
            @endif
          </div>

          <h1 class="text-2xl md:text-3xl font-semibold text-[var(--bcake-cocoa)] leading-tight">
            {{ $product->name }}
          </h1>

          <div class="price-grad text-xl md:text-2xl">
            Rp {{ number_format($product->price ?? 0,0,',','.') }}
          </div>

          @if(!empty($product->description))
            <div class="pt-2 text-sm md:text-[0.95rem] text-gray-700 leading-relaxed">
              {!! nl2br(e($product->description)) !!}
            </div>
          @endif

          <div class="pt-3 space-y-2 text-xs text-gray-500">
            @if(isset($product->stock))
              <div>
                Stok: <span class="font-semibold text-rose-700">{{ $product->stock }}</span>
              </div>
            @endif
            <div>
              Terakhir diperbarui:
              <span class="font-semibold text-rose-700">
                {{ optional($product->updated_at)->format('d M Y, H:i') ?? '—' }}
              </span>
            </div>
          </div>

          {{-- TOMBOL AKSI --}}
          <div class="pt-4 space-y-3">

            {{-- FORM TAMBAH KE KERANJANG --}}
            @auth
              <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <div class="flex flex-wrap items-center gap-3">
                  <div class="flex items-center gap-2 text-xs">
                    <span class="text-gray-600">Jumlah:</span>
                    <input
                      type="number"
                      name="qty"
                      min="1"
                      max="{{ $product->stock ?? 99 }}"
                      value="1"
                      class="w-20 rounded-xl border border-rose-200 px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-rose-300">
                  </div>

                  <button type="submit" class="btn-primary">
                    🛒 Tambah ke Keranjang
                  </button>
                </div>
              </form>
            @else
              <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                <a href="{{ route('login') }}" class="btn-primary">
                  🛒 Login untuk tambah ke keranjang
                </a>
              </div>
            @endauth

            {{-- TOMBOL WHATSAPP & LIHAT TOKO --}}
            <div class="flex flex-wrap items-center gap-3">
              @php
                $waNumber = $store->whatsapp ?? null;
                $waText   = urlencode("Halo, saya tertarik dengan produk ".$product->name." di B’cake.");
                $waLink   = $waNumber
                            ? "https://wa.me/".$waNumber."?text=".$waText
                            : "https://wa.me/?text=".$waText;
              @endphp

              <a href="{{ $waLink }}" target="_blank" class="btn-soft">
                💬 Kirim WhatsApp Penjual
              </a>

              @if($store)
                <a href="{{ route('stores.show', $store->slug ?? $store->id) }}" class="btn-soft">
                  Lihat toko {{ $store->name }}
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
