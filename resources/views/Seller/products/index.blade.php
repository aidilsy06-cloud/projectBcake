@extends('layouts.app')
@section('title', 'Katalog Toko — B’cake')

@push('head')
<style>
  :root{
    --wine:#890524;
    --soft:#ffe7ef;
    --cocoa:#362320;
  }

  .shadow-soft{box-shadow:0 26px 60px rgba(137,5,36,.14)}

  /* ===== HEADER TOKO ===== */
  .toko-shell{
    border-radius:28px;
    background:
      radial-gradient(900px 480px at 80% -10%, #fff7fb, transparent 60%),
      linear-gradient(135deg,#fff7f8,#ffe0ed);
    padding:1.8rem 2rem;
    box-shadow:0 28px 70px rgba(137,5,36,.18);
    position:relative;
    overflow:hidden;
  }
  .toko-shell::before{
    content:"";
    position:absolute;
    inset:-30%;
    opacity:.25;
    background:
      radial-gradient(circle at 0 0,#fff 0,transparent 55%),
      radial-gradient(circle at 100% 100%,#fff 0,transparent 55%);
    pointer-events:none;
  }
  .toko-shell-inner{
    position:relative;
    z-index:1;
    display:grid;
    grid-template-columns:minmax(0,3fr) minmax(0,2fr);
    gap:1.8rem;
    align-items:center;
  }

  .toko-avatar{
    width:86px;height:86px;
    border-radius:999px;
    border:4px solid #fff;
    overflow:hidden;
    box-shadow:0 18px 40px rgba(137,5,36,.25);
  }
  .toko-avatar img{
    width:100%;height:100%;object-fit:cover;
  }

  .badge-pill{
    display:inline-flex;
    align-items:center;
    gap:.4rem;
    border-radius:999px;
    padding:.3rem .8rem;
    font-size:.7rem;
    background:#fff;
    border:1px solid rgba(248,113,113,.25);
    color:#9f1239;
    white-space:nowrap;
    text-decoration:none;
    transition:background .16s ease, box-shadow .16s ease, transform .16s ease;
  }
  .badge-pill:hover{
    background:#ffe7ef;
    box-shadow:0 10px 26px rgba(137,5,36,.18);
    transform:translateY(-1px);
  }

  .btn-pink{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:999px;
    padding:.65rem 1.5rem;
    background:#f97373;
    color:#fff !important;
    font-weight:600;
    font-size:.9rem;
    box-shadow:0 18px 35px rgba(248,113,113,.4);
    border:none;
    cursor:pointer;
    text-decoration:none;
    position:relative;
    z-index:10;
    transition:transform .18s ease, box-shadow .18s ease, background .18s ease;
  }
  .btn-pink:hover{
    background:#ef4444;
    transform:translateY(-1px);
    box-shadow:0 24px 60px rgba(248,113,113,.55);
  }

  .stat-row{
    display:flex;
    flex-wrap:wrap;
    gap:.75rem;
    margin-top:1.5rem;
  }
  .stat-chip{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:.8rem;
    padding:.55rem 1.1rem;
    border-radius:999px;
    background:#fff;
    font-size:.78rem;
    color:#4b1e25;
    box-shadow:0 8px 22px rgba(137,5,36,.08);
  }
  .stat-label{opacity:.8;}
  .stat-value{font-weight:600;}
  .stat-chip--active{
    background:#22c55e10;
    color:#15803d;
    border:1px solid #bbf7d0;
  }
  .stat-chip--tab.is-active{
    background:#fb7185;
    color:#fff;
  }
  .stat-chip--tab a{
    text-decoration:none;
    color:inherit;
  }
  .stat-chip-link{
    display:flex;
    align-items:center;
    justify-content:space-between;
    width:100%;
    text-decoration:none;
    color:inherit;
  }

  /* ===== GRINDIL / SCALLOP ===== */
  .scallop-divider{
    margin-top:1.8rem;
    margin-bottom:2.3rem;
    height:34px;
    overflow:hidden;
  }
  .scallop-divider svg{
    width:100%;
    height:100%;
    display:block;
  }

  /* ===== KATALOG / GRID PRODUK ===== */
  .section-title{
    font-size:1.3rem;
    font-weight:600;
    color:var(--cocoa);
  }
  .section-subtitle{
    font-size:.9rem;
    color:#a85574;
  }

  .product-grid{
    margin-top:1.4rem;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(210px,1fr));
    gap:1.4rem;
  }

  .product-card{
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 22px 50px rgba(137,5,36,.12);
    display:flex;
    flex-direction:column;
    transition:transform .22s ease, box-shadow .22s ease, background .22s ease;
  }
  .product-card:hover{
    transform:translateY(-6px);
    box-shadow:0 28px 70px rgba(137,5,36,.20);
    background:#fff7fb;
  }

  .product-media{
    position:relative;
    overflow:hidden;
    border-radius:22px 22px 0 0;
  }
  .product-media img{
    width:100%;
    height:190px;
    object-fit:cover;
    transition:transform .35s ease;
  }
  .product-card:hover .product-media img{
    transform:scale(1.05);
  }
  .product-tag{
    position:absolute;
    left:12px;
    top:12px;
    padding:.25rem .7rem;
    border-radius:999px;
    font-size:.7rem;
    background:#fef2f2;
    color:#b91c1c;
    box-shadow:0 12px 30px rgba(248,113,113,.55);
  }

  .product-body{
    padding:1rem 1.15rem 1.1rem;
    display:flex;
    flex-direction:column;
    gap:.45rem;
  }
  .product-name{
    font-size:.95rem;
    font-weight:600;
    color:var(--cocoa);
  }
  .product-desc{
    font-size:.8rem;
    color:#a1a1aa;
  }
  .product-bottom{
    margin-top:.45rem;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:.8rem;
    font-size:.82rem;
  }
  .product-price{
    font-weight:700;
    color:#b91c1c;
  }
  .product-actions{
    display:flex;
    gap:.35rem;
  }
  .btn-ghost{
    border-radius:999px;
    padding:.35rem .7rem;
    font-size:.75rem;
    background:#fff;
    color:#b91c1c !important;
    border:1px solid #fecaca;
    text-decoration:none;
    cursor:pointer;
    transition:background .18s ease,color .18s ease,transform .18s ease;
  }
  .btn-ghost:hover{
    background:#fecaca;
    color:#7f1d1d !important;
    transform:translateY(-1px);
  }

  /* ===== EMPTY STATE ===== */
  .empty-shell{
    border-radius:26px;
    background:#ffe7ef;
    padding:2.1rem 1.6rem 2.3rem;
    text-align:center;
    box-shadow:0 22px 60px rgba(137,5,36,.16);
  }
  .empty-title{
    font-size:1.1rem;
    font-weight:600;
    color:var(--cocoa);
    margin-bottom:.4rem;
  }
  .empty-sub{
    font-size:.88rem;
    color:#a85574;
    max-width:30rem;
    margin:0 auto 1.2rem;
  }

  @media (max-width:900px){
    .toko-shell-inner{
      grid-template-columns:1fr;
      text-align:left;
    }
  }
  @media (max-width:640px){
    .toko-shell{
      padding:1.4rem 1.4rem;
      border-radius:22px;
    }
    .stat-row{
      flex-direction:column;
      align-items:flex-start;
    }
  }
</style>
@endpush

@section('content')
<section class="bg-[#fff4f7] py-6 md:py-8">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- ===== HEADER TOKO ===== --}}
    <div class="toko-shell">
      <div class="toko-shell-inner">

        {{-- Info toko --}}
        <div class="space-y-3">
          <div class="inline-flex items-center mb-1">
            <span class="badge-pill">Glam Sweet Boutique</span>
          </div>

          <div class="flex items-center gap-3">
            <div class="toko-avatar">
              <img src="{{ asset('image/cake.jpg') }}" alt="Avatar Toko">
            </div>
            <div>
              <h1 class="text-[1.35rem] md:text-[1.55rem] font-semibold text-[var(--cocoa)] leading-snug">
                Toko B’cake
              </h1>
              <p class="text-[0.86rem] text-rose-700 max-w-md">
                Etalase glam untuk semua kreasi manismu. Biar pembeli langsung jatuh cinta dari pandangan pertama. ✨🍰
              </p>
              <div class="flex flex-wrap gap-1.5 mt-1.5">
                {{-- badge kategori (filter via query ?category=...) --}}
                <a href="{{ route('seller.products.index', ['category' => 'premium-cakes']) }}" class="badge-pill">
                  Premium Cakes
                </a>
                <a href="{{ route('seller.products.index', ['category' => 'birthday-glam']) }}" class="badge-pill">
                  Birthday Glam
                </a>
                <a href="{{ route('seller.products.index', ['category' => 'tea-time-desserts']) }}" class="badge-pill">
                  Tea-time Desserts
                </a>
              </div>
            </div>
          </div>

          {{-- STAT CHIPS --}}
          <div class="stat-row">
            <div class="stat-chip">
              <span class="stat-label">Total Produk</span>
              <span class="stat-value">{{ isset($products) ? $products->count() : 0 }}</span>
            </div>

            <div class="stat-chip stat-chip--active">
              <span class="stat-label">Status</span>
              <span class="stat-value">Aktif</span>
            </div>

            {{-- mode katalog (halaman ini) --}}
            <div class="stat-chip stat-chip--tab is-active">
              <div class="stat-chip-link">
                <span class="stat-label">Mode</span>
                <span class="stat-value">Katalog</span>
              </div>
            </div>

            {{-- link ke dashboard seller --}}
            <div class="stat-chip stat-chip--tab">
              <a href="{{ route('seller.dashboard') }}" class="stat-chip-link">
                <span class="stat-label">B’cake Seller</span>
                <span class="stat-value">Dashboard</span>
              </a>
            </div>
          </div>
        </div>

        {{-- Aksi cepat --}}
        <div class="flex flex-col items-end justify-between gap-4">
          <a href="{{ route('seller.products.create') }}" class="btn-pink">
            ✨ Tambah Produk
          </a>
          <div class="text-right text-[0.8rem] text-rose-700/80 max-w-xs">
            Rapikan katalogmu, atur urutan produk, dan buat etalase yang bikin pembeli betah scroll lama-lama.
          </div>
        </div>

      </div>
    </div>

    {{-- ===== GRINDIL / SCALLOP ===== --}}
    <div class="scallop-divider" aria-hidden="true">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
        <path fill="#ffe7ef"
              d="M0,80 C60,40 180,0 300,0 C420,0 540,40 660,40 C780,40 900,0 1020,0 C1140,0 1260,40 1380,40 C1440,40 1440,80 1440,80 L0,80 Z"></path>
      </svg>
    </div>

    {{-- ===== KATALOG ===== --}}
    <section>
      <div>
        <h2 class="section-title">Katalog Manis Kamu 🍰</h2>
        <p class="section-subtitle">
          Susun kue-kue terbaikmu dalam tampilan grid yang rapi, lembut, dan glam.
        </p>
      </div>

      @if(!isset($products) || $products->count() === 0)
        {{-- KOSONG --}}
        <div class="mt-5 empty-shell">
          <div class="text-3xl mb-2">🧁✨</div>
          <p class="empty-title">Etalase-mu masih kosong, sayang~</p>
          <p class="empty-sub">
            Belum ada produk di etalase kamu. Yuk tambahkan kue pertama kamu dan buat katalog B’cake-mu bersinar manis.
          </p>
          <a href="{{ route('seller.products.create') }}" class="btn-pink">
            + Tambah Produk Pertama
          </a>
        </div>
      @else
        {{-- GRID PRODUK --}}
        <div class="product-grid mt-5">
          @foreach($products as $product)
            @php
              $photo = $product->image_url
                ?? $product->image
                ?? $product->photo
                ?? $product->photo_url
                ?? asset('image/cake.jpg');
            @endphp
            <article class="product-card">
              <div class="product-media">
                <img src="{{ $photo }}" alt="{{ $product->name }}">
                @if(isset($product->category_name) && $product->category_name)
                  <span class="product-tag">{{ $product->category_name }}</span>
                @endif
              </div>
              <div class="product-body">
                <h3 class="product-name">{{ $product->name }}</h3>
                @if(isset($product->short_description) && $product->short_description)
                  <p class="product-desc">
                    {{ \Illuminate\Support\Str::limit($product->short_description, 70) }}
                  </p>
                @endif

                <div class="product-bottom">
                  <div class="product-price">
                    Rp {{ number_format($product->price,0,',','.') }}
                  </div>
                  <div class="product-actions">
                    <a href="{{ route('seller.products.edit', $product->id) }}" class="btn-ghost">
                      Edit
                    </a>
                    {{-- detail publik pakai slug --}}
                    <a href="{{ route('products.show', $product->slug) }}" class="btn-ghost">
                      Lihat
                    </a>
                  </div>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        @if(method_exists($products, 'links'))
          <div class="mt-6">
            {{ $products->links() }}
          </div>
        @endif
      @endif
    </section>
  </div>
</section>
@endsection
