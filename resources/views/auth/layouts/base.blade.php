<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <title>@yield('title','B’cake Auth')</title>

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
    .btn-primary{
      background:var(--pink-600);
      color:#fff;
      border-radius:.9rem;
      padding:.7rem 1rem;
    }
    .btn-primary:hover{ background:var(--pink-700); }
    .ring-pink:focus{
      outline:none;
      box-shadow:0 0 0 4px rgba(244,63,94,.25);
    }

    .slide-in-right  { animation: slideInRight .35s ease-out both; }
    .slide-in-left   { animation: slideInLeft  .35s ease-out both;  }
    .slide-out-left  { animation: slideOutLeft .28s ease-in both;   }
    .slide-out-right { animation: slideOutRight .28s ease-in both;  }
    @keyframes slideInRight { from {opacity:0; transform:translateX(40px)} to {opacity:1; transform:none} }
    @keyframes slideInLeft  { from {opacity:0; transform:translateX(-40px)} to {opacity:1; transform:none} }
    @keyframes slideOutLeft { from {opacity:1; transform:none} to {opacity:0; transform:translateX(-40px)} }
    @keyframes slideOutRight{ from {opacity:1; transform:none} to {opacity:0; transform:translateX(40px)} }

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

    .alert{ @apply rounded-xl px-3 py-2 text-sm mt-3; }
    .alert.success{ background:#ecfdf5; color:#047857; border:1px solid #bbf7d0; }
    .alert.error{ background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }

    .input{
      @apply rounded-xl border-gray-300 px-3 py-2 w-full;
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

  {{-- STRAWBERRY SVG --}}
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

  {{-- CARD UTAMA --}}
  <div id="pageCard" class="w-full max-w-md card overflow-hidden relative z-[1] p-7 md:p-8">
      @yield('content')
  </div>

  <script>
    (function () {
      const card = document.getElementById('pageCard');
      const dir  = sessionStorage.getItem('bcake_nav_dir'); 

      if (dir === 'to-login') card.classList.add('slide-in-left');
      else                    card.classList.add('slide-in-right');

      sessionStorage.removeItem('bcake_nav_dir');

      document.querySelectorAll('[data-slide]').forEach(a => {
        a.addEventListener('click', function (e) {
          const next = this.getAttribute('href');
          if (!next) return;

          e.preventDefault();
          const to = this.dataset.slide;
          sessionStorage.setItem('bcake_nav_dir', to);

          card.classList.remove('slide-in-left','slide-in-right');
          card.classList.add('slide-out-right');

          setTimeout(() => { window.location.href = next; }, 230);
        });
      });
    })();
  </script>
</body>
</html>
