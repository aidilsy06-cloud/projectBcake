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
        {{-- @auth ... tombol profile/logout --}}
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

  @stack('scripts')
</body>
</html>
