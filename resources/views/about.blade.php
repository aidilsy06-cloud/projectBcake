@extends('layouts.app')

@section('title', 'Tentang Kami — B’cake')

@push('head')
<style>
  :root{
    /* PALET BRAND */
    --bcake-wine:  #9B335F;  /* wine / berry */
    --bcake-deep:  #7E2A50;
    --bcake-cocoa: #442127;
  }

  /* latar halaman lembut */
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }

  .about-shell{
    max-width: 64rem;
    margin: 0 auto;
    padding: 2.75rem 1.25rem 4rem;
  }

  /* ============================
     🎀 HERO STRIPES TENTANG B’CAKE
  ============================= */
  .hero-about-banner{
    position: relative;
    border-radius: 2.5rem;
    padding: 4rem 1.5rem 3.4rem;
    overflow: hidden;
    box-shadow: 0 22px 55px rgba(155,51,95,.22);
    background:
      radial-gradient(120% 120% at 50% 0%, rgba(255,255,255,.22) 0%, transparent 55%),
      repeating-linear-gradient(
        to bottom,
        #f7d2da 0px,
        #f7d2da 22px,
        #b55c69 22px,
        #b55c69 44px
      );
  }

  /* scallop bawah */
  .hero-about-banner::after{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:-20px;
    height:40px;
    background:
      radial-gradient(circle at 20px 0, #fff 20px, transparent 21px) repeat-x;
    background-size:40px 40px;
  }

  .hero-about-inner{
    position:relative;
    z-index:1;
    text-align:center;
    color:#fff;
  }

  .hero-logo-badge{
    margin:0 auto 1.75rem;
    width:110px;
    height:110px;
    border-radius:2rem;
    background:#480016;
    box-shadow:
      0 28px 55px rgba(72,0,22,.7),
      0 0 0 10px rgba(255,255,255,.06);
    display:flex;
    align-items:center;
    justify-content:center;
  }

  .hero-logo-text{
    font-family:"Playfair Display",serif;
    font-size:1.8rem;
    font-weight:700;
    letter-spacing:.08em;
  }

  .hero-about-title{
    font-family:"Playfair Display",serif;
    font-size:2.1rem;
    letter-spacing:.12em;
    font-weight:700;
    text-transform:uppercase;
    text-shadow:0 2px 14px rgba(0,0,0,.35);
    margin-bottom:1.1rem;
  }

  .hero-about-tagline{
    max-width:40rem;
    margin:0 auto;
    font-size:.98rem;
    line-height:1.7;
    color:rgba(255,255,255,.88);
  }

  .hero-about-tagline span.line-2{
    display:block;
    opacity:.9;
  }
  .hero-about-tagline span.line-3{
    display:block;
    opacity:.8;
  }

  /* ============================
     KARTU KONTEN BAWAH
  ============================= */
  .card-soft{
    background: linear-gradient(145deg,#ffffff,#fff6f7 55%,#ffecef 100%);
    box-shadow:0 16px 38px rgba(137,5,36,.09);
    border-radius: 1.6rem;
    border: 1px solid rgba(255,255,255,.9);
  }

  .pill-soft{
    border-radius:999px;
    padding:.35rem .9rem;
    font-size:.78rem;
    background:#fff;
    border:1px solid rgba(155,51,95,.16);
    color:var(--bcake-wine);
    display:inline-flex;
    align-items:center;
    gap:.35rem;
  }

  .section-title{
    font-size:1.25rem;
    font-weight:600;
    color:var(--bcake-deep);
    letter-spacing:.01em;
  }

  .section-text{
    font-size:.96rem;
    line-height:1.7;
    color:rgba(68,33,39,.9);
  }

  .steps-list{
    list-style:none;
    padding:0;
    margin:0;
  }

  .steps-list li{
    position:relative;
    padding-left:2.7rem;
  }

  .step-number{
    position:absolute;
    left:0;
    top:.05rem;
    width:2rem;
    height:2rem;
    border-radius:999px;
    background:#ffe3ee;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:.8rem;
    font-weight:600;
    color:var(--bcake-wine);
    box-shadow:0 4px 10px rgba(137,5,36,.12);
  }

  .step-title{
    font-weight:600;
    color:var(--bcake-deep);
    font-size:.98rem;
  }

  .step-text{
    font-size:.9rem;
    color:rgba(68,33,39,.86);
  }

  @media (min-width:768px){
    .about-shell{
      padding-inline:1.5rem;
    }
    .hero-about-banner{
      padding:4.3rem 3rem 3.6rem;
    }
    .hero-about-title{
      font-size:2.4rem;
    }
  }

  @media (max-width:767px){
    .about-shell{
      padding-inline:1rem;
      padding-top:2.25rem;
    }
  }
</style>
@endpush

@section('content')
<div class="page-bg">
  <div class="about-shell space-y-10 md:space-y-12">

    {{-- 🧁 HERO STRIPES TENTANG B’CAKE --}}
    <section>
      <div class="hero-about-banner">
        <div class="hero-about-inner">
          <div class="hero-logo-badge">
            {{-- kalau punya file logo, ganti span ini jadi <img src="..." /> --}}
            <span class="hero-logo-text">B’cake</span>
          </div>

          <h1 class="hero-about-title">
            TENTANG B’CAKE
          </h1>

          <p class="hero-about-tagline">
            Marketplace kue elegan yang mempertemukan baker &amp; UMKM
            lokal Bengkalis dengan pecinta dessert dalam satu ruang digital
            <span class="line-2">yang manis dan hangat.</span>
          </p>
        </div>
      </div>
    </section>

    {{-- VISI & MISI --}}
    <section class="grid md:grid-cols-2 gap-6 md:gap-7">
      <div class="card-soft p-5 md:p-6">
        <h2 class="section-title mb-2">Visi</h2>
        <p class="section-text">
          Menjadi platform pemesanan kue online yang <strong>paling dipercaya</strong>
          di Bengkalis dan sekitarnya, yang membantu UMKM bakery tumbuh sekaligus
          memudahkan pelanggan merayakan setiap momen dengan kue terbaik.
        </p>
      </div>

      <div class="card-soft p-5 md:p-6">
        <h2 class="section-title mb-2">Misi</h2>
        <ul class="mt-1 space-y-2 section-text">
          <li>• Menghadirkan katalog kue yang rapi, informatif, dan mudah diakses.</li>
          <li>• Memberikan ruang promosi yang elegan untuk UMKM bakery lokal.</li>
          <li>• Memudahkan proses pemesanan kue lewat alur yang jelas dan praktis.</li>
          <li>• Menjaga pengalaman pengguna yang manis, dari buka website sampai kue tiba.</li>
        </ul>
      </div>
    </section>

    {{-- CERITA BRAND --}}
    <section class="card-soft p-5 md:p-6">
      <h2 class="section-title mb-3">Cerita Brand B’cake</h2>
      <div class="space-y-3">
        <p class="section-text">
          B’cake lahir dari kebutuhan sederhana: banyak bakery rumahan di Bengkalis
          yang punya rasa juara, tapi belum punya tempat promosi yang tertata dan mudah ditemukan.
          Di sisi lain, pelanggan sering bingung mencari kue yang sesuai tema, budget,
          dan lokasi — apalagi kalau pesan untuk momen spesial.
        </p>
        <p class="section-text">
          Dari situ kami merancang B’cake sebagai <strong>etalase digital</strong> yang menyatukan
          berbagai toko kue dalam satu website. Toko bisa mengatur produk dan tokonya sendiri,
          sementara pelanggan tinggal menjelajah, memilih, dan mengirim pesanan
          tanpa harus menyimpan banyak nomor WhatsApp satu per satu.
        </p>
      </div>
    </section>

    {{-- KENAPA MEMILIH B'CAKE --}}
    <section class="space-y-4">
      <h2 class="section-title">Kenapa Memilih B’cake?</h2>
      <div class="grid md:grid-cols-2 gap-4 md:gap-5">
        <div class="card-soft p-4 md:p-5">
          <h3 class="font-semibold text-[0.98rem] mb-1" style="color:var(--bcake-deep);">
            ✨ Banyak pilihan toko &amp; kue
          </h3>
          <p class="text-xs md:text-[0.93rem] leading-relaxed" style="color:rgba(68,33,39,.88);">
            Dari <em>custom cake</em>, dessert box, cupcake, hingga snack — semuanya
            dikurasi dalam kategori yang rapi supaya kamu mudah menemukan yang cocok.
          </p>
        </div>
        <div class="card-soft p-4 md:p-5">
          <h3 class="font-semibold text-[0.98rem] mb-1" style="color:var(--bcake-deep);">
            📍 Fokus pada UMKM lokal
          </h3>
          <p class="text-xs md:text-[0.93rem] leading-relaxed" style="color:rgba(68,33,39,.88);">
            B’cake membantu bakery lokal di Bengkalis dan sekitar untuk tampil profesional,
            mendapat lebih banyak pesanan, dan menjangkau pelanggan baru.
          </p>
        </div>
        <div class="card-soft p-4 md:p-5">
          <h3 class="font-semibold text-[0.98rem] mb-1" style="color:var(--bcake-deep);">
            🧾 Detail pesanan yang jelas
          </h3>
          <p class="text-xs md:text-[0.93rem] leading-relaxed" style="color:rgba(68,33,39,.88);">
            Jumlah, varian rasa, catatan dekorasi, hingga waktu pengambilan/pengantaran
            tertulis rapi di form pesanan, lalu dikirim ke WhatsApp toko.
          </p>
        </div>
        <div class="card-soft p-4 md:p-5">
          <h3 class="font-semibold text-[0.98rem] mb-1" style="color:var(--bcake-deep);">
            💬 Komunikasi langsung dengan toko
          </h3>
          <p class="text-xs md:text-[0.93rem] leading-relaxed" style="color:rgba(68,33,39,.88);">
            Setelah checkout, kamu bisa melanjutkan komunikasi dan konfirmasi pembayaran
            langsung dengan pemilik toko melalui WhatsApp.
          </p>
        </div>
      </div>
    </section>

    {{-- NILAI KAMI --}}
    <section class="card-soft p-5 md:p-6">
      <h2 class="section-title mb-3">Nilai Kami</h2>
      <div class="flex flex-wrap gap-2">
        <span class="pill-soft">🌟 Kemudahan bagi pelanggan</span>
        <span class="pill-soft">🎁 Dukungan untuk UMKM lokal</span>
        <span class="pill-soft">🎨 Tampilan produk yang elegan</span>
        <span class="pill-soft">🤝 Transparansi &amp; kejelasan pesanan</span>
        <span class="pill-soft">😊 Pengalaman yang hangat &amp; bersahabat</span>
      </div>
    </section>

    {{-- CARA KERJA B'CAKE --}}
    <section class="space-y-4 mb-2 md:mb-0">
      <h2 class="section-title">Cara Kerja B’cake</h2>
      <ol class="steps-list space-y-3 md:space-y-4">
        <li>
          <div class="step-number">1</div>
          <div class="space-y-0.5">
            <p class="step-title">Jelajahi toko &amp; kategori</p>
            <p class="step-text">
              Buka halaman <strong>Menu / Produk</strong> atau <strong>Toko</strong>, lalu pilih toko
              atau kategori kue yang kamu inginkan.
            </p>
          </div>
        </li>

        <li>
          <div class="step-number">2</div>
          <div class="space-y-0.5">
            <p class="step-title">Pilih kue impianmu</p>
            <p class="step-text">
              Lihat detail produk, foto, varian rasa, dan keterangan lain untuk memastikan kue
              sesuai kebutuhan acara.
            </p>
          </div>
        </li>

        <li>
          <div class="step-number">3</div>
          <div class="space-y-0.5">
            <p class="step-title">Masukkan ke keranjang</p>
            <p class="step-text">
              Tentukan jumlah, isi catatan khusus (seperti tulisan di kue atau tema warna),
              lalu tambahkan ke keranjang.
            </p>
          </div>
        </li>

        <li>
          <div class="step-number">4</div>
          <div class="space-y-0.5">
            <p class="step-title">Checkout lewat B’cake</p>
            <p class="step-text">
              Isi data pemesan dan waktu acara. Sistem kami akan merangkum pesananmu dengan rapi.
            </p>
          </div>
        </li>

        <li>
          <div class="step-number">5</div>
          <div class="space-y-0.5">
            <p class="step-title">Pesanan diteruskan ke WhatsApp toko</p>
            <p class="step-text">
              Detail pesanan dikirim ke WhatsApp pemilik toko untuk konfirmasi, pembayaran,
              dan pengaturan pengiriman/pengambilan.
            </p>
          </div>
        </li>

        <li>
          <div class="step-number">6</div>
          <div class="space-y-0.5">
            <p class="step-title">Kue siap meramaikan momenmu</p>
            <p class="step-text">
              Setelah disepakati dengan toko, kue akan disiapkan dan dikirim sesuai kesepakatan.
              Tinggal nikmati momen manis bersama orang tersayang. 🍰
            </p>
          </div>
        </li>
      </ol>
    </section>

  </div>
</div>
@endsection
