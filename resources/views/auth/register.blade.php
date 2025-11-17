<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Daftar — B’cake</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    :root{
      /* B’cake palette */
      --pink-50:#fff1f5; --pink-100:#ffe4ec; --pink-200:#fecdd6; --pink-300:#fda4af;
      --pink-600:#e11d48; --pink-700:#be123c; --deep:#890524;
      --cream:#faf6f7; --shadow:0 30px 60px rgba(244,63,94,.12);
    }
    body{
      min-height:100vh;
      background:
        radial-gradient(1000px 420px at 82% -90px, var(--pink-100), transparent 60%),
        radial-gradient(800px 320px at -8% 8%, var(--pink-50), transparent 60%),
        linear-gradient(180deg, var(--cream), #fff);
    }
    .card{ background:#fff; border-radius:1.25rem; box-shadow:var(--shadow); }

    /* Welcome panel di KANAN (kebalikan login) */
    .welcome{
      background: linear-gradient(150deg, var(--pink-600), var(--pink-700));
      border-top-right-radius: 1.25rem;
      border-bottom-right-radius: 1.25rem;
      border-top-left-radius: 4.25rem;
      border-bottom-left-radius: 4.25rem;
      color:#fff;
      box-shadow: inset 0 0 0 1px rgba(255,255,255,.06);
    }
    .btn-primary{ background:var(--pink-600); color:#fff; border-radius:.9rem; padding:.7rem 1rem; }
    .btn-primary:hover{ background:var(--pink-700); }
    .btn-outline{ border:1px solid rgba(255,255,255,.75); color:#fff; border-radius:.9rem; padding:.55rem 1rem; }
    .btn-outline:hover{ background:#fff; color:var(--pink-700); }
    .ring-pink:focus{ outline:none; box-shadow:0 0 0 4px rgba(244,63,94,.25); }

    /* ===== Slide transitions (masuk/keluar samping) ===== */
    .slide-in-right  { animation: slideInRight .35s ease-out both; }
    .slide-in-left   { animation: slideInLeft  .35s ease-out both;  }
    .slide-out-left  { animation: slideOutLeft .28s ease-in both;   }
    .slide-out-right { animation: slideOutRight .28s ease-in both;  }
    @keyframes slideInRight { from {opacity:0; transform:translateX(40px)} to {opacity:1; transform:none} }
    @keyframes slideInLeft  { from {opacity:0; transform:translateX(-40px)} to {opacity:1; transform:none} }
    @keyframes slideOutLeft { from {opacity:1; transform:none} to {opacity:0; transform:translateX(-40px)} }
    @keyframes slideOutRight{ from {opacity:1; transform:none} to {opacity:0; transform:translateX(40px)} }

    /* ===== MESIS ===== */
    .sprinkles{ position:fixed; inset:0; pointer-events:none; overflow:hidden; z-index:0; }
    .sprinkle{
      position:absolute; top:-20px; width:6px; height:16px; border-radius:3px;
      background: var(--spr-color, var(--pink-600));
      transform: rotate(var(--rot, 25deg)); opacity:.9; filter: blur(.1px);
      animation: drop linear infinite;
    }
    @keyframes drop{ from{ transform: translateY(-40px) rotate(var(--rot,25deg)); }
                     to  { transform: translateY(110vh) rotate(var(--rot,25deg)); } }
    .sprinkle:nth-child(4n){ --spr-color:#fb7185; }
    .sprinkle:nth-child(4n+1){ --spr-color:#fda4af; }
    .sprinkle:nth-child(4n+2){ --spr-color:#be123c; }
    .sprinkle:nth-child(4n+3){ --spr-color:#6b3a31; }

    /* ===== STRAWBERRY ===== */
    .berryLayer{ position:fixed; inset:0; pointer-events:none; z-index:0; overflow:hidden; }
    .berry{ position:absolute; top:-160px; width: clamp(76px, 8vw, 124px); }
    .berryFall{
      animation:
        berryDrop var(--dur,10s) linear var(--delay,0s) infinite,
        berrySway 4.5s ease-in-out calc(var(--delay,0s) * .6) infinite;
    }
    @keyframes berryDrop{ from{ transform: translateY(-20vh) rotate(var(--rot,-8deg)); }
                          to  { transform: translateY(120vh) rotate(calc(var(--rot,-8deg) + 36deg)); } }
    @keyframes berrySway{ 0%,100%{ translate:0 0 } 50%{ translate:10px 0 } }
  </style>
</head>
<body class="min-h-screen grid place-items-center p-6">

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

  {{-- STRAWBERRY SPRITE --}}
  <svg width="0" height="0" style="position:absolute">
    <defs>
      <linearGradient id="berryFill" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%" stop-color="#ff6a8a"/>
        <stop offset="50%" stop-color="#ff4d6d"/>
        <stop offset="100%" stop-color="#b1123a"/>
      </linearGradient>
      <linearGradient id="leafFill" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0%" stop-color="#8dd417"/>
        <stop offset="100%" stop-color="#2b9c00"/>
      </linearGradient>
      <linearGradient id="gloss" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0%" stop-color="rgba(255,255,255,.98)"/>
        <stop offset="35%" stop-color="rgba(255,255,255,.45)"/>
        <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
      </linearGradient>
      <radialGradient id="rim" cx="80%" cy="10%" r="60%">
        <stop offset="0%" stop-color="rgba(255,255,255,.6)"/>
        <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
      </radialGradient>

      <symbol id="strawberryHD" viewBox="0 0 128 128" shape-rendering="geometricPrecision">
        <path d="M64 118c-26 0-50-35-44-60 7-30 40-28 44-8 4-20 37-22 44 8 6 25-18 60-44 60z"
              fill="url(#berryFill)"/>
        <ellipse cx="88" cy="24" rx="30" ry="18" fill="url(#rim)"/>
        <path d="M45 26c8 5 19 7 31 0 0 0-9 14-15 14S45 26 45 26z"
              fill="url(#leafFill)"/>
        <path d="M52 25c6 3 12 4 21 0 -4 6-8 9-11 9s-10-6-10-9z"
              fill="#2a8f00" opacity=".22"/>
        <g fill="#ffd3db" opacity=".95">
          <circle cx="48" cy="66" r="2.6"/>
          <circle cx="66" cy="76" r="2.6"/>
          <circle cx="82" cy="60" r="2.6"/>
          <circle cx="54" cy="88" r="2.6"/>
          <circle cx="74" cy="94" r="2.3"/>
          <circle cx="90" cy="78" r="2.3"/>
          <circle cx="36" cy="76" r="2.3"/>
          <circle cx="58" cy="70" r="2.3"/>
        </g>
        <path d="M34 56c12-24 42-28 58-12 3 3 3 7 1 10-12-9-26-11-39-6-8 3-14 7-20 14z"
              fill="url(#gloss)"/>
      </symbol>
    </defs>
  </svg>

  {{-- LAYER STRAWBERRY JATUH --}}
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

  {{-- CARD SPLIT: Form kiri, Welcome kanan --}}
  <div id="pageCard" class="w-full max-w-5xl card overflow-hidden relative z-[1]">
    <div class="grid md:grid-cols-2">

      {{-- LEFT: Register form --}}
      <div class="p-7 md:p-10">
        <div class="flex items-center justify-between mb-6">
          <div class="inline-flex items-center gap-2">
            <span class="inline-grid place-items-center w-9 h-9 rounded-xl" style="background:var(--pink-100)">🍰</span>
            <span class="font-semibold" style="color:var(--deep)">B’cake</span>
          </div>
          <a href="{{ url('/') }}" class="text-sm" style="color:var(--pink-600)">Kembali</a>
        </div>

        <h1 class="text-2xl font-semibold text-gray-900">Buat Akun</h1>
        <p class="text-sm text-gray-500 mt-1">
          Yuk daftar dulu, pilih mau jadi <span class="font-medium" style="color:var(--pink-700)">Pembeli</span> atau
          <span class="font-medium" style="color:var(--pink-700)">Penjual (Seller)</span>.
        </p>

        {{-- Error global --}}
        @if ($errors->any())
          <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 px-3 py-2 text-sm">
            {{ $errors->first() }}
          </div>
        @endif

        @php
          $loginUrl = Route::has('login') ? route('login') : url('/login');
          $registerUrl = Route::has('register') ? route('register') : url('/register');
          $oldRole = old('role','buyer');
        @endphp

        <form method="POST" action="{{ $registerUrl }}" class="mt-6 space-y-4">
          @csrf

          {{-- Nama --}}
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input id="name" name="name" type="text" required value="{{ old('name') }}"
                   class="w-full rounded-xl border-gray-300 px-4 py-2 ring-pink"
                   placeholder="Nama lengkap">
            @error('name') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
          </div>

          {{-- Email --}}
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" required value="{{ old('email') }}"
                   class="w-full rounded-xl border-gray-300 px-4 py-2 ring-pink"
                   placeholder="kamu@contoh.com">
            @error('email') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
          </div>

          {{-- Password + Konfirmasi --}}
          <div class="grid md:grid-cols-2 gap-3">
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input id="password" name="password" type="password" required
                     class="w-full rounded-xl border-gray-300 px-4 py-2 ring-pink"
                     autocomplete="new-password">
              @error('password') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>
            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Ulangi Password</label>
              <input id="password_confirmation" name="password_confirmation" type="password" required
                     class="w-full rounded-xl border-gray-300 px-4 py-2 ring-pink"
                     autocomplete="new-password">
            </div>
          </div>

          {{-- ROLE: buyer / seller --}}
          <div>
            <span class="block text-sm font-medium text-gray-700 mb-1">Daftar sebagai</span>
            <div class="flex flex-wrap gap-3 text-sm">
              <label class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border cursor-pointer
                            @if($oldRole === 'buyer') border-rose-400 bg-rose-50 @else border-gray-200 bg-white @endif">
                <input type="radio" name="role" value="buyer" class="text-rose-600"
                       @checked($oldRole === 'buyer')>
                <div class="flex flex-col leading-tight">
                  <span class="font-medium text-gray-800">Pembeli</span>
                  <span class="text-xs text-gray-500">Belanja dan pesan kue di B’cake</span>
                </div>
              </label>

              <label class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border cursor-pointer
                            @if($oldRole === 'seller') border-rose-400 bg-rose-50 @else border-gray-200 bg-white @endif">
                <input type="radio" name="role" value="seller" class="text-rose-600"
                       @checked($oldRole === 'seller')>
                <div class="flex flex-col leading-tight">
                  <span class="font-medium text-gray-800">Penjual (Seller)</span>
                  <span class="text-xs text-gray-500">Buka etalase toko dan jualan kue</span>
                </div>
              </label>
            </div>
            @error('role') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
          </div>

          {{-- Terms --}}
          <label class="inline-flex items-start gap-2 text-sm text-gray-700">
            <input type="checkbox" name="terms" required
                   class="mt-1 rounded border-gray-300 text-rose-600 focus:ring-rose-500">
            <span>
              Saya setuju dengan
              <a href="#" class="underline" style="color:var(--pink-700)">Syarat &amp; Ketentuan</a>.
            </span>
          </label>

          {{-- Tombol submit --}}
          <button type="submit" class="w-full btn-primary">Daftar</button>

          <p class="text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ $loginUrl }}" data-slide="to-login" class="font-medium" style="color:var(--pink-700)">
              Masuk
            </a>
          </p>
        </form>
      </div>

      {{-- RIGHT: Welcome panel (pink gradient) --}}
      <div class="relative hidden md:block">
        <div class="absolute inset-0 grid place-items-center px-10">
          <div class="welcome p-10 md:p-12 w-[92%]">
            <h2 class="text-2xl font-semibold">Welcome Back!</h2>
            <p class="mt-2 text-white/90 text-sm">Sudah punya akun? Langsung login aja yuk.</p>
            <a href="{{ $loginUrl }}" data-slide="to-login"
               class="btn-outline mt-5 inline-flex items-center gap-2">
              <span>Login</span>
            </a>
          </div>
        </div>
        <div class="pb-[62%]"></div>
      </div>

    </div>
  </div>

  {{-- Transisi navigasi: slide out + arah masuk halaman tujuan --}}
  <script>
    (function () {
      const card = document.getElementById('pageCard');

      // Arah masuk: kalau datang dari login → register masuk dari kanan
      const dir = sessionStorage.getItem('bcake_nav_dir'); // 'to-register' | 'to-login'
      if (dir === 'to-register') {
        card.classList.add('slide-in-right');
      } else if (dir === 'to-login') {
        card.classList.add('slide-in-left');
      } else {
        // default saat direct hit register
        card.classList.add('slide-in-right');
      }
      sessionStorage.removeItem('bcake_nav_dir');

      // Klik link: simpan arah & animasi keluar
      document.querySelectorAll('[data-slide]').forEach(a => {
        a.addEventListener('click', function (e) {
          const next = this.getAttribute('href');
          if (!next) return;
          e.preventDefault();

          const to = this.dataset.slide; // 'to-login'
          sessionStorage.setItem('bcake_nav_dir', to);

          // dari register -> login: geser keluar ke kanan
          card.classList.remove('slide-in-left', 'slide-in-right');
          card.classList.add(to === 'to-register' ? 'slide-out-left' : 'slide-out-right');

          setTimeout(() => { window.location.href = next; }, 230);
        });
      });
    })();
  </script>
</body>
</html>
