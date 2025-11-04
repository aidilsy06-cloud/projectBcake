<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $title ?? 'B’cake')</title>

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <style> body{font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif} </style>

    @stack('head')
</head>
<body class="bg-rose-50 text-gray-800 selection:bg-bcake-icing selection:text-bcake-bitter">

    {{-- ======= NAVBAR ======= --}}
    <header class="bg-white/90 backdrop-blur border-b border-bcake-truffle/10 sticky top-0 z-40">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            {{-- Brand --}}
            <a href="{{ Route::has('home') ? route('home') : url('/') }}"
               class="text-2xl font-extrabold" style="font-family:'Playfair Display',serif;">
                <span class="text-bcake-wine">B’</span><span class="text-bcake-bitter">cake</span>
            </a>

            {{-- Desktop links --}}
            <div class="hidden md:flex items-center gap-6">
                @if (Route::has('products.index'))
                    <a href="{{ route('products.index') }}"
                       class="{{ request()->routeIs('products.*') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">
                        Produk
                    </a>
                @endif

                @if (Route::has('cart.index'))
                    <a href="{{ route('cart.index') }}"
                       class="{{ request()->routeIs('cart.*') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">
                        Keranjang
                    </a>
                @endif

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">
                        Dashboard
                    </a>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-600 hidden sm:inline">Hi, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm font-medium text-bcake-wine hover:underline">Logout</button>
                        </form>
                    </div>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-bcake-wine">Login</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="text-sm font-semibold text-white bg-bcake-wine px-4 py-2 rounded-xl shadow hover:opacity-90">
                           Daftar
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button id="menuBtn" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg border border-bcake-truffle/20"
                    aria-controls="mobileMenu" aria-expanded="false" aria-label="Buka menu">
                {{-- icon --}}
                <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </nav>
        <div class="h-1 bg-bcake-gradient"></div>

        {{-- Mobile menu panel --}}
        <div id="mobileMenu" class="md:hidden hidden border-t border-bcake-truffle/10 bg-white">
            <div class="max-w-6xl mx-auto px-4 py-3 space-y-2">
                @if (Route::has('products.index'))
                    <a href="{{ route('products.index') }}"
                       class="block py-2 {{ request()->routeIs('products.*') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">
                        Produk
                    </a>
                @endif
                @if (Route::has('cart.index'))
                    <a href="{{ route('cart.index') }}"
                       class="block py-2 {{ request()->routeIs('cart.*') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">
                        Keranjang
                    </a>
                @endif

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="block py-2 {{ request()->routeIs('dashboard') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">
                       Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button class="text-bcake-wine font-medium">Logout</button>
                    </form>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block py-2 font-medium hover:text-bcake-wine">Login</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block py-2 font-medium hover:text-bcake-wine">Daftar</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    {{-- ======= OPTIONAL PAGE HEADER (Breeze $header) ======= --}}
    @isset($header)
        <div class="bg-white border-b border-bcake-truffle/10">
            <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </div>
    @endisset

    {{-- ======= FLASH MESSAGES ======= --}}
    @foreach (['status' => 'bg-bcake-icing/70 text-bcake-bitter', 'success' => 'bg-emerald-50 text-emerald-700', 'error' => 'bg-rose-50 text-rose-700'] as $key => $classes)
        @if(session($key))
            <div class="max-w-6xl mx-auto px-4 mt-4">
                <div class="rounded-xl border border-black/5 px-4 py-3 shadow-sm {{ $classes }}">
                    {{ session($key) }}
                </div>
            </div>
        @endif
    @endforeach

    {{-- ======= MAIN ======= --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    {{-- ======= FOOTER ======= --}}
    <footer class="border-t border-bcake-truffle/10 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm text-gray-500 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>© {{ date('Y') }} B’cake. All Rights Reserved.</p>
            <p class="text-gray-400">Crafted with <span class="text-bcake-cherry">♥</span> & cocoa.</p>
        </div>
    </footer>

    {{-- Simple mobile menu toggle (no dependency) --}}
    <script>
      (() => {
        const btn = document.getElementById('menuBtn');
        const panel = document.getElementById('mobileMenu');
        if (!btn || !panel) return;
        btn.addEventListener('click', () => {
          const isOpen = !panel.classList.contains('hidden');
          panel.classList.toggle('hidden');
          btn.setAttribute('aria-expanded', String(!isOpen));
        });
      })();
    </script>

    @stack('scripts')
</body>
</html>
