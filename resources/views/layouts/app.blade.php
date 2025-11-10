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

  {{-- ====== HEADER (satu-satunya header) ====== --}}
  <header class="sticky top-0 z-50 w-full">
    {{-- announcement bar --}}
    <div class="hidden md:flex items-center justify-between px-6 lg:px-10 py-2 text-sm bg-rose-100/80 backdrop-blur border-b border-rose-200/60">
      <div class="text-rose-700/80">🎀 Gratis ongkir area kota tertentu — weekend sale!</div>
      <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 bg-rose-600 text-white hover:bg-rose-700 transition">
        Order Now
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
      </a>
      <div class="flex items-center gap-5 text-rose-700/80">
        <a href="#" class="hover:text-rose-900">Cek Lokasi</a>
        <a href="#" class="hover:text-rose-900">Bantuan</a>
      </div>
    </div>

    {{-- main navbar --}}
    <div class="bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60">
      <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="grid grid-cols-12 items-center py-4">
          {{-- brand --}}
          <div class="col-span-6 md:col-span-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
              <img src="{{ asset('cake.jpg') }}" alt="B’cake" class="hidden xl:block h-10 w-10 rounded-lg object-cover ring-1 ring-rose-200/60">
              <span class="font-serif text-2xl tracking-wide text-rose-800">Patisserie</span>
            </a>
          </div>

          {{-- nav links (desktop) --}}
          <nav class="col-span-12 md:col-span-6 hidden md:flex justify-center">
            <ul class="flex items-center gap-7 text-rose-800/90">
              <li><a href="{{ route('home') }}" class="hover:text-rose-900">Home</a></li>
              <li><a href="{{ route('products.index') }}" class="hover:text-rose-900">Menu</a></li>
              <li><a href="{{ route('products.index') }}?category=cakes" class="hover:text-rose-900">Cakes</a></li>
              <li><a href="#" class="hover:text-rose-900">Promo</a></li>
              <li><a href="#" class="hover:text-rose-900">Contact</a></li>
            </ul>
          </nav>

          {{-- actions --}}
          <div class="col-span-6 md:col-span-3 flex justify-end items-center gap-3">
            <form action="{{ route('products.index') }}" method="get" class="hidden lg:block">
              <div class="relative">
                <input name="q" type="text" placeholder="Search cakes…"
                       class="peer w-56 rounded-full border border-rose-200/70 bg-white/70 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-rose-400 peer-focus:text-rose-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
              </div>
            </form>

            <a href="{{ route('cart.index') }}" class="relative inline-flex items-center rounded-full border border-rose-200/70 bg-white/70 px-3 py-2 hover:border-rose-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 9m12-9l-2 9M9 22a1 1 0 100-2 1 1 0 000 2z"/>
              </svg>
            </a>

            @auth
              <a href="{{ route('dashboard') }}" class="rounded-full bg-rose-600 text-white px-4 py-2 text-sm hover:bg-rose-700">Dashboard</a>
            @else
              <a href="{{ route('login') }}" class="rounded-full border border-rose-200/70 px-4 py-2 text-sm hover:border-rose-300">Sign in</a>
            @endauth
          </div>
        </div>
      </div>
      <div class="h-[3px] bg-gradient-to-r from-rose-900 via-rose-700 to-rose-500/90"></div>
    </div>
  </header>

  {{-- ====== PAGE CONTENT ====== --}}
  @yield('content')

</body>
</html>
