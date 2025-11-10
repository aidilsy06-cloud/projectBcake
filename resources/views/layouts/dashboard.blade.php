<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title','B’cake — Dashboard')</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    body{font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
    .shadow-soft{box-shadow:0 20px 40px rgba(54,35,32,.10)}
    .nav-item{display:block;padding:.6rem .8rem;border-radius:.6rem;transition:.2s}
    .nav-item:hover{background:#fff1f2}
    .nav-active{background:#ffe4e6;color:#9f1239;font-weight:600}
  </style>

  @stack('head')
</head>
<body class="bg-rose-50 min-h-screen">

  {{-- ===== TOP BAR ===== --}}
  <div class="bg-white/80 backdrop-blur border-b border-rose-200/60 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 h-14 flex items-center justify-between">
      <button id="btnSidebar"
              class="lg:hidden inline-flex items-center gap-2 px-3 py-2 rounded-md border border-rose-200/70"
              aria-controls="sidebar" aria-expanded="false">
        ☰ <span class="text-sm">Menu</span>
      </button>

      <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
        <img src="{{ asset('cake.jpg') }}" class="h-8 w-8 rounded-lg object-cover ring-1 ring-rose-200/60" alt="B’cake">
        <span class="font-serif text-xl text-rose-800">B’cake Dashboard</span>
      </a>

      <div class="hidden lg:flex items-center gap-2">
        @auth
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button class="rounded-full border px-4 py-1.5 text-sm hover:bg-rose-50">Logout</button>
          </form>
        @endauth
      </div>
    </div>
  </div>

  {{-- ===== LAYOUT GRID ===== --}}
  <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6 grid grid-cols-12 gap-6">

    {{-- ===== SIDEBAR (desktop) / DRAWER (mobile) ===== --}}
    {{-- Backdrop untuk mobile drawer --}}
    <div id="sbBackdrop"
         class="fixed inset-0 bg-black/30 z-40 hidden lg:!hidden"></div>

    <aside id="sidebar"
           class="col-span-12 lg:col-span-3 bg-white border border-rose-200/70 shadow-soft rounded-2xl p-5
                  lg:static lg:block
                  fixed left-0 top-14 bottom-0 w-72 z-50
                  translate-x-[-110%] lg:translate-x-0 transition-transform">
      {{-- Header user --}}
      <div class="flex items-center gap-3 mb-6">
        <img src="{{ asset('cake.jpg') }}" class="h-10 w-10 rounded-lg object-cover ring-1 ring-rose-200/60" alt="Logo" loading="lazy">
        <div>
          <div class="text-sm text-gray-500">Halo,</div>
          <div class="font-semibold text-rose-800">{{ Auth::user()->name ?? 'User' }}</div>
        </div>
      </div>

      {{-- Nav --}}
      <nav class="space-y-1 text-[15px]">
        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'nav-active' : 'text-gray-700' }}">🏠 Dashboard</a>

        <a href="{{ route('products.index') }}"
           class="nav-item {{ request()->is('products*') ? 'nav-active' : 'text-gray-700' }}">🍰 Produk</a>

        <a href="{{ route('cart.index') }}"
           class="nav-item {{ request()->is('cart*') ? 'nav-active' : 'text-gray-700' }}">🛒 Keranjang</a>

        <a href="#"
           class="nav-item text-gray-700">📣 Promo</a>

        <a href="#"
           class="nav-item text-gray-700">⚙️ Pengaturan</a>

        <form method="POST" action="{{ route('logout') }}" class="pt-2">@csrf
          <button class="w-full text-left nav-item border mt-2 hover:bg-rose-50">🚪 Logout</button>
        </form>
      </nav>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="col-span-12 lg:col-span-9">
      @yield('content')
    </main>
  </div>

  {{-- ===== SCRIPTS ===== --}}
  <script>
    (function(){
      const btn = document.getElementById('btnSidebar');
      const sb  = document.getElementById('sidebar');
      const bd  = document.getElementById('sbBackdrop');

      function openSidebar(){
        sb.classList.remove('translate-x-[-110%]');
        bd.classList.remove('hidden');
        btn?.setAttribute('aria-expanded','true');
      }
      function closeSidebar(){
        sb.classList.add('translate-x-[-110%]');
        bd.classList.add('hidden');
        btn?.setAttribute('aria-expanded','false');
      }

      btn?.addEventListener('click', () => {
        const opened = !sb.classList.contains('translate-x-[-110%]');
        opened ? closeSidebar() : openSidebar();
      });
      bd?.addEventListener('click', closeSidebar);
      window.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') closeSidebar(); });
    })();
  </script>

  @stack('scripts')
</body>
</html>
