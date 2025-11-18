<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>@yield('title','Seller — B’cake')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    :root{
      --gold:#c7a869;
      --ring: 28 13 18;         /* shadow ring color base */
    }
    .gold-text{ color: var(--gold) }
    .gold-bg{ background: var(--gold) }
    .gold-pill{ border:1px solid rgba(199,168,105,.6); background:linear-gradient(#fff, #fff8f2) }
    .card{ background:#fff; border-radius:1.25rem; box-shadow:0 26px 60px rgba(244,63,94,.10) }
  </style>
  @stack('head')
</head>
<body class="bg-bcake-cream/60 text-gray-800 font-sans min-h-screen">

  {{-- Top bar --}}
  <header class="bg-white/80 backdrop-blur border-b border-rose-200/60">
    <div class="max-w-7xl mx-auto h-14 px-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center gap-2">
          <span class="h-8 w-8 rounded-full bg-bcake-wine inline-flex items-center justify-center text-white font-semibold">B</span>
          <span class="font-display text-lg">B’cake <span class="gold-text">Seller</span></span>
        </a>
      </div>
      <nav class="hidden md:flex items-center gap-6 text-sm">
        <a href="{{ route('seller.dashboard') }}" class="hover:text-bcake-wine">Dashboard</a>
        <a href="#" class="hover:text-bcake-wine">Products</a>
        <a href="#" class="hover:text-bcake-wine">Orders</a>
        <a href="#" class="hover:text-bcake-wine">Discounts</a>
        <a href="#" class="hover:text-bcake-wine">Settings</a>
      </nav>
      <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="text-sm hover:text-bcake-wine">View Store</a>
        {{-- @auth: di sini nanti bisa ditambah dropdown profile/logout --}}
      </div>
    </div>
  </header>

  <main class="pb-16">
    @yield('content')
  </main>

  {{-- Brand strip --}}
  <footer class="bg-bcake-wine text-white">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 opacity-90">
        <div class="text-center font-semibold tracking-widest">LOGO</div>
        <div class="text-center font-semibold tracking-widest">LOGO</div>
        <div class="text-center font-semibold tracking-widest">LOGO</div>
        <div class="text-center font-semibold tracking-widest">LOGO</div>
      </div>
    </div>
  </footer>

  {{-- TOAST NOTIFIKASI UNTUK HALAMAN SELLER --}}
  @if(session('success') || session('error') || session('status'))
    <div style="
      position:fixed;
      right:1.5rem;
      bottom:1.5rem;
      z-index:9999;
      max-width:320px;
      display:flex;
      flex-direction:column;
      gap:0.5rem;
    ">
      @if(session('success') || session('status'))
        <div style="
          display:flex;
          align-items:flex-start;
          gap:0.6rem;
          padding:0.75rem 1rem;
          border-radius:1rem;
          background:#ffffff;
          border:1px solid #bbf7d0;
          box-shadow:0 18px 40px rgba(16,185,129,.3);
          font-size:0.875rem;
        ">
          <div style="
            width:1.75rem;
            height:1.75rem;
            border-radius:999px;
            background:#22c55e;
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:0.75rem;
            flex-shrink:0;
          ">
            ✔
          </div>
          <div style="color:#14532d;font-weight:500;">
            {{ session('success') ?? session('status') }}
          </div>
        </div>
      @endif

      @if(session('error'))
        <div style="
          display:flex;
          align-items:flex-start;
          gap:0.6rem;
          padding:0.75rem 1rem;
          border-radius:1rem;
          background:#ffffff;
          border:1px solid #fecaca;
          box-shadow:0 18px 40px rgba(248,113,113,.3);
          font-size:0.875rem;
        ">
          <div style="
            width:1.75rem;
            height:1.75rem;
            border-radius:999px;
            background:#ef4444;
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:0.75rem;
            flex-shrink:0;
          ">
            !
          </div>
          <div style="color:#7f1d1d;font-weight:500;">
            {{ session('error') }}
          </div>
        </div>
      @endif
    </div>

    <script>
      // auto hilang setelah 3.5 detik
      setTimeout(function () {
        const el = document.querySelector('[style*="z-index:9999"][style*="bottom:1.5rem"]');
        if (el) {
          el.style.transition = 'opacity .3s ease';
          el.style.opacity = '0';
          setTimeout(() => el.remove(), 300);
        }
      }, 3500);
    </script>
  @endif

  @stack('scripts')
</body>
</html>
