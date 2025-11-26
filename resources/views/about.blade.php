@extends('layouts.app')

@section('title', 'Tentang Kami — B’cake')

@push('head')
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
  }

  /* latar lembut */
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }

  .about-shell{
    max-width: 64rem;          /* kira2 1024px */
    margin: 0 auto;
    padding: 2.75rem 1.25rem 4rem;
  }

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
    border:1px solid rgba(137,5,36,.12);
    color:#7f102f;
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
    color:rgba(54,35,32,.86);
  }

  .about-hero-title{
    font-family:"Playfair Display",serif;
    font-size:1.9rem;
    font-weight:700;
    color:var(--bcake-deep);
    letter-spacing:.01em;
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
    color:var(--bcake-deep);
    box-shadow:0 4px 10px rgba(137,5,36,.12);
  }

  .step-title{
    font-weight:600;
    color:var(--bcake-deep);
    font-size:.98rem;
  }

  .step-text{
    font-size:.9rem;
    color:rgba(54,35,32,.82);
  }

  @media (min-width:768px){
    .about-hero-layout{
      display:grid;
      grid-template-columns:minmax(0,1.5fr) minmax(0,1fr);
      gap:2.5rem;
      align-items:center;
    }
    .about-hero-title{
      font-size:2.15rem;
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

    {{-- HERO / INTRO --}}
    <section>
      <div class="card-soft p-6 md:p-8 relative overflow-hidden">
        <div class="absolute -right-20 -bottom-24 w-72 h-72 bg-rose-100 rounded-full opacity-60 blur-3xl"></div>

        <div class="about-hero-layout relative z-[1] gap-6">
          <div class="space-y-3">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/85 text-[0.75rem] font-semibold text-rose-700 border border-rose-100">
              <span class="text-lg leading-none">🎂</span>
              Tentang B’cake
            </span>

            <h1 class="about-hero-title">
              Marketplace kue manis untuk momen manismu.
            </h1>

            <p class="section-text max-w-2xl text-[0.95rem] md:text-[0.98rem]">
              B’cake adalah <strong>marketplace kue dan dessert</strong> yang menghubungkan pelanggan
              dengan UMKM bakery di Bengkalis dan sekitarnya. Di satu tempat, kamu bisa
              menemukan berbagai kue cantik, membandingkan toko, lalu memesan dengan mudah
              lewat website — detail pesanan diteruskan ke WhatsApp toko untuk proses lanjut.
            </p>
          </div>

          <div class="hidden md:block">
            <div class="h-full flex items-center">
              <div class="rounded-2xl bg-white/80 border border-rose-100 px-5 py-4 shadow-sm max-w-xs ml-auto">
                <p class="text-[0.9rem] leading-relaxed text-rose-900/85">
                  Lewat tampilan yang lembut dan alur pemesanan yang sederhana, B’cake ingin
                  membuat pengalaman mencari kue terasa hangat, terarah, dan tetap manis
                  dari awal sampai akhir.
                </p>
              </div>
            </div>
          </div>
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
          <h3 class="font-semibold text-rose-900 mb-1 text-sm md:text-[0.98rem]">
            ✨ Banyak pilihan toko &amp; kue
          </h3>
          <p class="text-xs md:text-[0.93rem] text-rose-900/80 leading-relaxed">
            Dari <em>custom cake</em>, dessert box, cupcake, hingga snack — semuanya
            dikurasi dalam kategori yang rapi supaya kamu mudah menemukan yang cocok.
          </p>
        </div>
        <div class="card-soft p-4 md:p-5">
          <h3 class="font-semibold text-rose-900 mb-1 text-sm md:text-[0.98rem]">
            📍 Fokus pada UMKM lokal
          </h3>
          <p class="text-xs md:text-[0.93rem] text-rose-900/80 leading-relaxed">
            B’cake membantu bakery lokal di Bengkalis dan sekitar untuk tampil profesional,
            mendapat lebih banyak pesanan, dan menjangkau pelanggan baru.
          </p>
        </div>
        <div class="card-soft p-4 md:p-5">
          <h3 class="font-semibold text-rose-900 mb-1 text-sm md:text-[0.98rem]">
            🧾 Detail pesanan yang jelas
          </h3>
          <p class="text-xs md:text-[0.93rem] text-rose-900/80 leading-relaxed">
            Jumlah, varian rasa, catatan dekorasi, hingga waktu pengambilan/pengantaran
            tertulis rapi di form pesanan, lalu dikirim ke WhatsApp toko.
          </p>
        </div>
        <div class="card-soft p-4 md:p-5">
          <h3 class="font-semibold text-rose-900 mb-1 text-sm md:text-[0.98rem]">
            💬 Komunikasi langsung dengan toko
          </h3>
          <p class="text-xs md:text-[0.93rem] text-rose-900/80 leading-relaxed">
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
