<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Masuk – B’cake</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    :root{
      --pink-50:#fff1f5; --pink-100:#ffe4ec; --pink-200:#fecdd6;
      --pink-300:#fda4af; --pink-500:#f43f5e; --pink-600:#e11d48; --pink-700:#be123c;
      --cream:#faf6f7; --shadow:0 30px 60px rgba(244,63,94,.10); --choco:#5b3a36;
    }
    body{
      min-height:100vh;
      background:
        radial-gradient(1200px 500px at 80% -100px, var(--pink-100), transparent 60%),
        radial-gradient(900px 400px at -10% 10%, var(--pink-50), transparent 60%),
        linear-gradient(180deg, var(--cream), #fff);
    }
    .card{ background:#fff; border-radius:1.25rem; box-shadow:var(--shadow); }
    .straw{ position:absolute; width:110px; filter: drop-shadow(0 10px 25px rgba(244,63,94,.25)); }
    .float-1{ animation: floatY 6s ease-in-out infinite; }
    .float-2{ animation: floatY 7.5s ease-in-out -1.2s infinite; transform: scale(.9); }
    .float-3{ animation: floatY 8s ease-in-out -2.2s infinite; transform: scale(.85) rotate(-8deg); }
    @keyframes floatY{ 0%,100%{ transform: translateY(0) } 50%{ transform: translateY(-16px) } }

    .sprinkles{ position:fixed; inset:0; pointer-events:none; overflow:hidden; }
    .sprinkle{
      position:absolute; top:-20px; width:6px; height:16px; border-radius:3px;
      background: var(--spr-color, var(--pink-600));
      transform: rotate(var(--rot, 25deg)); opacity:.9;
      filter: drop-shadow(0 2px 6px rgba(0,0,0,.08));
      animation: drop linear infinite;
    }
    @keyframes drop{
      0%{ transform: translateY(-40px) rotate(var(--rot,25deg)); }
      100%{ transform: translateY(110vh) rotate(var(--rot,25deg)); }
    }
    .sprinkle:nth-child(4n){ --spr-color:#fb7185; }
    .sprinkle:nth-child(4n+1){ --spr-color:#fda4af; }
    .sprinkle:nth-child(4n+2){ --spr-color:#be123c; }
    .sprinkle:nth-child(4n+3){ --spr-color:#5b3a36; }

    .ring-pink:focus{ outline:none; box-shadow:0 0 0 4px rgba(244,63,94,.25); }
    .btn-pink{ background:var(--pink-600); color:#fff; border-radius:1rem; padding:.7rem 1rem; }
    .btn-pink:hover{ background:var(--pink-700); }
    .brand{ display:flex; align-items:center; gap:.65rem; font-weight:600; color:var(--pink-700); }
  </style>
</head>
<body class="flex items-center justify-center p-6">

  {{-- ====== MESIS ====== --}}
  <div class="sprinkles" aria-hidden="true">
    @for ($i=0; $i<60; $i++)
      @php
        $left  = rand(0,100);
        $delay = rand(0,2000)/1000;
        $dur   = rand(4000,9000)/1000;
        $rot   = rand(-40,40);
      @endphp
      <span class="sprinkle" style="left: {{ $left }}%; animation-duration: {{ $dur }}s; animation-delay: {{ $delay }}s; --rot: {{ $rot }}deg;"></span>
    @endfor
  </div>

  {{-- ====== STROBERI ====== --}}
  <svg class="straw float-1" style="left:6%; top:10%;" viewBox="0 0 128 128" aria-hidden="true">
    <path fill="#ff4d6d" d="M64 118c-26 0-50-35-44-60 7-30 40-28 44-8 4-20 37-22 44 8 6 25-18 60-44 60z"/>
    <path fill="#38b000" d="M45 26c8 5 19 7 31 0 0 0-9 14-15 14S45 26 45 26z"/>
    <circle fill="#ffa6b6" cx="48" cy="66" r="4"/><circle fill="#ffa6b6" cx="66" cy="76" r="4"/>
    <circle fill="#ffa6b6" cx="82" cy="60" r="4"/><circle fill="#ffa6b6" cx="54" cy="88" r="4"/>
  </svg>
  <svg class="straw float-2" style="right:8%; top:20%;" viewBox="0 0 128 128" aria-hidden="true">
    <path fill="#ff4d6d" d="M64 118c-26 0-50-35-44-60 7-30 40-28 44-8 4-20 37-22 44 8 6 25-18 60-44 60z"/>
    <path fill="#38b000" d="M45 26c8 5 19 7 31 0 0 0-9 14-15 14S45 26 45 26z"/>
    <circle fill="#ffa6b6" cx="48" cy="66" r="4"/><circle fill="#ffa6b6" cx="66" cy="76" r="4"/>
    <circle fill="#ffa6b6" cx="82" cy="60" r="4"/><circle fill="#ffa6b6" cx="54" cy="88" r="4"/>
  </svg>
  <svg class="straw float-3" style="left:50%; top:75%; transform:translateX(-50%);" viewBox="0 0 128 128" aria-hidden="true">
    <path fill="#ff4d6d" d="M64 118c-26 0-50-35-44-60 7-30 40-28 44-8 4-20 37-22 44 8 6 25-18 60-44 60z"/>
    <path fill="#38b000" d="M45 26c8 5 19 7 31 0 0 0-9 14-15 14S45 26 45 26z"/>
    <circle fill="#ffa6b6" cx="48" cy="66" r="4"/><circle fill="#ffa6b6" cx="66" cy="76" r="4"/>
    <circle fill="#ffa6b6" cx="82" cy="60" r="4"/><circle fill="#ffa6b6" cx="54" cy="88" r="4"/>
  </svg>

  {{-- ====== KARTU LOGIN ====== --}}
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

      {{-- Status session (Breeze) --}}
      <x-auth-session-status class="mb-4" :status="session('status')" />

      {{-- Error utama (fallback) --}}
      @if ($errors->any())
        <div class="mb-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 px-3 py-2 text-sm">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" x-data="{show:false}">
        @csrf
        <div class="space-y-4">
          {{-- EMAIL (pakai komponen error Breeze) --}}
          <div>
            <label for="email" class="block text-sm text-gray-600 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   autocomplete="username"
                   class="w-full border rounded-xl px-4 py-2 ring-pink"
                   placeholder="kamu@contoh.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>

          {{-- PASSWORD dengan toggle show/hide --}}
          <div>
            <label for="password" class="block text-sm text-gray-600 mb-1">Password</label>
            <div class="relative">
              <input :type="show ? 'text' : 'password'"
                     id="password"
                     name="password"
                     required
                     autocomplete="current-password"
                     class="w-full border rounded-xl px-4 py-2 ring-pink pr-12"
                     placeholder="••••••••">
              <button type="button"
                      @click="show=!show"
                      class="absolute right-2 top-1/2 -translate-y-1/2 text-pink-600 px-2 py-1 text-sm">
                <span x-text="show ? 'Sembunyikan' : 'Lihat'"></span>
              </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </div>

          {{-- REMEMBER + FORGOT --}}
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
