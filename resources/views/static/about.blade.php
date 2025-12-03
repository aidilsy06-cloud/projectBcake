@extends('layouts.app')

@section('title', 'Tentang Kami — B’cake')
@section('meta_description', "Profil B’cake, marketplace kue elegan untuk Bengkalis.")

@push('head')  
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-truffle:#362320;
  }

  /* latar halaman lembut */
  body{
    background:#ffeef6;
  }

  /* =================== KONTEN BAWAH (MODEL GAMBAR KEDUA) =================== */

  .about-shell{
    max-width: 64rem;
    margin: 0 auto 4.5rem;
    padding: 2.75rem 1.25rem 4rem;
  }

  .about-main-card{
    background: linear-gradient(145deg,#ffe7f2,#ffd6e6 55%,#ffc5de 100%);
    box-shadow:0 18px 45px rgba(137,5,36,.16);
    border-radius: 1.75rem;
    padding: 2.3rem 1.8rem 2.6rem;
  }

  .about-row{
    display:grid;
    gap:1.8rem;
  }
  @media (min-width: 768px){
    .about-row--2col{
      grid-template-columns: minmax(0,1.6fr) minmax(0,1.1fr);
      align-items:start;
    }
    .about-row--3col{
      grid-template-columns: repeat(3,minmax(0,1fr));
    }
    .about-row--2col-balanced{
      grid-template-columns: repeat(2,minmax(0,1fr));
    }
  }

  .about-card-soft{
    background:#fff6fb;
    border-radius: 1.5rem;
    padding:1.5rem 1.4rem;
    box-shadow:0 10px 28px rgba(137,5,36,.12);
  }

  .about-pill{
    border-radius:999px;
    padding:.35rem .9rem;
    font-size:.78rem;
    background:#fff6fb;
    border:1px solid rgba(137,5,36,.10);
    display:inline-flex;
    align-items:center;
    gap:.45rem;
    color:#b4234a;
    font-weight:500;
  }
  .about-pill span.icon{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:18px;
    height:18px;
    border-radius:999px;
    background:#f97373;
    color:white;
    font-size:.7rem;
  }

  .about-title-main{
    font-family:"Playfair Display",serif;
    font-size:clamp(1.9rem,3vw,2.4rem);
    color:var(--bcake-deep);
    margin-top:1rem;
    margin-bottom:.8rem;
  }

  .about-text{
    font-size:.94rem;
    color:#6e3c4b;
    line-height:1.75;
  }

  .about-subtitle{
    font-family:"Playfair Display",serif;
    font-size:1.35rem;
    color:var(--bcake-deep);
    margin-bottom:.4rem;
  }

  .about-point-title{
    font-weight:600;
    color:var(--bcake-deep);
    font-size:.9rem;
  }
  .about-point-text{
    font-size:.84rem;
    color:#6e3c4b;
  }

  .about-footer-text{
    font-size:.85rem;
    color:#6e3c4b;
    text-align:center;
    margin-top:1.8rem;
  }

  .about-team-card{
    text-align:center;
    padding:1.4rem 1.1rem 1.8rem;
    border-radius:1.5rem;
    background:#fff6fb;
    box-shadow:0 12px 35px rgba(137,5,36,.14);
  }
  .about-team-photo{
    width:70px;
    height:70px;
    border-radius:999px;
    margin:0 auto .6rem;
    background:#ffe0ec;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:34px;
    color:var(--bcake-deep);
    border:3px solid #ffc8dc;
  }
  .about-team-name{
    font-size:.95rem;
    font-weight:600;
    color:var(--bcake-deep);
  }
  .about-team-role{
    font-size:.78rem;
    color:#8d5c68;
    margin-top:.25rem;
  }

  /* ================== HERO STRIPES ================== */

  .about-logo-hero{
    position: relative;
    width: 100%;
    max-width: 72rem;
    margin: 0 auto;
    border-radius: 2.4rem;
    padding: 4.4rem 1.8rem 4.6rem;
    overflow: hidden;
    box-shadow: 0 32px 90px rgba(137,5,36,0.18);
    background:
      radial-gradient(120% 120% at 50% 0%, rgba(255,255,255,.18) 0%, transparent 55%),
      repeating-linear-gradient(
        to bottom,
        #f7d2da 0px,
        #f7d2da 22px,
        #b55c69 22px,
        #b55c69 44px
      );
  }

  /* TOP DRIP */
  .about-logo-hero::before{
    content:"";
    position:absolute;
    left:-40px;
    right:-40px;
    top:0;
    height:58px;
    background:
      radial-gradient(circle at 18px 40px, #ffeef6 26px, transparent 27px) 0 0/72px 48px repeat-x,
      linear-gradient(#ffeef6 0 0) top/100% 26px no-repeat;
    z-index:1;
    pointer-events:none;
  }

  /* BOTTOM DRIP */
  .about-logo-hero::after{
    content:"";
    position:absolute;
    left:-40px;
    right:-40px;
    bottom:0;
    height:58px;
    background:
      radial-gradient(circle at 18px 18px, #ffeef6 26px, transparent 27px) 0 10px/72px 48px repeat-x,
      linear-gradient(#ffeef6 0 0) bottom/100% 26px no-repeat;
    z-index:1;
    pointer-events:none;
  }

  /* ============== GELEMBUNG CHERRY & PITA DARI BAWAH SAMPAI ATAS ============== */

  /* area bubble full tinggi hero */
  .about-hero-bubbles{
    position:absolute;
    inset:0;               /* full area hero */
    overflow:visible;
    pointer-events:none;
    z-index:2;
  }

  .bubble{
    position:absolute;
    bottom:-80px;          /* mulai sedikit keluar di bawah drip */
    width:58px;
    height:58px;
    border-radius:999px;
    background:rgba(255,237,245,.95);
    box-shadow:
      0 16px 35px rgba(137,5,36,.35),
      0 0 0 3px rgba(255,255,255,.85);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    animation: bubbleRise 10s linear infinite;
  }

  /* posisi & timing random biar natural */
  .bubble--1{ left:6%;  animation-duration:11s;  animation-delay:0s;   }
  .bubble--2{ left:18%; animation-duration:9.5s; animation-delay:2s;   }
  .bubble--3{ left:32%; animation-duration:12s;  animation-delay:1s;   }
  .bubble--4{ left:50%; animation-duration:10.5s;animation-delay:3s;   }
  .bubble--5{ left:68%; animation-duration:9s;   animation-delay:1.8s; }
  .bubble--6{ left:82%; animation-duration:11.5s;animation-delay:4s;   }
  .bubble--7{ left:92%; animation-duration:9.5s; animation-delay:5s;   }

  @keyframes bubbleRise{
    0%{
      transform:translateY(40px) scale(.8);   /* agak turun dulu */
      opacity:0;
    }
    15%{
      opacity:1;
    }
    55%{
      /* posisi kira2 di area judul / oval putih */
      transform:translateY(-220px) scale(1.03);
      opacity:1;
    }
    85%{
      opacity:.35;
    }
    100%{
      /* naik melewati bagian atas stripes (garis biru kamu) */
      transform:translateY(-420px) scale(.96);
      opacity:0;
    }
  }

  .about-logo-card{
    display:flex;
    align-items:center;
    justify-content:center;
    margin-top: 1.2rem;
    margin-bottom: 1.2rem;
    width: 120px;
    height: 120px;
    padding: 8px;
    border-radius: 1.9rem;
    background: rgba(255,255,255,.86);
    box-shadow:
      0 26px 55px rgba(0,0,0,.22),
      0 0 0 8px rgba(255,255,255,.35);
    backdrop-filter: blur(7px);
    position: relative;
    z-index:3;
    animation: heroLogoFloat 4.5s ease-in-out infinite;
  }

  .about-logo-inner{
    width: 100%;
    height: 100%;
    border-radius: 1.5rem;
    background:#5b061d;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 18px 40px rgba(72,0,22,.8);
  }
  .about-logo-inner img{
    width: 65%;
    height: 65%;
    object-fit: contain;
  }

  .about-hero-copy{
    margin-top: .5rem;
    padding: 1.2rem 2.4rem;
    background: linear-gradient(135deg,
        rgba(255,249,252,.95),
        rgba(255,233,244,.95)
    );
    border-radius: 999px;
    box-shadow:
      0 12px 32px rgba(137,5,36,.16),
      0 0 0 1px rgba(255,255,255,.8);
    display: inline-flex;
    flex-direction: column;
    gap: .45rem;
    align-items: center;
    position:relative;
    z-index:3;
  }

  @media (max-width: 768px){
    .about-logo-hero{
      padding-inline:1.4rem;
    }
    .about-hero-copy{
      padding: .9rem 1.6rem;
      border-radius: 1.4rem;
    }
  }

  .about-hero-title{
    font-family: 'Playfair Display', 'Poppins', system-ui, serif;
    font-size: clamp(2.1rem, 4vw, 3rem);
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--bcake-deep);
    text-shadow:
      0 2px 8px rgba(0,0,0,.12),
      0 3px 14px rgba(255,255,255,.7);
    animation: heroTextFloat 4s ease-in-out infinite;
  }

  .about-hero-sub{
    font-size:.95rem;
    max-width: 36rem;
    color: rgba(54,35,32,.92);
    text-shadow: 0 1px 4px rgba(255,255,255,.8);
    animation: heroTextFloat 4s ease-in-out infinite;
    animation-delay: .18s;
  }

  @keyframes heroLogoFloat{
    0%   { transform:translateY(0); }
    50%  { transform:translateY(-10px); }
    100% { transform:translateY(0); }
  }

  @keyframes heroTextFloat{
    0%   { transform:translateY(0); }
    50%  { transform:translateY(-6px); }
    100% { transform:translateY(0); }
  }
</style>
@endpush

@section('content')
<section class="space-y-10 md:space-y-14">

  {{-- tombol kembali --}}
  <div class="max-w-6xl mx-auto px-4 pt-4">
      <a href="javascript:history.back()"
         class="inline-flex items-center gap-2 px-5 py-2 rounded-full 
                bg-rose-200 text-bcake-wine font-medium 
                shadow-md hover:bg-rose-300 hover:shadow-lg transition">
          ← Kembali
      </a>
  </div>

  {{-- HERO STRIPES: logo + judul + tagline --}}
  <div class="about-logo-hero mt-2 flex flex-col items-center gap-4 text-center">

      {{-- banyak bubble cherry & pita --}}
      <div class="about-hero-bubbles" aria-hidden="true">
          <span class="bubble bubble--1">🍒</span>
          <span class="bubble bubble--2">🎀</span>
          <span class="bubble bubble--3">🍒</span>
          <span class="bubble bubble--4">🎀</span>
          <span class="bubble bubble--5">🍒</span>
          <span class="bubble bubble--6">🎀</span>
          <span class="bubble bubble--7">🍒</span>
      </div>

      <div class="about-logo-card">
          <div class="about-logo-inner">
              <img src="{{ asset('image/logo_bcake.jpg') }}" alt="Logo B’cake">
          </div>
      </div>

      <div class="about-hero-copy">
          <h1 class="about-hero-title">
              TENTANG B’CAKE
          </h1>
          <p class="about-hero-sub">
              Marketplace kue elegan yang mempertemukan baker &amp; UMKM lokal Bengkalis
              dengan pecinta dessert dalam satu ruang digital yang manis dan hangat.
          </p>
      </div>
  </div>

  {{-- ====================== KONTEN MODEL GAMBAR KEDUA ====================== --}}
  <div class="about-shell">
    <div class="about-main-card space-y-8">

      {{-- baris 1: profil singkat + card samping --}}
      <div class="about-row about-row--2col">
        <div>
          <span class="about-pill">
            <span class="icon">i</span>
            Profil singkat
          </span>
          <h2 class="about-title-main">
            Marketplace kue elegan untuk Bengkalis.
          </h2>
          <p class="about-text">
            B’cake adalah platform pemesanan kue yang mempertemukan
            <strong>baker &amp; UMKM lokal</strong> dengan pecinta dessert dalam satu tempat yang rapi,
            manis, dan mudah digunakan. Kami ingin setiap pemesanan kue favorit terasa hangat,
            menyenangkan, dan penuh kejutan manis.
          </p>
        </div>

        <div class="about-card-soft">
          <p class="about-text">
            Lewat tampilan yang lembut dan alur pemesanan yang sederhana, B’cake
            membantu pembeli menemukan kue terbaik sekaligus memberikan ruang digital
            yang layak untuk baker lokal menampilkan karya manis mereka.
          </p>
        </div>
      </div>

      {{-- baris 2: apa & mengapa --}}
      <div class="about-row about-row--2col-balanced">
        <div class="about-card-soft">
          <h3 class="about-subtitle">Apa itu B’cake?</h3>
          <p class="about-text">
            B’cake bukan toko kue tunggal — melainkan
            <strong>marketplace</strong> yang menampung banyak penjual.
            Setiap baker memiliki halaman toko dan katalog produk sendiri.
            Pembeli bisa menjelajah menu, melihat detail foto dan deskripsi,
            menambahkan ke keranjang, lalu melanjutkan pemesanan yang
            diteruskan ke WhatsApp untuk konfirmasi akhir.
          </p>
        </div>

        <div class="about-card-soft">
          <h3 class="about-subtitle">Mengapa B’cake dibuat?</h3>
          <p class="about-text">
            Di Bengkalis ada banyak pembuat kue hebat, namun belum semuanya memiliki ruang digital
            yang tertata. B’cake hadir sebagai wadah yang elegan: memudahkan pembeli menemukan
            dessert favoritnya sambil membantu UMKM tampil lebih profesional tanpa harus
            membangun website sendiri.
          </p>
        </div>
      </div>

      {{-- baris 3: kenapa memilih --}}
      <div class="about-card-soft">
        <h3 class="about-subtitle">Kenapa memilih B’cake?</h3>
        <div class="about-row about-row--3col" style="margin-top:1rem;">
          <div>
            <p class="about-point-title">Katalog kue lengkap &amp; terkurasi</p>
            <p class="about-point-text">
              Dari custom cake, dessert box, hingga snack manis —
              semuanya disusun dalam kategori yang rapi sehingga
              memudahkan kamu menemukan kue untuk setiap momen.
            </p>
          </div>
          <div>
            <p class="about-point-title">Desain manis &amp; responsif</p>
            <p class="about-point-text">
              Tampilan bertema pink–wine yang lembut, nyaman dilihat
              di ponsel hingga laptop. Bikin cari kue serasa
              scrolling moodboard estetik.
            </p>
          </div>
          <div>
            <p class="about-point-title">Pemesanan cepat via WhatsApp</p>
            <p class="about-point-text">
              Setelah memilih produk, detail pesanan akan dirangkum
              rapi lalu dikirim ke WhatsApp penjual untuk
              diskusi dan konfirmasi yang lebih fleksibel.
            </p>
          </div>
        </div>
      </div>

      {{-- baris 4: dukungan UMKM & lokasi --}}
      <div class="about-row about-row--2col-balanced">
        <div class="about-card-soft">
          <h3 class="about-subtitle">Dukungan untuk UMKM lokal</h3>
          <p class="about-text">
            B’cake didedikasikan untuk pelaku usaha kue di Bengkalis agar memiliki
            etalase online yang rapi dan mudah dikelola. Melalui satu akun, penjual
            dapat menampilkan produk, mengatur harga, hingga menerima pesanan secara
            terstruktur — tanpa menghilangkan ciri khas dan kehangatan layanan mereka.
          </p>
        </div>

        <div class="about-card-soft">
          <p class="about-point-title">Berbasis di</p>
          <p class="about-point-text">Bengkalis, Riau — Indonesia</p>

          <p class="about-point-title" style="margin-top:1rem;">Cakupan layanan</p>
          <p class="about-point-text">
            Difokuskan untuk wilayah Bengkalis &amp; sekitarnya dengan
            peluang perluasan area di masa mendatang.
          </p>
        </div>
      </div>

      {{-- baris 5: tim --}}
      <div class="about-row about-row--2col-balanced">
        <div class="about-card-soft">
          <h3 class="about-subtitle">Tim di balik B’cake</h3>
          <p class="about-text">
            B’cake dikembangkan oleh tiga mahasiswa yang mencintai teknologi dan dessert.
            Kami ingin menghadirkan platform yang bukan hanya berfungsi dengan baik,
            tetapi juga terasa hangat dan menyenangkan untuk digunakan.
          </p>
        </div>

        <div class="about-row about-row--3col" style="gap:1rem;">
          <div class="about-team-card">
            <div class="about-team-photo">W</div>
            <p class="about-team-name">Warda Widya Ningsih</p>
            <p class="about-team-role">UI &amp; Konten</p>
          </div>
          <div class="about-team-card">
            <div class="about-team-photo">A</div>
            <p class="about-team-name">Mhd. Aidil Syharon</p>
            <p class="about-team-role">Developer</p>
          </div>
          <div class="about-team-card">
            <div class="about-team-photo">P</div>
            <p class="about-team-name">Priska Liza Utami</p>
            <p class="about-team-role">Analisis &amp; Dokumentasi</p>
          </div>
        </div>
      </div>

      {{-- baris 6: penutup --}}
      <p class="about-footer-text">
        Setiap kue punya cerita. B’cake hadir untuk membawa cerita itu sampai ke tanganmu —
        lewat tampilan yang elegan, pemesanan yang mudah, dan dukungan penuh untuk baker lokal Bengkalis.
      </p>

    </div>
  </div>
</section>
@endsection
