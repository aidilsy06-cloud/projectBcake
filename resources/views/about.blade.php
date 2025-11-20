@extends('layouts.app')

@section('title', 'Tentang Kami — B’cake')

@push('head')
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
  }
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }
  .card-soft{
    background: linear-gradient(145deg,#ffffff,#fff6f7 55%,#ffecef 100%);
    box-shadow:0 20px 45px rgba(137,5,36,.10);
  }
  .pill-soft{
    border-radius:999px;
    padding:.35rem .9rem;
    font-size:.78rem;
    background:#fff;
    border:1px solid rgba(137,5,36,.12);
    color:#7f102f;
  }
</style>
@endpush

@section('content')
<div class="page-bg py-10 md:py-14">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- HERO / INTRO --}}
    <section class="mb-10">
      <div class="card-soft rounded-3xl p-6 md:p-9 relative overflow-hidden">
        <div class="absolute -right-20 -bottom-24 w-72 h-72 bg-rose-100 rounded-full opacity-60 blur-3xl"></div>
        <div class="relative z-[1]">
          <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/80 text-[0.75rem] font-semibold text-rose-700 border border-rose-100 mb-3">
            <span class="text-lg">🎂</span> Tentang B’cake
          </span>
          <h1 class="text-2xl md:text-3xl font-semibold text-rose-900 mb-3">
            Marketplace kue manis untuk momen manismu.
          </h1>
          <p class="text-sm md:text-base text-rose-900/80 leading-relaxed max-w-2xl">
            B’cake adalah <strong>marketplace kue dan dessert</strong> yang menghubungkan pelanggan
            dengan UMKM bakery di Bengkalis dan sekitarnya. Di satu tempat, kamu bisa
            menemukan berbagai kue cantik, membandingkan toko, lalu memesan dengan mudah
            lewat website — detail pesanan diteruskan ke WhatsApp toko untuk proses lanjut.
          </p>
        </div>
      </div>
    </section>

    {{-- VISI & MISI --}}
    <section class="grid md:grid-cols-2 gap-6 md:gap-8 mb-10">
      <div class="card-soft rounded-2xl p-5 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-rose-900 mb-2">Visi</h2>
        <p class="text-sm md:text-base text-rose-900/80 leading-relaxed">
          Menjadi platform pemesanan kue online yang <strong>paling dipercaya</strong>
          di Bengkalis dan sekitarnya, yang membantu UMKM bakery tumbuh sekaligus
          memudahkan pelanggan merayakan setiap momen dengan kue terbaik.
        </p>
      </div>

      <div class="card-soft rounded-2xl p-5 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-rose-900 mb-2">Misi</h2>
        <ul class="mt-1 space-y-2 text-sm md:text-base text-rose-900/80">
          <li>• Menghadirkan katalog kue yang rapi, informatif, dan mudah diakses.</li>
          <li>• Memberikan ruang promosi yang elegan untuk UMKM bakery lokal.</li>
          <li>• Memudahkan proses pemesanan kue lewat alur yang jelas dan praktis.</li>
          <li>• Menjaga pengalaman pengguna yang manis, dari buka website sampai kue tiba.</li>
        </ul>
      </div>
    </section>

    {{-- CERITA BRAND --}}
    <section class="card-soft rounded-2xl p-5 md:p-6 mb-10">
      <h2 class="text-lg md:text-xl font-semibold text-rose-900 mb-3">Cerita Brand B’cake</h2>
      <p class="text-sm md:text-base text-rose-900/80 leading-relaxed mb-3">
        B’cake lahir dari kebutuhan sederhana: banyak bakery rumahan di Bengkalis
        yang punya rasa juara, tapi belum punya tempat promosi yang tertata dan mudah ditemukan.
        Di sisi lain, pelanggan sering bingung mencari kue yang sesuai tema, budget,
        dan lokasi — apalagi kalau pesan untuk momen spesial.
      </p>
      <p class="text-sm md:text-base text-rose-900/80 leading-relaxed">
        Dari situ kami merancang B’cake sebagai <strong>etalase digital</strong> yang menyatukan
        berbagai toko kue dalam satu website. Toko bisa mengatur produk dan tokonya sendiri,
        sementara pelanggan tinggal menjelajah, memilih, dan mengirim pesanan
        tanpa harus menyimpan banyak nomor WhatsApp satu per satu.
      </p>
    </section>

    {{-- KENAPA MEMILIH B'CAKE --}}
    <section class="mb-10">
      <h2 class="text-lg md:text-xl font-semibold text-rose-900 mb-4">Kenapa Memilih B’cake?</h2>
      <div class="grid md:grid-cols-2 gap-4 md:gap-5">
        <div class="card-soft rounded-2xl p-4 md:p-5">
          <h3 class="font-semibold text-rose-900 mb-1 text-sm md:text-base">✨ Banyak pilihan toko & kue</h3>
          <p class="text-xs md:text-sm text-rose-900/80">
            Dari <em>custom cake</em>, dessert box, cupcake, hingga snack — semuanya
            dikurasi dalam kategori yang rapi supaya kamu mudah menemukan yang cocok.
          </p>
        </div>
        <div class="card-soft rounded-2xl p-4 md:p-5">
          <h3 class="font-semibold text-rose-900 mb-1 text-sm md:text-base">📍 Fokus pada UMKM lokal</h3>
          <p class="text-xs md:text-sm text-rose-900/80">
            B’cake membantu bakery lokal di Bengkalis dan sekitar untuk tampil profesional,
            mendapat lebih banyak pesanan, dan menjangkau pelanggan baru.
          </p>
        </div>
        <div class="card-soft rounded-2xl p-4 md:p-5">
          <h3 class="font-semibold text-rose-900 mb-1 text-sm md:text-base">🧾 Detail pesanan yang jelas</h3>
          <p class="text-xs md:text-sm text-rose-900/80">
            Jumlah, varian rasa, catatan dekorasi, hingga waktu pengambilan/pengantaran
            tertulis rapi di form pesanan, lalu dikirim ke WhatsApp toko.
          </p>
        </div>
        <div class="card-soft rounded-2xl p-4 md:p-5">
          <h3 class="font-semibold text-rose-900 mb-1 text-sm md:text-base">💬 Komunikasi langsung dengan toko</h3>
          <p class="text-xs md:text-sm text-rose-900/80">
            Setelah checkout, kamu bisa melanjutkan komunikasi dan konfirmasi pembayaran
            langsung dengan pemilik toko melalui WhatsApp.
          </p>
        </div>
      </div>
    </section>

    {{-- NILAI KAMI --}}
    <section class="card-soft rounded-2xl p-5 md:p-6 mb-10">
      <h2 class="text-lg md:text-xl font-semibold text-rose-900 mb-3">Nilai Kami</h2>
      <div class="flex flex-wrap gap-2">
        <span class="pill-soft">🌟 Kemudahan bagi pelanggan</span>
        <span class="pill-soft">🎁 Dukungan untuk UMKM lokal</span>
        <span class="pill-soft">🎨 Tampilan produk yang elegan</span>
        <span class="pill-soft">🤝 Transparansi & kejelasan pesanan</span>
        <span class="pill-soft">😊 Pengalaman yang hangat & bersahabat</span>
      </div>
    </section>

    {{-- CARA KERJA B'CAKE --}}
    <section class="mb-4 md:mb-6">
      <h2 class="text-lg md:text-xl font-semibold text-rose-900 mb-4">Cara Kerja B’cake</h2>
      <ol class="space-y-3 text-sm md:text-base text-rose-900/85">
        <li>
          <span class="font-semibold text-rose-900">1. Jelajahi toko & kategori</span><br>
          Buka halaman <strong>Menu / Produk</strong> atau <strong>Toko</strong>, lalu pilih toko atau kategori kue yang kamu inginkan.
        </li>
        <li>
          <span class="font-semibold text-rose-900">2. Pilih kue impianmu</span><br>
          Lihat detail produk, foto, varian rasa, dan keterangan lain untuk memastikan kue sesuai kebutuhan acara.
        </li>
        <li>
          <span class="font-semibold text-rose-900">3. Masukkan ke keranjang</span><br>
          Tentukan jumlah, isi catatan khusus (seperti tulisan di kue atau tema warna), lalu tambahkan ke keranjang.
        </li>
        <li>
          <span class="font-semibold text-rose-900">4. Checkout lewat B’cake</span><br>
          Isi data pemesan dan waktu acara. Sistem kami akan merangkum pesananmu dengan rapi.
        </li>
        <li>
          <span class="font-semibold text-rose-900">5. Pesanan diteruskan ke WhatsApp toko</span><br>
          Detail pesanan dikirim ke WhatsApp pemilik toko untuk konfirmasi, pembayaran, dan pengaturan pengiriman/pengambilan.
        </li>
        <li>
          <span class="font-semibold text-rose-900">6. Kue siap meramaikan momenmu</span><br>
          Setelah disepakati dengan toko, kue akan disiapkan dan dikirim sesuai kesepakatan. Tinggal nikmati momen manis bersama orang tersayang. 🍰
        </li>
      </ol>
    </section>

  </div>
</div>
@endsection
