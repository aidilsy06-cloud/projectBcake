<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Masuk — B’cake</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    :root{
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
    .btn-outline:hover{
      background:#fff;
      color:var(--pink-700);
    }
    .ring-pink:focus{
      outline:none;
      box-shadow:0 0 0 4px rgba(244,63,94,.25);
    }

    /* ===== Slide transitions ===== */
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

    /* ===== STRAWBERRY GLOSSY ===== */
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

  {{-- STRAWBERRY SPRITE (defs) --}}
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
        <path d="M45 26c8 5 19 7 31 0 0 0-9 14-15 14S45 26 45 26z" fill="url(#leafFill)"/>
        <path d="M52 25c6 3 12 4 21 0 -4 6-8 9-11 9s-10-6-10-9z" fill="#2a8f00" opacity=".22"/>
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

  {{-- CARD SPLIT: Welcome kiri, Form kanan --}}
  <div id="pageCard" class="w-full max-w-5xl card overflow-hidden relative z-[1]">
    <div class="grid md:grid-cols-2">

      {{-- LEFT: Welcome --}}
      <div class="relative hidden md:block">
        <div class="absolute inset-0 grid place-items-center px-10">
          <div class="welcome p-10 md:p-12 w-[92%]">
            <h2 class="text-2xl font-semibold">Hello, Welcome!</h2>
            <p class="mt-2 text-white/90 text-sm">Don’t have an account?</p>
            <a href="{{ Route::has('register') ? route('register') : '#' }}"
               class="btn-outline mt-5 inline-flex items-center gap-2"
               data-slide="to-register">
              <span>Register</span>
            </a>
          </div>
        </div>
        <div class="pb-[62%]"></div>
      </div>

      {{-- RIGHT: Login form --}}
      <div class="p-7 md:p-10">
        <div class="flex items-center justify-between mb-6">
          <div class="inline-flex items-center gap-2">
            <span class="inline-grid place-items-center w-9 h-9 rounded-xl"
                  style="background:var(--pink-100)">🍰</span>
            <span class="font-semibold" style="color:var(--deep)">B’cake</span>
          </div>
          <a href="{{ url('/') }}" class="text-sm" style="color:var(--pink-600)">Kembali</a>
        </div>

        <h1 class="text-2xl font-semibold text-gray-900">Login</h1>
        <p class="text-sm text-gray-500 mt-1">Welcome back! Please enter your details.</p>

        @if (session('status'))
          <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 px-3 py-2 text-sm">
            {{ session('status') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 px-3 py-2 text-sm">
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="mt-6 space-y-4" x-data="{show:false}">
          @csrf

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1 relative">
              <input id="email"
                     name="email"
                     type="email"
                     required
                     autocomplete="email"
                     value="{{ old('email') }}"
                     class="w-full rounded-xl border-gray-300 pl-10 pr-3 py-2 ring-pink"
                     placeholder="you@example.com">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400"
                   xmlns="http://www.w3.org/2000/svg"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke="currentColor"
                   aria-hidden="true">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            @error('email')
              <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>

              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   data-slide="to-forgot"
                   class="text-xs font-medium"
                   style="color:var(--pink-700)">
                  Lupa password?
                </a>
              @endif
            </div>

            <div class="mt-1 relative">
              <input :type="show ? 'text' : 'password'"
                     id="password"
                     name="password"
                     required
                     autocomplete="current-password"
                     class="w-full rounded-xl border-gray-300 pl-10 pr-16 py-2 ring-pink"
                     placeholder="">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400"
                   xmlns="http://www.w3.org/2000/svg"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke="currentColor"
                   aria-hidden="true">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 11c-1.657 0-3 1.343-3 3v3h6v-3c0-1.657-1.343-3-3-3z"/>
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 8V7a5 5 0 00-10 0v1"/>
                <rect x="5" y="11" width="14" height="10" rx="2" ry="2"
                      stroke="currentColor"
                      fill="none"/>
              </svg>
              <button type="button"
                      @click="show=!show"
                      class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 text-sm"
                      style="color:var(--pink-700)">
                <span x-text="show ? 'Sembunyikan' : 'Lihat'"></span>
              </button>
            </div>
            @error('password')
              <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
            @enderror
          </div>

          <label class="inline-flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox"
                   name="remember"
                   class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
            Ingat saya
          </label>

          <button type="submit" class="w-full btn-primary">Masuk</button>

          <p class="text-center text-sm text-gray-600">
            Belum punya akun?
            @if (Route::has('register'))
              <a href="{{ route('register') }}"
                 data-slide="to-register"
                 class="font-medium"
                 style="color:var(--pink-700)">
                Daftar
              </a>
            @endif
          </p>
        </form>
      </div>
    </div>
  </div>

  <script>
    (function () {
      const card = document.getElementById('pageCard');
      const dir  = sessionStorage.getItem('bcake_nav_dir'); // 'to-register' | 'to-login' | 'to-forgot'

      if (dir === 'to-login')          card.classList.add('slide-in-left');
      else if (dir === 'to-register')  card.classList.add('slide-in-right');
      else if (dir === 'to-forgot')    card.classList.add('slide-in-right');
      else                             card.classList.add('slide-in-left');

      sessionStorage.removeItem('bcake_nav_dir');

      document.querySelectorAll('[data-slide]').forEach(a => {
        a.addEventListener('click', function (e) {
          const next = this.getAttribute('href');
          if (!next) return;

          e.preventDefault();

          const to = this.dataset.slide; // 'to-register' | 'to-forgot' | 'to-login'
          sessionStorage.setItem('bcake_nav_dir', to);

          card.classList.remove('slide-in-left', 'slide-in-right');

          if (to === 'to-register') {
            card.classList.add('slide-out-left');
          } else {
            card.classList.add('slide-out-right');
          }

          setTimeout(() => { window.location.href = next; }, 230);
        });
      });
    })();
  </script>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
