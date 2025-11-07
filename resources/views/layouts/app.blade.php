<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $title ?? 'B’cake')</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <style>body{font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}</style>

    @stack('head')
</head>
<body class="bg-rose-50 text-gray-800 selection:bg-bcake-icing selection:text-bcake-bitter">

    {{-- ================= NAVBAR ================= --}}
    <header class="bg-white/90 backdrop-blur border-b border-bcake-truffle/10 sticky top-0 z-40">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            {{-- BRAND --}}
            <div class="flex items-center gap-3">
                {{-- Sidebar Open Button (Desktop Left) --}}
                <button id="openSidebar"
                        class="hidden md:inline-flex items-center justify-center w-10 h-10 rounded-full border border-bcake-truffle/20 hover:bg-rose-50"
                        aria-label="Buka menu info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <a href="{{ route('home') }}" class="text-2xl font-extrabold" style="font-family:'Playfair Display',serif;">
                    <span class="text-bcake-wine">B’</span><span class="text-bcake-bitter">cake</span>
                </a>

                {{-- (opsional) tampilkan cart kecil dekat logo di layar kecil --}}
                <div class="md:hidden ml-2">
                    {{-- Keranjang (inline, tanpa komponen) --}}
                    <a href="{{ route('cart.index') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-2 shadow-md ring-1 ring-black/5 hover:bg-white/95 transition"
                       aria-label="Buka keranjang ({{ (int)($cartCount ?? 0) }})">
                      <svg class="h-5 w-5" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <defs>
                          <linearGradient id="cartBody" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%"  stop-color="#FF9FB3"/>
                            <stop offset="100%" stop-color="#D2335B"/>
                          </linearGradient>
                          <linearGradient id="wheel" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%"  stop-color="#FFE4EA"/>
                            <stop offset="100%" stop-color="#C5B7BE"/>
                          </linearGradient>
                        </defs>
                        <rect x="7" y="14" rx="4" ry="4" width="38" height="8" fill="url(#cartBody)"/>
                        <path d="M10 20h34l-2.5 15a4 4 0 0 1-3.9 3.3H18.4a4 4 0 0 1-3.9-3.2L10 20Z" fill="url(#cartBody)" opacity=".95"/>
                        <path d="M16 23h22M15 28h24M14 33h26" stroke="white" stroke-opacity=".6" stroke-width="1.6" stroke-linecap="round"/>
                        <path d="M13 14c0-3 2.5-5 5.5-5H28" stroke="#A30F33" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M12 16c0 0 3-3 6-3" stroke="#FFDDE6" stroke-width="2" stroke-linecap="round" />
                        <circle cx="19" cy="41" r="4.6" fill="url(#wheel)"/>
                        <circle cx="36" cy="41" r="4.6" fill="url(#wheel)"/>
                        <circle cx="19" cy="41" r="2.1" fill="#5B4E53"/>
                        <circle cx="36" cy="41" r="2.1" fill="#5B4E53"/>
                        <circle cx="45" cy="13" r="1.3" fill="#FFDDE6"/>
                        <circle cx="48" cy="16" r="1.6" fill="#FFBACB"/>
                      </svg>
                      <span class="text-base font-medium tabular-nums">{{ (int)($cartCount ?? 0) }}</span>
                      @if((int)($cartCount ?? 0) > 0)
                        <span class="ml-0.5 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-bcake-wine px-1 text-[10px] font-semibold text-white leading-none">
                          {{ (int)($cartCount ?? 0) }}
                        </span>
                      @endif
                    </a>
                </div>
            </div>

            {{-- NAV DESKTOP --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">Produk</a>
                <a href="{{ route('help') }}" class="{{ request()->routeIs('help') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">Bantuan</a>

                {{-- ====== CART (inline, tanpa komponen) ====== --}}
                <a href="{{ route('cart.index') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-2 shadow-md ring-1 ring-black/5 hover:bg-white/95 transition"
                   aria-label="Buka keranjang ({{ (int)($cartCount ?? 0) }})">
                  <svg class="h-5 w-5" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <defs>
                      <linearGradient id="cartBody" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%"  stop-color="#FF9FB3"/>
                        <stop offset="100%" stop-color="#D2335B"/>
                      </linearGradient>
                      <linearGradient id="wheel" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%"  stop-color="#FFE4EA"/>
                        <stop offset="100%" stop-color="#C5B7BE"/>
                      </linearGradient>
                    </defs>
                    <rect x="7" y="14" rx="4" ry="4" width="38" height="8" fill="url(#cartBody)"/>
                    <path d="M10 20h34l-2.5 15a4 4 0 0 1-3.9 3.3H18.4a4 4 0 0 1-3.9-3.2L10 20Z" fill="url(#cartBody)" opacity=".95"/>
                    <path d="M16 23h22M15 28h24M14 33h26" stroke="white" stroke-opacity=".6" stroke-width="1.6" stroke-linecap="round"/>
                    <path d="M13 14c0-3 2.5-5 5.5-5H28" stroke="#A30F33" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M12 16c0 0 3-3 6-3" stroke="#FFDDE6" stroke-width="2" stroke-linecap="round" />
                    <circle cx="19" cy="41" r="4.6" fill="url(#wheel)"/>
                    <circle cx="36" cy="41" r="4.6" fill="url(#wheel)"/>
                    <circle cx="19" cy="41" r="2.1" fill="#5B4E53"/>
                    <circle cx="36" cy="41" r="2.1" fill="#5B4E53"/>
                    <circle cx="45" cy="13" r="1.3" fill="#FFDDE6"/>
                    <circle cx="48" cy="16" r="1.6" fill="#FFBACB"/>
                  </svg>
                  <span class="text-base font-medium tabular-nums">{{ (int)($cartCount ?? 0) }}</span>
                  @if((int)($cartCount ?? 0) > 0)
                    <span class="ml-0.5 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-bcake-wine px-1 text-[10px] font-semibold text-white leading-none">
                      {{ (int)($cartCount ?? 0) }}
                    </span>
                  @endif
                </a>

                {{-- AUTH --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-bcake-wine font-semibold' : 'hover:text-bcake-wine' }}">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm font-medium text-bcake-wine hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-bcake-wine">Login</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-bcake-wine px-4 py-2 rounded-xl shadow hover:opacity-90">Daftar</a>
                @endauth
            </div>

            {{-- HAMBURGER MOBILE --}}
            <button id="menuBtn" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg border border-bcake-truffle/20">
                <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path id="iconBars" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path id="iconX" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </nav>

        <div class="h-1 bg-bcake-gradient"></div>

        {{-- MOBILE MENU --}}
        <div id="mobileMenu" class="md:hidden hidden border-t border-bcake-truffle/10 bg-white">
            <div class="max-w-6xl mx-auto px-4 py-3 space-y-2">
                <a href="{{ route('products.index') }}" class="block py-2">Produk</a>
                <a href="{{ route('help') }}" class="block py-2">Bantuan</a>

                {{-- Keranjang (inline, tanpa komponen) --}}
                <div class="py-2">
                  <a href="{{ route('cart.index') }}"
                     class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-2 shadow-md ring-1 ring-black/5 hover:bg-white/95 transition w-max"
                     aria-label="Buka keranjang ({{ (int)($cartCount ?? 0) }})">
                    <svg class="h-5 w-5" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <defs>
                        <linearGradient id="cartBody" x1="0" y1="0" x2="1" y2="1">
                          <stop offset="0%"  stop-color="#FF9FB3"/>
                          <stop offset="100%" stop-color="#D2335B"/>
                        </linearGradient>
                        <linearGradient id="wheel" x1="0" y1="0" x2="1" y2="1">
                          <stop offset="0%"  stop-color="#FFE4EA"/>
                          <stop offset="100%" stop-color="#C5B7BE"/>
                        </linearGradient>
                      </defs>
                      <rect x="7" y="14" rx="4" ry="4" width="38" height="8" fill="url(#cartBody)"/>
                      <path d="M10 20h34l-2.5 15a4 4 0 0 1-3.9 3.3H18.4a4 4 0 0 1-3.9-3.2L10 20Z" fill="url(#cartBody)" opacity=".95"/>
                      <path d="M16 23h22M15 28h24M14 33h26" stroke="white" stroke-opacity=".6" stroke-width="1.6" stroke-linecap="round"/>
                      <path d="M13 14c0-3 2.5-5 5.5-5H28" stroke="#A30F33" stroke-width="2.5" stroke-linecap="round"/>
                      <path d="M12 16c0 0 3-3 6-3" stroke="#FFDDE6" stroke-width="2" stroke-linecap="round" />
                      <circle cx="19" cy="41" r="4.6" fill="url(#wheel)"/>
                      <circle cx="36" cy="41" r="4.6" fill="url(#wheel)"/>
                      <circle cx="19" cy="41" r="2.1" fill="#5B4E53"/>
                      <circle cx="36" cy="41" r="2.1" fill="#5B4E53"/>
                      <circle cx="45" cy="13" r="1.3" fill="#FFDDE6"/>
                      <circle cx="48" cy="16" r="1.6" fill="#FFBACB"/>
                    </svg>
                    <span class="text-base font-medium tabular-nums">{{ (int)($cartCount ?? 0) }}</span>
                    @if((int)($cartCount ?? 0) > 0)
                      <span class="ml-0.5 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-bcake-wine px-1 text-[10px] font-semibold text-white leading-none">
                        {{ (int)($cartCount ?? 0) }}
                      </span>
                    @endif
                  </a>
                </div>

                {{-- Sidebar button mobile --}}
                <button id="openSidebarMobile" class="mt-1 inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-bcake-truffle/20 hover:bg-rose-50">
                    Info
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="block py-2">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-bcake-wine font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2">Login</a>
                    <a href="{{ route('register') }}" class="block py-2">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ================= MAIN ================= --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @isset($slot) {{ $slot }} @else @yield('content') @endisset
    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="border-t border-bcake-truffle/10 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm text-gray-500 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>© {{ date('Y') }} B’cake. All Rights Reserved.</p>
            <p class="text-gray-400">Crafted with <span class="text-bcake-cherry">♥</span> & cocoa.</p>
        </div>
    </footer>

    {{-- ================= SIDEBAR LEFT ================= --}}
    <div id="sbOverlay" class="fixed inset-0 bg-black/30 z-40 hidden opacity-0 transition-opacity duration-200"></div>

    <aside id="sidebar"
      class="fixed left-0 top-0 h-full w-[300px] bg-white z-50 border-r border-bcake-truffle/10 shadow-xl
             -translate-x-full transition-transform duration-300">

        {{-- HEADER SIDEBAR --}}
        <div class="flex items-center justify-between px-5 h-14 border-b border-bcake-truffle/10">
            <button id="closeSidebar" class="p-2 rounded-lg hover:bg-rose-50" aria-label="Tutup">✕</button>
            <div class="font-semibold text-bcake-bitter">Menu</div>
        </div>

        {{-- MENU LIST --}}
        <div class="p-5 space-y-3">
            <a href="{{ route('help') }}" class="block px-4 py-3 rounded-xl border border-bcake-truffle/15 hover:bg-rose-50">Bantuan</a>
            <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-xl border border-bcake-truffle/15 hover:bg-rose-50">Katalog Produk</a>
        </div>
    </aside>

    {{-- ================= SCRIPTS ================= --}}
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const ov   = document.getElementById('sbOverlay');
        const sb   = document.getElementById('sidebar');
        const panel = document.getElementById('mobileMenu');
        const iconBars = document.getElementById('iconBars');
        const iconX = document.getElementById('iconX');
        const openBtn  = document.getElementById('openSidebar');
        const openBtnM = document.getElementById('openSidebarMobile');
        const closeBtn = document.getElementById('closeSidebar');

        const open = () => { sb.classList.remove('-translate-x-full'); ov.classList.remove('hidden','opacity-0'); };
        const close = () => { sb.classList.add('-translate-x-full'); ov.classList.add('hidden','opacity-0'); };

        openBtn?.addEventListener('click', open);
        openBtnM?.addEventListener('click', () => { open(); panel?.classList.add('hidden'); });
        closeBtn?.addEventListener('click', close);
        ov?.addEventListener('click', close);
        window.addEventListener('keydown', (e) => e.key === 'Escape' && close());

        const btn = document.getElementById('menuBtn');
        if (btn && panel) {
          btn.addEventListener('click', () => {
            const isOpen = !panel.classList.contains('hidden');
            panel.classList.toggle('hidden');
            iconBars.classList.toggle('hidden');
            iconX.classList.toggle('hidden');
          });
        }
      });
    </script>

    @stack('scripts')
</body>
</html>
