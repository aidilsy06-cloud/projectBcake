<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Daftar — B’cake</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    :root{
      --pink-50:#fff1f5; --pink-100:#ffe4ec; --pink-200:#fecdd6; --pink-300:#fda4af;
      --pink-600:#e11d48; --pink-700:#be123c; --deep:#890524;
      --cream:#faf6f7; --shadow:0 30px 60px rgba(244,63,94,.12);
    }

    html,body{ height:100%; }

    body{
      min-height:100vh;
      background:
        radial-gradient(1000px 420px at 82% -90px, var(--pink-100), transparent 60%),
        radial-gradient(800px 320px at -8% 8%, var(--pink-50), transparent 60%),
        linear-gradient(180deg, var(--cream), #fff);
    }

    /* ⛔ Desktop no scroll */
    @media (min-width:768px){
      body{ overflow:hidden; }
    }

    .card{
      background:#fff;
      border-radius:1.25rem;
      box-shadow:var(--shadow);
    }

    .welcome{
      background: linear-gradient(150deg, var(--pink-600), var(--pink-700));
      border-top-left-radius: 1.25rem;
      border-bottom-left-radius: 1.25rem;
      border-top-right-radius: 4.25rem;
      border-bottom-right-radius: 4.25rem;
      color:#fff;
      box-shadow: inset 0 0 0 1px rgba(255,255,255,.06);
    }

    .btn-primary{
      background:var(--pink-600);
      color:#fff;
      border-radius:.9rem;
      padding:.7rem 1rem;
    }
    .btn-primary:hover{ background:var(--pink-700); }

    .btn-outline{
      border:1px solid rgba(255,255,255,.75);
      color:#fff;
      border-radius:.9rem;
      padding:.55rem 1rem;
    }
    .btn-outline:hover{ background:#fff; color:var(--pink-700); }

    .ring-pink:focus{
      outline:none;
      box-shadow:0 0 0 4px rgba(244,63,94,.25);
    }

    /* ===== Slide transitions (sama login) ===== */
    .slide-in-right  { animation: slideInRight .35s ease-out both; }
    .slide-in-left   { animation: slideInLeft  .35s ease-out both;  }
    .slide-out-left  { animation: slideOutLeft .28s ease-in both;   }
    .slide-out-right { animation: slideOutRight .28s ease-in both;  }

    @keyframes slideInRight { from {opacity:0; transform:translateX(40px)} to {opacity:1; transform:none} }
    @keyframes slideInLeft  { from {opacity:0; transform:translateX(-40px)} to {opacity:1; transform:none} }
    @keyframes slideOutLeft { from {opacity:1; transform:none} to {opacity:0; transform:translateX(-40px)} }
    @keyframes slideOutRight{ from {opacity:1; transform:none} to {opacity:0; transform:translateX(40px)} }

    /* ===== MESIS JATUH ===== */
    .sprinkles{
      position:fixed;
      inset:0;
      pointer-events:none;
      overflow:hidden;
      z-index:0;
    }
    .sprinkle{
      position:absolute;
      top:-20px;
      width:6px;
      height:16px;
      border-radius:3px;
      background: var(--spr-color, var(--pink-600));
      transform: rotate(var(--rot, 25deg));
      opacity:.9;
      filter: blur(.1px);
      animation: drop linear infinite;
    }
    @keyframes drop{
      from{ transform: translateY(-40px) rotate(var(--rot,25deg)); }
      to  { transform: translateY(110vh) rotate(calc(var(--rot,25deg))); }
    }
    .sprinkle:nth-child(4n){ --spr-color:#fb7185; }
    .sprinkle:nth-child(4n+1){ --spr-color:#fda4af; }
    .sprinkle:nth-child(4n+2){ --spr-color:#be123c; }
    .sprinkle:nth-child(4n+3){ --spr-color:#6b3a31; }

    /* ===== STRAWBERRY GLOSSY (simple) ===== */
    .berryLayer{
      position:fixed;
      inset:0;
      pointer-events:none;
      z-index:0;
      overflow:hidden;
    }
    .berry{
      position:absolute;
      top:-160px;
      width: clamp(76px, 8vw, 124px);
    }
    .berryFall{
      animation:
        berryDrop var(--dur,10s) linear var(--delay,0s) infinite,
        berrySway 4.5s ease-in-out calc(var(--delay,0s) * .6) infinite;
    }
    @keyframes berryDrop{
      from{ transform: translateY(-20vh) rotate(var(--rot,-8deg)); }
      to  { transform: translateY(120vh) rotate(calc(var(--rot,-8deg) + 36deg)); }
    }
    @keyframes berrySway{
      0%,100%{ translate:0 0 }
      50%{ translate:10px 0 }
    }
  </style>
</head>

<body class="min-h-screen grid place-items-center p-4 md:p-6">

  {{-- MESIS --}}
  <div class="sprinkles" aria-hidden="true">
    @for ($i=0; $i<70; $i++)
      @php
        $left  = rand(0,100);
        $delay = rand(0,2000)/1000;
        $dur   = rand(4000,9000)/1000;
        $rot   = rand(-40,40);
      @endphp
      <span class="sprinkle"
            style="left:{{ $left }}%; animation-duration:{{ $dur }}s; animation-delay:{{ $delay }}s; --rot:{{ $rot }}deg;"></span>
    @endfor
  </div>

  {{-- STRAWBERRY SYMBOL --}}
  <svg width="0" height="0" style="position:absolute">
    <defs>
      <linearGradient id="berryFill" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%" stop-color="#ff6a8a"/>
        <stop offset="50%" stop-color="#ff4d6d"/>
        <stop offset="100%" stop-color="#b1123a"/>
      </linearGradient>
      <symbol id="strawberryHD" viewBox="0 0 128 128">
        <path d="M64 118c-26 0-50-35-44-60 7-30 40-28 44-8 4-20 37-22 44 8 6 25-18 60-44 60z"
              fill="url(#berryFill)"/>
      </symbol>
    </defs>
  </svg>

  {{-- STRAWBERRY LAYER --}}
  <div class="berryLayer" aria-hidden="true">
    @for ($i=0; $i<10; $i++)
      @php
        $left  = rand(0,100);
        $delay = rand(0,5000)/1000;
        $dur   = rand(9000,15000)/1000;
        $rot   = rand(-12,12);
      @endphp
      <svg class="berry berryFall"
           style="left:{{ $left }}%; --delay:{{ $delay }}s; --dur:{{ $dur }}s; --rot:{{ $rot }}deg;">
        <use href="#strawberryHD"></use>
      </svg>
    @endfor
  </div>

  {{-- CARD SPLIT --}}
  <div id="pageCard" class="w-full max-w-5xl card overflow-hidden relative z-[1]">
    <div class="grid md:grid-cols-2">

      {{-- LEFT: Welcome --}}
      <div class="relative hidden md:block">
        <div class="absolute inset-0 grid place-items-center px-10">
          <div class="welcome p-9 w-[92%]">
            <a href="{{ url('/') }}" class="text-sm">← Kembali</a>

            <h2 class="text-2xl font-semibold mt-6">Hello, Welcome! ✨</h2>
            <p class="mt-2 text-white/90 text-sm">
              Yuk daftar dulu, pilih mau jadi Pembeli atau Penjual.
              Buka etalase kue cantikmu atau pesan kue favoritmu di B’cake 🍰
            </p>

            <p class="mt-6 text-sm text-white/90">
              Sudah punya akun?
            </p>
            <a href="{{ route('login') }}" data-slide="to-login"
               class="btn-outline mt-3 inline-flex items-center gap-2">
              <span>Login</span>
            </a>
          </div>
        </div>
        {{-- tinggi dummy disamain biar mirip login --}}
        <div class="pb-[58%]"></div>
      </div>

      {{-- RIGHT: Register form --}}
      <div class="p-7 md:p-9 flex flex-col justify-center">
        {{-- Header kecil --}}
        <div class="flex items-center justify-between mb-5">
          <div class="inline-flex items-center gap-2">
            <span class="inline-grid place-items-center w-9 h-9 rounded-xl" style="background:var(--pink-100)">🍰</span>
            <span class="font-semibold" style="color:var(--deep)">B’cake</span>
          </div>
          <a href="{{ url('/') }}" class="text-sm" style="color:var(--pink-600)">Kembali</a>
        </div>

        <h1 class="text-2xl font-semibold text-gray-900">Buat Akun</h1>
        <p class="text-sm text-gray-500 mt-1">
          Isi data singkat untuk mulai belanja atau jualan kue di B’cake.
        </p>

        @if ($errors->any())
          <div class="mt-3 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 px-3 py-2 text-sm">
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="mt-5 space-y-3"
              x-data="{ show1:false, show2:false }">
          @csrf

          {{-- Nama & Email: hemat tinggi --}}
          <div class="space-y-3">
            <div>
              <label class="block text-xs font-medium text-gray-700">Nama</label>
              <input type="text" name="name" required
                     class="w-full rounded-xl border-gray-300 px-3 py-2 ring-pink text-sm"
                     placeholder="Masukkan nama lengkap"
                     value="{{ old('name') }}">
            </div>

            <div>
              <label class="block text-xs font-medium text-gray-700">Email</label>
              <input type="email" name="email" required
                     class="w-full rounded-xl border-gray-300 px-3 py-2 ring-pink text-sm"
                     placeholder="contoh: kamu@bcake.local"
                     value="{{ old('email') }}">
            </div>
          </div>

          {{-- Password & Konfirmasi dalam 2 kolom --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-medium text-gray-700">Password</label>
              <div class="relative">
                <input :type="show1 ? 'text' : 'password'"
                       name="password" required
                       class="w-full rounded-xl border-gray-300 px-3 py-2 ring-pink text-sm"
                       placeholder="Min. 8 karakter">
                <button type="button" @click="show1=!show1"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs"
                        style="color:var(--pink-700)">
                  Lihat
                </button>
              </div>
            </div>

            <div>
              <label class="block text-xs font-medium text-gray-700">Ulangi Password</label>
              <div class="relative">
                <input :type="show2 ? 'text' : 'password'"
                       name="password_confirmation" required
                       class="w-full rounded-xl border-gray-300 px-3 py-2 ring-pink text-sm"
                       placeholder="Ketik ulang password">
                <button type="button" @click="show2=!show2"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs"
                        style="color:var(--pink-700)">
                  Lihat
                </button>
              </div>
            </div>
          </div>

          {{-- Role pilihan: compact --}}
          <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Daftar sebagai</label>
            <div class="grid grid-cols-2 gap-2 text-xs">
              <label
                class="border rounded-2xl px-3 py-2 cursor-pointer flex gap-2 items-start"
                :class="{'ring-2 ring-rose-500 border-transparent': $refs.buyer.checked}">
                <input type="radio" name="role" value="buyer" class="mt-1" checked x-ref="buyer">
                <span>
                  <span class="font-semibold block text-[0.8rem]">Pembeli</span>
                  <span class="text-gray-600 text-[0.72rem]">Belanja dan pesan kue.</span>
                </span>
              </label>

              <label
                class="border rounded-2xl px-3 py-2 cursor-pointer flex gap-2 items-start"
                :class="{'ring-2 ring-rose-500 border-transparent': $refs.seller.checked}">
                <input type="radio" name="role" value="seller" class="mt-1" x-ref="seller">
                <span>
                  <span class="font-semibold block text-[0.8rem]">Penjual (Seller)</span>
                  <span class="text-gray-600 text-[0.72rem]">Buka etalase dan jualan.</span>
                </span>
              </label>
            </div>
          </div>

          {{-- Agreement --}}
          <label class="inline-flex items-start gap-2 text-xs text-gray-700 mt-1">
            <input type="checkbox" required class="mt-0.5 rounded border-gray-300">
            <span>Saya setuju dengan <a href="#" class="text-pink-700 underline">Syarat &amp; Ketentuan</a>.</span>
          </label>

          {{-- Button --}}
          <button type="submit" class="w-full btn-primary mt-2 text-sm">
            Daftar
          </button>

          <p class="text-center text-xs text-gray-600 mt-1">
            Sudah punya akun?
            <a href="{{ route('login') }}" data-slide="to-login"
               class="font-medium" style="color:var(--pink-700)">Masuk</a>
          </p>
        </form>
      </div>
    </div>
  </div>

  {{-- SLIDE SCRIPT (sama logic seperti login) --}}
  <script>
    (function () {
      const card = document.getElementById('pageCard');
      const dir = sessionStorage.getItem('bcake_nav_dir'); // 'to-register' | 'to-login'

      if (dir === 'to-login')      card.classList.add('slide-in-left');
      else if (dir === 'to-register') card.classList.add('slide-in-right');
      else                          card.classList.add('slide-in-right');

      sessionStorage.removeItem('bcake_nav_dir');

      document.querySelectorAll('[data-slide]').forEach(a => {
        a.addEventListener('click', function (e) {
          const next = this.getAttribute('href'); if (!next) return;
          e.preventDefault();
          const to = this.dataset.slide;

          sessionStorage.setItem('bcake_nav_dir', to);
          card.classList.remove('slide-in-left','slide-in-right');
          card.classList.add(to === 'to-register' ? 'slide-out-left' : 'slide-out-right');

          setTimeout(() => { window.location.href = next; }, 230);
        });
      });
    })();
  </script>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
