<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title','B’cake — Elegant Bakery')</title>

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
  </style>

  @stack('head')
</head>
<body class="bg-rose-50 text-gray-800 antialiased">

  {{-- ====== HEADER (final) ====== --}}
<header class="sticky top-0 z-50 w-full" role="banner">
  <div class="bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b border-rose-200/50">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
      {{-- 3 kolom: brand | nav+search (fleksibel) | actions --}}
      <div class="grid items-center py-4 md:grid-cols-[auto_1fr_auto] gap-4">

        {{-- BRAND --}}
        <div class="min-w-0 flex items-center gap-3">
          {{-- BTN: toggle sidebar (mobile) --}}
          <button id="btnSidebar"
            class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-rose-200/70 text-rose-800 md:hidden"
            aria-label="Toggle sidebar" aria-expanded="false" aria-controls="sidebarMobile">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="opacity-80">
              <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </button>
          <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
            <img src="{{ asset('cake.jpg') }}" alt="B’cake"
              class="hidden xl:block h-10 w-10 rounded-lg object-cover ring-1 ring-rose-200/60">
              <span class="font-serif text-2xl tracking-wide text-rose-800">B'cake</span>
            </a>
        </div>

        {{-- NAV + SEARCH (tengah, fleksibel) --}}
        <div class="min-w-0">
          <div class="hidden md:flex items-center gap-6">
            <ul class="flex items-center gap-7 flex-none text-rose-800/90">
              <li><a href="{{ route('home') }}" class="hover:text-rose-900">Home</a></li>
              <li><a href="{{ route('products.index') }}" class="hover:text-rose-900">Produk</a></li>
              <li><a href="{{ route('cart.index') }}" class="hover:text-rose-900">Keranjang</a></li>
              <li><a href="#" class="hover:text-rose-900">Bantuan</a></li>
            </ul>

            {{-- SEARCH: melebar hanya di kolom tengah --}}
            <form action="{{ route('products.index') }}" method="get"
                  class="relative flex-1 min-w-0 max-w-xl" role="search">
              <input name="q" type="text" placeholder="Search cakes…"
                     class="w-full rounded-full border border-rose-200/70 bg-white/70 px-4 py-2 text-sm
                            focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
              <svg xmlns="http://www.w3.org/2000/svg"
                   class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-rose-400"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
              </svg>
            </form>
          </div>
        </div>

        {{-- ACTIONS (kanan, fixed width) --}}
        <div class="flex justify-end items-center gap-3 flex-none">
          <a href="{{ route('cart.index') }}"
             class="relative inline-flex items-center rounded-full border border-rose-200/70 bg-white/70 px-3 py-2 hover:border-rose-300"
             aria-label="Keranjang">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor">
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

 {{-- ====== MAIN (Sidebar + Content) ====== --}}
<main class="max-w-7xl mx-auto px-6 lg:px-10 py-8">
  @hasSection('sidebar')
    {{-- Grid 2 kolom: 260px sidebar + konten --}}
    <div class="grid md:grid-cols-[260px_1fr] gap-6">
      {{-- SIDEBAR --}}
      <aside id="appSidebar"
             class="bg-white/80 backdrop-blur rounded-2xl border border-rose-200/60 shadow-soft p-4 h-max hidden md:block">
        @yield('sidebar')
      </aside>

      {{-- CONTENT --}}
      <section>
        @yield('content')
      </section>
    </div>
  @else
    {{-- Tanpa sidebar: konten full --}}
    <section>
      @yield('content')
    </section>
  @endif
</main>
</body>
</html>
