<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title','B’cake — Elegant Bakery')</title>

  {{-- CSRF (dipakai form/AJAX) --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Vite (Tailwind + JS) --}}
  @vite(['resources/css/app.css','resources/js/app.js'])

  {{-- Google Fonts (opsional) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root{--bcake-wine:#890524;--bcake-deep:#57091d;--bcake-cocoa:#362320}
    body{font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
    .shadow-soft{box-shadow:0 20px 40px rgba(54,35,32,.10)}
    .bcake-divider{height:4px;background:linear-gradient(90deg,var(--bcake-cocoa),var(--bcake-deep) 40%,var(--bcake-wine));border-radius:999px}

    /* Anti-overlay: dekorasi jangan blok klik */
    .decorative, .grain, .bg-overlay, .mask-overlay, .sprinkles, .berryLayer {
      pointer-events: none !important; z-index: 0 !important;
    }
    main, header, nav, aside, section, a, button, .card, .btn { position: relative; z-index: 1; }

    /* Drawer mobile */
    #sidebarMobile{ transition: transform .25s ease; transform: translateX(-100%); }
    #sidebarMobile[data-open="true"]{ transform: translateX(0); }
    #backdropMobile{ display:none; }
    #backdropMobile[data-open="true"]{ display:block; }
  </style>

  @stack('head')
</head>
<body class="bg-rose-50 text-gray-800 antialiased min-h-screen flex flex-col">

  {{-- ====== HEADER ====== --}}
  <header class="sticky top-0 z-50 w-full" role="banner">
    <div class="bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b border-rose-200/50">
      <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="grid items-center py-4 md:grid-cols-[auto_1fr_auto] gap-4">

          {{-- BRAND + TOGGLE --}}
          <div class="min-w-0 flex items-center gap-3">
            <button id="btnSidebar"
              class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-rose-200/70 text-rose-800 md:hidden"
              aria-label="Buka menu" aria-expanded="false" aria-controls="sidebarMobile">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="opacity-80">
                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </button>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
              <img src="{{ asset('image/cake.jpg') }}" alt="B’cake"
                   class="hidden xl:block h-10 w-10 rounded-lg object-cover ring-1 ring-rose-200/60">
              <span class="font-serif text-2xl tracking-wide text-rose-800">B'cake</span>
            </a>
          </div>

          {{-- NAV + SEARCH (desktop) --}}
          <div class="min-w-0">
            <div class="hidden md:flex items-center gap-6">
              <ul class="flex items-center gap-7 flex-none text-rose-800/90">
                <li>
                  <a href="{{ route('home') }}"
                     class="hover:text-rose-900 {{ request()->routeIs('home') ? 'text-rose-900 font-medium' : '' }}">Home</a>
                </li>
                <li>
                  <a href="{{ route('products.index') }}"
                     class="hover:text-rose-900 {{ request()->routeIs('products.*') ? 'text-rose-900 font-medium' : '' }}">Produk</a>
                </li>
                <li>
                  <a href="{{ route('stores.index') }}"
                     class="hover:text-rose-900 {{ request()->routeIs('stores.*') ? 'text-rose-900 font-medium' : '' }}">Toko</a>
                </li>
                <li>
                  <a href="{{ route('cart.index') }}"
                     class="hover:text-rose-900 {{ request()->routeIs('cart.*') ? 'text-rose-900 font-medium' : '' }}">Keranjang</a>
                </li>
                <li>
                  <a href="{{ auth()->check() && Route::has('buyer.help') ? route('buyer.help') : route('help') }}"
                     class="hover:text-rose-900 {{ request()->routeIs('help') || request()->routeIs('buyer.help') ? 'text-rose-900 font-medium' : '' }}">
                    Bantuan
                  </a>
                </li>
              </ul>

              <form action="{{ route('products.index') }}" method="get"
                    class="relative flex-1 min-w-0 max-w-xl" role="search">
                <input name="q" type="text" placeholder="Search cakes…"
                       class="w-full rounded-full border border-rose-200/70 bg-white/70 px-4 py-2 text-sm
                              focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-rose-400"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
              </form>
            </div>
          </div>

          {{-- ACTIONS --}}
          <div class="flex justify-end items-center gap-3 flex-none">
            <a href="{{ route('cart.index') }}"
               class="relative inline-flex items-center rounded-full border border-rose-200/70 bg-white/70 px-3 py-2 hover:border-rose-300"
               aria-label="Keranjang">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 9m12-9l-2 9M9 22a1 1 0 100-2 1 1 0 000 2z"/>
              </svg>
            </a>

            @auth
              <a href="{{ route('dashboard') }}"
                 class="rounded-full bg-rose-600 text-white px-4 py-2 text-sm hover:bg-rose-700">Dashboard</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="rounded-full border border-rose-200/70 px-4 py-2 text-sm hover:border-rose-300">
                  Logout
                </button>
              </form>
            @else
              <a href="{{ route('login') }}"
                 class="rounded-full border border-rose-200/70 px-4 py-2 text-sm hover:border-rose-300">Login</a>
              <a href="{{ route('register') }}"
                 class="rounded-full bg-rose-700 text-white px-4 py-2 text-sm hover:bg-rose-800">Register</a>
            @endauth
          </div>

        </div>
      </div>
      <div class="h-[3px] bg-gradient-to-r from-rose-900 via-rose-700 to-rose-500/90"></div>
    </div>
  </header>

  {{-- ====== MOBILE DRAWER ====== --}}
  <div id="backdropMobile" class="fixed inset-0 bg-black/30 z-40" hidden></div>
  <aside id="sidebarMobile"
         class="fixed top-0 left-0 bottom-0 w-[85%] max-w-[320px] bg-white z-50 p-5 border-r border-rose-200/60"
         role="dialog" aria-modal="true" aria-labelledby="mobileNavTitle">
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-3">
        <img src="{{ asset('image/cake.jpg') }}" class="h-8 w-8 rounded-lg object-cover ring-1 ring-rose-200/60" alt="">
        <h2 id="mobileNavTitle" class="font-semibold">Menu</h2>
      </div>
      <button id="btnSidebarClose" aria-label="Tutup menu"
              class="w-9 h-9 inline-flex items-center justify-center rounded-full border border-rose-200/70">
        ✕
      </button>
    </div>

    <nav class="space-y-1 text-rose-800/90">
      <a href="{{ route('home') }}"
         class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('home') ? 'bg-rose-50 font-medium' : '' }}">🏠 Home</a>
      <a href="{{ route('products.index') }}"
         class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('products.*') ? 'bg-rose-50 font-medium' : '' }}">🧁 Produk</a>
      <a href="{{ route('stores.index') }}"
         class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('stores.*') ? 'bg-rose-50 font-medium' : '' }}">🏪 Toko</a>
      <a href="{{ route('cart.index') }}"
         class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('cart.*') ? 'bg-rose-50 font-medium' : '' }}">🧺 Keranjang</a>
      <a href="{{ auth()->check() && Route::has('buyer.help') ? route('buyer.help') : route('help') }}"
         class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('help') || request()->routeIs('buyer.help') ? 'bg-rose-50 font-medium' : '' }}">🆘 Bantuan</a>
    </nav>

    <div class="mt-6 border-t pt-4">
      @auth
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg bg-rose-600 text-white text-center">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">@csrf
          <button class="w-full px-3 py-2 rounded-lg border border-rose-200/70">Logout</button>
        </form>
      @else
        <div class="grid grid-cols-2 gap-2">
          <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg border border-rose-200/70 text-center">Login</a>
          <a href="{{ route('register') }}" class="px-3 py-2 rounded-lg bg-rose-700 text-white text-center">Register</a>
        </div>
      @endauth
    </div>
  </aside>

  {{-- ====== MAIN (Sidebar + Content) ====== --}}
  <main class="flex-1 w-full">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-8">
      @hasSection('sidebar')
        <div class="grid md:grid-cols-[260px_1fr] gap-6">
          <aside id="appSidebar"
                 class="bg-white/80 backdrop-blur rounded-2xl border border-rose-200/60 shadow-soft p-4 h-max hidden md:block">
            @yield('sidebar')
          </aside>

          <section>
            @yield('content')
          </section>
        </div>
      @else
        <section>
          @yield('content')
        </section>
      @endif
    </div>
  </main>

  {{-- ====== FOOTER SLOT ====== --}}
  @hasSection('footer')
    @yield('footer')
  @else
    @includeIf('partials.footer')
  @endif

  @push('scripts')
  <script>
    (function(){
      const btnOpen  = document.getElementById('btnSidebar');
      const btnClose = document.getElementById('btnSidebarClose');
      const drawer   = document.getElementById('sidebarMobile');
      const backdrop = document.getElementById('backdropMobile');

      function open() {
        drawer?.setAttribute('data-open','true');
        backdrop?.setAttribute('data-open','true');
        btnOpen?.setAttribute('aria-expanded','true');
      }
      function close() {
        drawer?.removeAttribute('data-open');
        backdrop?.removeAttribute('data-open');
        btnOpen?.setAttribute('aria-expanded','false');
      }
      btnOpen?.addEventListener('click', open);
      btnClose?.addEventListener('click', close);
      backdrop?.addEventListener('click', close);
      document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') close(); });
    })();
  </script>
  @endpush

  {{-- render stack scripts --}}
  @stack('scripts')
</body>
</html>
