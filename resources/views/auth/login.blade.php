<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Masuk – B’cake</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    :root{
      --pink-50:#fff1f5; --pink-100:#ffe4ec; --pink-200:#fecdd6; --pink-300:#fda4af;
      --pink-500:#f43f5e; --pink-600:#e11d48; --pink-700:#be123c;
      --cream:#faf6f7; --shadow:0 30px 60px rgba(244,63,94,.12);
    }
    body{
      min-height:100vh;
      background:
        radial-gradient(1100px 500px at 85% -120px, var(--pink-100), transparent 60%),
        radial-gradient(900px 400px at -10% 10%, var(--pink-50), transparent 60%),
        linear-gradient(180deg, var(--cream), #fff);
    }
    .card{ background:#fff; border-radius:1.25rem; box-shadow:var(--shadow); }

    /* ===== MESIS JATUH ===== */
    .sprinkles{ position:fixed; inset:0; pointer-events:none; overflow:hidden; z-index:0; }
    .sprinkle{
      position:absolute; top:-20px; width:6px; height:16px; border-radius:3px;
      background: var(--spr-color, var(--pink-600));
      transform: rotate(var(--rot, 25deg)); opacity:.9;
      animation: drop linear infinite;
      filter: blur(.1px); /* halus */
    }
    @keyframes drop{ from{ transform: translateY(-40px) rotate(var(--rot,25deg)); }
                     to{   transform: translateY(110vh) rotate(var(--rot,25deg)); } }
    .sprinkle:nth-child(4n){ --spr-color:#fb7185; }
    .sprinkle:nth-child(4n+1){ --spr-color:#fda4af; }
    .sprinkle:nth-child(4n+2){ --spr-color:#be123c; }
    .sprinkle:nth-child(4n+3){ --spr-color:#6b3a31; }

    /* ===== STROBERI GLOSSY (tanpa bayangan) ===== */
    .berryLayer{ position:fixed; inset:0; pointer-events:none; z-index:0; overflow:hidden; }
    .berry{ position:absolute; top:-160px; width: clamp(76px, 8vw, 124px); }
    /* jatuh elegan: lambat, sedikit rotasi & sway */
    .berryFall{
      animation:
        berryDrop var(--dur,9s) linear var(--delay,0s) infinite,
        berrySway 4.5s ease-in-out calc(var(--delay,0s) * .6) infinite;
    }
    @keyframes berryDrop{
      from { transform: translateY(-20vh) rotate(var(--rot, -8deg)); }
      to   { transform: translateY(120vh) rotate(calc(var(--rot, -8deg) + 36deg)); }
    }
    @keyframes berrySway{
      0%,100% { translate: 0 0; }
      50%     { translate: 10px 0; }
    }

    /* input & tombol */
    .ring-pink:focus{ outline:none; box-shadow:0 0 0 4px rgba(244,63,94,.25); }
    .btn-pink{ background:var(--pink-600); color:#fff; border-radius:1rem; padding:.7rem 1rem; }
    .btn-pink:hover{ background:var(--pink-700); }
    .brand{ display:flex; align-items:center; gap:.65rem; font-weight:600; color:var(--pink-700); }
  </style>
</head>
<body class="flex items-center justify-center p-6">

  {{-- MESIS --}}
  <div class="sprinkles" aria-hidden="true">
    @for ($i=0; $i<70; $i++)
      @php
        $left  = rand(0,100);
        $delay = rand(0,2000)/1000;       // 0–2s
        $dur   = rand(4000,9000)/1000;    // 4–9s
        $rot   = rand(-40,40);
      @endphp
      <span class="sprinkle" style="left: {{ $left }}%; animation-duration: {{ $dur }}s; animation-delay: {{ $delay }}s; --rot: {{ $rot }}deg;"></span>
    @endfor
  </div>

  {{-- STRAWBERRY SPRITE (HD, glossy, tanpa cast shadow) --}}
  <svg width="0" height="0" style="position:absolute">
    <defs>
      <!-- gradasi berry: pink lucu -> cherry deep -->
      <linearGradient id="berryFill" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%"   stop-color="#ff6a8a"/>
        <stop offset="50%"  stop-color="#ff4d6d"/>
        <stop offset="100%" stop-color="#b1123a"/>
      </linearGradient>
      <!-- daun elegan -->
      <linearGradient id="leafFill" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0%" stop-color="#8dd417"/>
        <stop offset="100%" stop-color="#2b9c00"/>
      </linearGradient>
      <!-- highlight specular kuat -->
      <linearGradient id="gloss" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0%"   stop-color="rgba(255,255,255,.98)"/>
        <stop offset="35%"  stop-color="rgba(255,255,255,.45)"/>
        <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
      </linearGradient>
      <!-- rim halus di tepi kanan atas (tanpa bayangan jatuh) -->
      <radialGradient id="rim" cx="80%" cy="10%" r="60%">
        <stop offset="0%" stop-color="rgba(255,255,255,.6)"/>
        <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
      </radialGradient>

      <symbol id="strawberryHD" viewBox="0 0 128 128" shape-rendering="geometricPrecision">
        <!-- BODY -->
        <path d="M64 118c-26 0-50-35-44-60 7-30 40-28 44-8 4-20 37-22 44 8 6 25-18 60-44 60z"
              fill="url(#berryFill)"/>
        <!-- rim highlight -->
        <ellipse cx="88" cy="24" rx="30" ry="18" fill="url(#rim)"/>

        <!-- LEAVES -->
        <path d="M45 26c8 5 19 7 31 0 0 0-9 14-15 14S45 26 45 26z" fill="url(#leafFill)"/>
        <path d="M52 25c6 3 12 4 21 0 -4 6-8 9-11 9s-10-6-10-9z" fill="#2a8f00" opacity=".22"/>

        <!-- SEEDS kecil & rapi -->
        <g fill="#ffd3db" opacity=".95">
          <circle cx="48" cy="66" r="2.6"/><circle cx="66" cy="76" r="2.6"/>
          <circle cx="82" cy="60" r="2.6"/><circle cx="54" cy="88" r="2.6"/>
          <circle cx="74" cy="94" r="2.3"/><circle cx="90" cy="78" r="2.3"/>
          <circle cx="36" cy="76" r="2.3"/><circle cx="58" cy="70" r="2.3"/>
        </g>

        <!-- SPECULAR GLOSS -->
        <path d="M34 56c12-24 42-28 58-12 3 3 3 7 1 10-12-9-26-11-39-6-8 3-14 7-20 14z"
              fill="url(#gloss)"/>
      </symbol>
    </defs>
  </svg>

  {{-- LAYER STROBERI JATUH (10 buah random) --}}
  <div class="berryLayer" aria-hidden="true">
    @for ($i=0; $i<10; $i++)
      @php
        $left  = rand(0,100);
        $delay = rand(0,5000)/1000;           // 0–5s
        $dur   = rand(9000,15000)/1000;       // 9–15s (lebih lambat dari mesis)
        $rot   = rand(-12,12);                // rotasi awal
      @endphp
      <svg class="berry berryFall" style="left: {{ $left }}%; --delay: {{ $delay }}s; --dur: {{ $dur }}s; --rot: {{ $rot }}deg;">
        <use href="#strawberryHD"></use>
      </svg>
    @endfor
  </div>

  {{-- KARTU LOGIN --}}
  <div class="card w-full max-w-md relative z-[1]">
    <div class="px-7 pt-7 flex items-center justify-between">
      <div class="brand">
        <span class="inline-grid place-items-center w-9 h-9 rounded-xl" style="background:var(--pink-100)">🍰</span>
        <span>B’cake</span>
      </div>
      <a href="{{ url('/') }}" class="text-sm text-pink-600 hover:underline">Kembali</a>
    </div>

    <div class="p-7 pt-4">
      <h1 class="text-2xl font-semibold text-[var(--pink-700)] mb-1">Selamat Datang</h1>
      <p class="text-sm text-gray-500 mb-4">Masuk untuk mulai belanja kue favoritmu.</p>

      <x-auth-session-status class="mb-4" :status="session('status')" />

      @if ($errors->any())
        <div class="mb-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 px-3 py-2 text-sm">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" x-data="{show:false}">
        @csrf
        <div class="space-y-4">
          <div>
            <label for="email" class="block text-sm text-gray-600 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   autocomplete="username" class="w-full border rounded-xl px-4 py-2 ring-pink"
                   placeholder="kamu@contoh.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>

          <div>
            <label for="password" class="block text-sm text-gray-600 mb-1">Password</label>
            <div class="relative">
              <input :type="show ? 'text' : 'password'" id="password" name="password" required
                     autocomplete="current-password"
                     class="w-full border rounded-xl px-4 py-2 ring-pink pr-12" placeholder="••••••••">
              <button type="button" @click="show=!show"
                      class="absolute right-2 top-1/2 -translate-y-1/2 text-pink-600 px-2 py-1 text-sm">
                <span x-text="show ? 'Sembunyikan' : 'Lihat'"></span>
              </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </div>

          <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm">
              <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300">
              <span>Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
              <a class="text-sm text-pink-600 hover:underline" href="{{ route('password.request') }}">
                Lupa password?
              </a>
            @endif
          </div>

          <button class="w-full btn-pink">Masuk</button>
        </div>
      </form>

      @if (Route::has('register'))
        <p class="mt-5 text-center text-sm text-gray-500">
          Belum punya akun?
          <a class="text-pink-600 hover:underline" href="{{ route('register') }}">Daftar</a>
        </p>
      @endif
    </div>
  </div>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
