@extends('layouts.app')

@section('title', 'Tentang Kami — B’cake')
@section('meta_description', "Profil B’cake, marketplace kue elegan untuk Bengkalis.")

@push('head')
<style>
  .page-bg-about{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }

  .card-soft-about{
    background: linear-gradient(145deg,#ffffff,#fff5f7 55%,#ffe5ee 100%);
    box-shadow:0 22px 50px rgba(137,5,36,.12);
    border-radius: 1.75rem;
    transition: transform .22s ease, box-shadow .22s ease, translate .22s ease;
  }
  .card-soft-about:hover{
    transform: translateY(-4px) scale(1.01);
    box-shadow:0 30px 65px rgba(137,5,36,.18);
  }

  .pill-soft-about{
    border-radius:999px;
    padding:.35rem .9rem;
    font-size:.78rem;
    background:#fff;
    border:1px solid rgba(137,5,36,.10);
  }

  .team-card{
    background: radial-gradient(circle at 0 0,#ffeef6 0,#fff 40%,#fff6f8 100%);
    border-radius: 1.6rem;
    box-shadow:0 22px 50px rgba(137,5,36,.12);
    transition: transform .22s ease, box-shadow .22s ease;
    position: relative;
    overflow: hidden;
  }
  .team-card::before{
    content:'';
    position:absolute;
    inset:-40%;
    background:radial-gradient(circle at 0 0,rgba(255,255,255,.9),transparent 55%);
    opacity:.7;
    pointer-events:none;
  }
  .team-card:hover{
    transform: translateY(-6px);
    box-shadow:0 32px 70px rgba(137,5,36,.20);
  }

  .team-photo{
    width:120px;
    height:120px;
    border-radius: 1.1rem;
    background:#ffe0ea;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:42px;
    color:var(--bcake-wine);
    border:3px solid #ffc8d6;
    position:relative;
    z-index:1;
  }

  .team-badge{
    position:absolute;
    top:12px;
    right:12px;
    background:rgba(255,255,255,.95);
    border-radius:999px;
    padding:.18rem .6rem;
    font-size:.7rem;
    display:flex;
    align-items:center;
    gap:.25rem;
    color:#b4234a;
    box-shadow:0 8px 18px rgba(137,5,36,.16);
    z-index:2;
  }
  .team-badge span:first-child{
    font-size:.9rem;
  }

  /* ===== HERO STRIPES + GERIGI BAWAH ala BAKING TASTE ===== */
  .about-logo-hero{
    position: relative;
    width: 100%;
    border-radius: 2.4rem;
    padding: 4.4rem 1.8rem 4.6rem; /* ruang atas lebih besar supaya logo turun */
    overflow: hidden;
    box-shadow: 0 32px 90px rgba(137,5,36,0.18);
    background:
      repeating-linear-gradient(
        to bottom,
        #f8c6d8 0px,
        #f8c6d8 30px,
        #f18fb0 30px,
        #f18fb0 60px
      );
  }

  /* gerigi putih di bawah, nyambung ke background */
  .about-logo-hero::after{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:36px;
    background:
      radial-gradient(circle at 18px -2px, transparent 18px, #fff7f8 19px)
      0 0 / 36px 36px repeat-x;
    z-index:1;
  }

  /* kartu logo (sebagai cupcake) */
  .about-logo-card{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding: 1.4rem 1.6rem;
    border-radius: 1.2rem;
    background:#5b061d; /* bcake wine */
    box-shadow:0 20px 50px rgba(91,6,29,0.55);
    position: relative;
    z-index:3;
    margin-top: 1.2rem;   /* turunin logo ke tengah banner */
    margin-bottom: 1.2rem;
  }

  .about-hero-title{
    font-family: 'Playfair Display', 'Poppins', system-ui, serif;
    font-size: clamp(2.2rem, 4vw, 3.1rem);
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color:#fff;
    text-shadow:0 3px 16px rgba(137,5,36,.45);
  }

  .about-hero-sub{
    font-size:.92rem;
    max-width: 30rem;
    color:#ffeef6;
  }
</style>
@endpush

@section('content')
<section class="space-y-14 md:space-y-16">

    {{-- TOMBOL KEMBALI --}}
    <div>
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 px-5 py-2 rounded-full 
                  bg-rose-200 text-bcake-wine font-medium 
                  shadow-md hover:bg-rose-300 hover:shadow-lg transition">
            ← Kembali
        </a>
    </div>

    {{-- HERO ala BAKING TASTE: logo = cupcake, text = TENTANG B’CAKE --}}
    <div class="max-w-5xl mx-auto" data-aos="fade-up">
        <div class="about-logo-hero mb-10 flex flex-col items-center gap-4 text-center">

            {{-- “cupcake” pakai logo B’cake --}}
            <div class="about-logo-card">
                <img src="{{ asset('image/logo_bcake.jpg') }}"
                     alt="Logo B’cake"
                     class="w-16 h-16 md:w-20 md:h-20 object-contain">
            </div>

            {{-- judul besar di dalam banner --}}
            <h1 class="about-hero-title">
                Tentang B’cake
            </h1>

            {{-- subjudul kecil di dalam banner --}}
            <p class="about-hero-sub">
                Marketplace kue elegan yang mempertemukan baker &amp; UMKM lokal Bengkalis
                dengan pecinta dessert dalam satu ruang digital yang manis dan hangat.
            </p>
        </div>
    </div>

    {{-- HERO KONTEN --}}
    <div class="page-bg-about rounded-3xl border border-rose-100/70 px-6 py-9 md:px-12 md:py-12 relative overflow-hidden"
         data-aos="fade-up">
        <div class="absolute -right-24 -bottom-20 w-72 h-72 rounded-full bg-rose-200/40 blur-3xl"></div>
        <div class="absolute -left-10 -top-10 w-40 h-40 rounded-3xl bg-rose-100/70 rotate-6"></div>

        <div class="relative max-w-5xl mx-auto grid gap-9 md:grid-cols-[minmax(0,1.7fr)_minmax(0,1.1fr)] items-center">
            <div>
                <span class="pill-soft-about inline-flex items-center gap-2 mb-4 text-rose-700/80">
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-rose-600 text-white text-[10px]">i</span>
                    Profil singkat
                </span>

                <h2 class="font-display text-[1.9rem] md:text-[2.4rem] leading-snug text-rose-900 mb-3">
                    Marketplace kue elegan<br class="hidden md:block"> untuk Bengkalis.
                </h2>
                <p class="text-[.9rem] md:text-[.95rem] text-bcake-truffle/90 leading-relaxed max-w-xl">
                    B’cake adalah platform pemesanan kue yang mempertemukan
                    <span class="font-medium text-bcake-wine">baker &amp; UMKM lokal</span> dengan pecinta dessert
                    dalam satu tempat yang rapi, manis, dan mudah digunakan. Semua dirancang agar pengalaman mencari
                    kue favorit terasa lebih istimewa dan personal.
                </p>
            </div>

            <div class="card-soft-about px-6 py-7 md:px-7 md:py-8">
                <p class="text-[.9rem] text-bcake-truffle/90 leading-relaxed">
                    Lewat tampilan yang lembut dan alur pemesanan yang sederhana,
                    B’cake membantu pembeli menemukan kue terbaik sekaligus memberikan ruang digital
                    yang layak untuk baker lokal menampilkan karya manis mereka.
                </p>
            </div>
        </div>
    </div>

    {{-- APA & KENAPA --}}
    <div class="max-w-5xl mx-auto grid gap-10 md:grid-cols-2" data-aos="fade-up" data-aos-delay="80">
        <div class="space-y-3">
            <h2 class="font-display text-2xl text-rose-900">Apa itu B’cake?</h2>
            <p class="text-sm text-bcake-truffle/90 leading-relaxed">
                B’cake bukan toko kue tunggal — melainkan
                <span class="font-medium text-bcake-wine">marketplace</span> yang menampung banyak penjual.
                Setiap baker memiliki halaman toko dan katalog produk sendiri.
                Pembeli bisa menjelajah menu, melihat detail foto dan deskripsi, menambahkan ke keranjang,
                lalu melanjutkan pemesanan yang diteruskan ke WhatsApp untuk konfirmasi akhir.
            </p>
        </div>

        <div class="space-y-3">
            <h2 class="font-display text-2xl text-rose-900">Mengapa B’cake dibuat?</h2>
            <p class="text-sm text-bcake-truffle/90 leading-relaxed">
                Di Bengkalis ada banyak pembuat kue hebat, namun belum semuanya memiliki ruang digital yang tertata.
                B’cake hadir sebagai wadah yang elegan: memudahkan pembeli menemukan dessert favoritnya
                sambil membantu UMKM tampil lebih profesional tanpa harus membangun website sendiri.
            </p>
        </div>
    </div>

    {{-- FITUR UNGGULAN --}}
    <div class="max-w-5xl mx-auto card-soft-about px-6 py-7 md:px-8 md:py-8" data-aos="fade-up" data-aos-delay="120">
        <h2 class="font-display text-2xl text-rose-900 mb-4">Kenapa memilih B’cake?</h2>
        <div class="grid gap-6 md:grid-cols-3 text-sm text-bcake-truffle/90">
            <div class="space-y-1">
                <p class="font-semibold text-bcake-wine">Katalog kue lengkap</p>
                <p>Berbagai pilihan dessert dari banyak toko tersaji dalam satu platform, sehingga lebih mudah dibanding mencari satu per satu.</p>
            </div>
            <div class="space-y-1">
                <p class="font-semibold text-bcake-wine">Desain manis &amp; responsif</p>
                <p>Nuansa pink–wine yang lembut dengan tampilan yang nyaman diakses dari ponsel, tablet, maupun laptop.</p>
            </div>
            <div class="space-y-1">
                <p class="font-semibold text-bcake-wine">Pemesanan cepat via WhatsApp</p>
                <p>Setelah memilih kue, pembeli dapat langsung terhubung dengan penjual untuk berdiskusi dan mengonfirmasi pesanan.</p>
            </div>
        </div>
    </div>

    {{-- UMKM --}}
    <div class="max-w-5xl mx-auto grid gap-10 md:grid-cols-[minmax(0,1.5fr)_minmax(0,.9fr)] items-start"
         data-aos="fade-up" data-aos-delay="160">
        <div class="space-y-3">
            <h2 class="font-display text-2xl text-rose-900">Dukungan untuk UMKM lokal</h2>
            <p class="text-sm text-bcake-truffle/90 leading-relaxed">
                B’cake didedikasikan untuk pelaku usaha kue di Bengkalis agar memiliki etalase online yang rapi dan mudah dikelola.
                Dengan satu akun, penjual dapat menampilkan produk, mengatur harga, serta menerima pesanan secara terstruktur —
                sambil memperkuat citra brand di mata pelanggan.
            </p>
        </div>

        <div class="card-soft-about px-5 py-5 text-sm text-bcake-truffle/90 space-y-1.5">
            <p class="font-semibold text-bcake-wine">Berbasis di</p>
            <p>Bengkalis, Riau — Indonesia</p>
            <p class="font-semibold text-bcake-wine mt-3">Cakupan layanan</p>
            <p>Difokuskan untuk wilayah Bengkalis &amp; sekitarnya dengan potensi perluasan di masa depan.</p>
        </div>
    </div>

    {{-- TIM 3 ORANG --}}
    <div class="max-w-5xl mx-auto space-y-4" data-aos="fade-up" data-aos-delay="200">
        <h2 class="font-display text-2xl text-rose-900">Tim di balik B’cake</h2>
        <p class="text-sm text-bcake-truffle/90 leading-relaxed max-w-2xl">
            B’cake dikembangkan oleh tiga mahasiswa yang mencintai teknologi dan dessert.
            Kami berusaha menghadirkan platform yang tidak hanya berfungsi dengan baik,
            tetapi juga terasa hangat dan menyenangkan untuk digunakan.
        </p>

        <div class="grid gap-6 sm:grid-cols-3 max-w-4xl mx-auto">

            {{-- Warda --}}
            <div class="team-card px-5 py-7 flex flex-col items-center text-center">
                <div class="team-badge">
                    <span>🍓</span><span>UI &amp; konten</span>
                </div>
                <div class="team-photo mb-4">
                    W
                </div>
                <p class="font-semibold text-bcake-wine text-base md:text-lg">Warda Widya Ningsih</p>
                <p class="text-xs text-bcake-truffle/80 mt-1">Desain Antarmuka &amp; Konten</p>
            </div>

            {{-- Aidil --}}
            <div class="team-card px-5 py-7 flex flex-col items-center text-center">
                <div class="team-badge">
                    <span>🍒</span><span>Developer</span>
                </div>
                <div class="team-photo mb-4">
                    A
                </div>
                <p class="font-semibold text-bcake-wine text-base md:text-lg">Mhd. Aidil Syharon</p>
                <p class="text-xs text-bcake-truffle/80 mt-1">Developer &amp; Perancang Sistem</p>
            </div>

            {{-- Priska --}}
            <div class="team-card px-5 py-7 flex flex-col items-center text-center">
                <div class="team-badge">
                    <span>🧁</span><span>Analisis</span>
                </div>
                <div class="team-photo mb-4">
                    P
                </div>
                <p class="font-semibold text-bcake-wine text-base md:text-lg">Priska Liza Utami</p>
                <p class="text-xs text-bcake-truffle/80 mt-1">Analisis Kebutuhan &amp; Dokumentasi</p>
            </div>

        </div>
    </div>

    {{-- PENUTUP --}}
    <div class="text-center pt-4" data-aos="fade-up" data-aos-delay="240">
        <p class="text-sm text-bcake-truffle/90 max-w-2xl mx-auto leading-relaxed">
            Setiap kue punya cerita. B’cake hadir untuk membawa cerita itu sampai ke tanganmu —
            lewat tampilan yang elegan, pemesanan yang mudah, dan dukungan penuh untuk baker lokal Bengkalis.
        </p>
    </div>

</section>
@endsection
