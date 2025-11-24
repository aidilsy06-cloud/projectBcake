<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'B’cake — Elegant Bakery')</title>

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO / OG --}}
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="description" content="@yield('meta_description', 'Marketplace kue elegan — jual & beli cake favorit di B’cake.')">
    <meta name="theme-color" content="#890524">
    <meta name="color-scheme" content="light">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'B’cake — Elegant Bakery')))">
    <meta property="og:description" content="@yield('og_description', 'Tempat istimewa untuk menampilkan & menemukan kue terbaik.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('image/logo_bcake.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('tw_title', trim($__env->yieldContent('title', 'B’cake — Elegant Bakery')))">
    <meta name="twitter:description" content="@yield('tw_description', 'Tempat istimewa untuk menampilkan & menemukan kue terbaik.')">
    <meta name="twitter:image" content="{{ asset('image/logo_bcake.jpg') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/jpeg" sizes="32x32" href="{{ asset('image/logo_bcake.jpg') }}?v=2">
    <link rel="icon" type="image/jpeg" sizes="16x16" href="{{ asset('image/logo_bcake.jpg') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('image/logo_bcake.jpg') }}?v=2">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">

    {{-- AOS (Animate On Scroll) --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

    {{-- Alpine.js --}}
    <script src="https://unpkg.com/alpinejs" defer></script>

    <style>
        :root {
            --bcake-wine: #890524;
            --bcake-deep: #57091d;
            --bcake-cocoa: #362320;
        }

        body {
            font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', serif
        }

        .shadow-soft {
            box-shadow: 0 20px 40px rgba(54, 35, 32, .10);
        }

        .decorative,
        .grain,
        .bg-overlay,
        .mask-overlay,
        .sprinkles,
        .berryLayer {
            pointer-events: none !important;
            z-index: 0 !important;
        }

        main,
        header,
        nav,
        aside,
        section,
        a,
        button,
        .card,
        .btn {
            position: relative;
            z-index: 1;
        }

        /* drawer sidebar */
        #sidebarMobile {
            transition: transform .25s ease;
            transform: translateX(-100%);
        }

        #sidebarMobile[data-open="true"] {
            transform: translateX(0);
        }

        #backdropMobile {
            display: none;
        }

        #backdropMobile[data-open="true"] {
            display: block;
        }
    </style>

    @stack('head')
</head>

<body class="bg-rose-50 text-gray-800 antialiased min-h-screen flex flex-col">

    {{-- HEADER / NAVBAR --}}
    <header class="sticky top-0 z-50 w-full">
        <div class="bg-white/80 backdrop-blur border-b border-rose-200/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="grid items-center py-4 md:grid-cols-[auto_1fr_auto] gap-4">

                    {{-- brand + toggle --}}
                    <div class="flex items-center gap-3">
                        {{-- tombol garis tiga: SEKARANG MUNCUL DI DESKTOP & MOBILE --}}
                        <button id="btnSidebar"
                            class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-rose-200/70 text-rose-800"
                            aria-label="Buka menu" aria-expanded="false" aria-controls="sidebarMobile">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="opacity-80">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </button>

                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                            <img src="{{ asset('image/logo_bcake.jpg') }}" alt="Logo B’cake"
                                class="h-10 w-10 rounded-lg object-cover ring-1 ring-rose-200/60">
                            <span class="font-display text-2xl tracking-wide text-rose-800">B’cake</span>
                        </a>
                    </div>

                    {{-- nav desktop --}}
                    <div class="hidden md:flex items-center gap-6">
                        <ul class="flex items-center gap-7 text-rose-800/90">
                            <li>
                                <a href="{{ route('home') }}"
                                    class="{{ request()->routeIs('home') ? 'text-rose-900 font-semibold' : 'hover:text-rose-900' }}">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.index') }}"
                                    class="{{ request()->routeIs('products.*') ? 'text-rose-900 font-semibold' : 'hover:text-rose-900' }}">
                                    Produk
                                </a>
                            </li>
                            @if (Route::has('stores.index'))
                                <li>
                                    <a href="{{ route('stores.index') }}"
                                        class="{{ request()->routeIs('stores.*') ? 'text-rose-900 font-semibold' : 'hover:text-rose-900' }}">
                                        Toko
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ Route::has('buyer.help') && auth()->check() ? route('buyer.help') : route('help') }}"
                                    class="{{ request()->routeIs('help') || request()->routeIs('buyer.help') ? 'text-rose-900 font-semibold' : 'hover:text-rose-900' }}">
                                    Bantuan
                                </a>
                            </li>
                        </ul>

                        {{-- search --}}
                        <form action="{{ route('products.index') }}" method="get"
                            class="relative flex-1 min-w-0 max-w-xl" role="search">
                            <input name="q" type="text" placeholder="Cari kue…"
                                class="w-full rounded-full border border-rose-200/70 bg-white/70 px-4 py-2 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-rose-400"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </form>
                    </div>

                    {{-- actions kanan --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('cart.index') }}"
                            class="inline-flex items-center rounded-full border border-rose-200/70 bg-white/70 px-3 py-2 hover:border-rose-300"
                            aria-label="Keranjang">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 9m12-9l-2 9M9 22a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="rounded-full bg-rose-600 text-white px-4 py-2 text-sm hover:bg-rose-700">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="rounded-full border border-rose-200/70 px-4 py-2 text-sm hover:border-rose-300">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="rounded-full border border-rose-200/70 px-4 py-2 text-sm hover:border-rose-300">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="rounded-full bg-rose-700 text-white px-4 py-2 text-sm hover:bg-rose-800">
                                Daftar
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
            <div class="h-[3px] bg-gradient-to-r from-rose-900 via-rose-700 to-rose-500/90"></div>
        </div>
    </header>

    {{-- MOBILE / DESKTOP DRAWER (sidebar garis tiga) --}}
    <div id="backdropMobile" class="fixed inset-0 bg-black/30 z-40" aria-hidden="true"></div>
    <aside id="sidebarMobile"
        class="fixed top-0 left-0 bottom-0 w-[85%] max-w-[320px] bg-white z-50 p-5 border-r border-rose-200/60"
        role="dialog" aria-modal="true" aria-labelledby="mobileNavTitle">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('image/logo_bcake.jpg') }}"
                    class="h-8 w-8 rounded-lg object-cover ring-1 ring-rose-200/60" alt="Logo B’cake">
                <h2 id="mobileNavTitle" class="font-semibold">Navigasi</h2>
            </div>
            <button id="btnSidebarClose" aria-label="Tutup menu"
                class="w-9 h-9 inline-flex items-center justify-center rounded-full border border-rose-200/70">
                ✕
            </button>
        </div>

        <nav class="space-y-1 text-rose-800/90">
            <a href="{{ route('home') }}"
                class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('home') ? 'bg-rose-50 font-medium' : '' }}">
                🏠 Home
            </a>
            <a href="{{ route('products.index') }}"
                class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('products.*') ? 'bg-rose-50 font-medium' : '' }}">
                📋 Menu / Produk
            </a>
            @if (Route::has('stores.index'))
                <a href="{{ route('stores.index') }}"
                    class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('stores.*') ? 'bg-rose-50 font-medium' : '' }}">
                    🏪 Toko
                </a>
            @endif
            <a href="{{ route('cart.index') }}"
                class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('cart.*') ? 'bg-rose-50 font-medium' : '' }}">
                🛒 Keranjang
            </a>
            <a href="{{ Route::has('buyer.help') && auth()->check() ? route('buyer.help') : route('help') }}"
                class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('help') || request()->routeIs('buyer.help') ? 'bg-rose-50 font-medium' : '' }}">
                🆘 Bantuan
            </a>
            {{-- Link anchor ke section Tentang di home (kalau ada) --}}
            <a href="{{ route('about') }}"
                class="block px-3 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('about') ? 'bg-rose-50 font-medium' : '' }}">
                ℹ️ Tentang Kami
            </a>

        </nav>

        <div class="mt-6 border-t pt-4">
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg bg-rose-600 text-white text-center">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="w-full px-3 py-2 rounded-lg border border-rose-200/70">
                        Logout
                    </button>
                </form>
            @else
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg border border-rose-200/70 text-center">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-3 py-2 rounded-lg bg-rose-700 text-white text-center">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="flex-1 w-full">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-8">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-rose-200/50 bg-white mt-auto">
        <div
            class="max-w-7xl mx-auto px-6 lg:px-10 py-6 flex flex-col sm:flex-row items-center justify-between text-sm text-gray-500 gap-2">
            <p>© {{ date('Y') }} <b>B’cake</b>. Semua hak cipta dilindungi.</p>
            <p class="text-gray-400">Crafted with <span class="text-rose-500">♥</span> & cocoa.</p>
        </div>
    </footer>

    {{-- TOAST NOTIFIKASI GLOBAL --}}
    @php
        $flashSuccess = session('success') ?? session('login_success');
        $flashError = session('error');
        if (!$flashSuccess && request()->query('login') === 'success') {
            $flashSuccess = "Kamu berhasil login! Selamat datang kembali di B'cake 💗";
        }
    @endphp

    @if ($flashSuccess || $flashError)
        <div id="toastContainer" class="fixed bottom-6 right-6 z-50 max-w-xs space-y-3">
            @if ($flashSuccess)
                <div
                    class="mb-2 rounded-2xl border border-emerald-200 bg-white px-4 py-3 shadow-[0_18px_40px_rgba(16,185,129,.35)] flex items-start gap-3">
                    <div
                        class="h-7 w-7 flex items-center justify-center rounded-full bg-emerald-500 text-white text-sm">
                        ✔
                    </div>
                    <p class="text-sm text-emerald-900 font-medium">
                        {{ $flashSuccess }}
                    </p>
                </div>
            @endif

            @if ($flashError)
                <div
                    class="mb-2 rounded-2xl border border-rose-200 bg-white px-4 py-3 shadow-[0_18px_40px_rgba(244,63,94,.35)] flex items-start gap-3">
                    <div class="h-7 w-7 flex items-center justify-center rounded-full bg-rose-500 text-white text-sm">
                        !
                    </div>
                    <p class="text-sm text-rose-900 font-medium">
                        {{ $flashError }}
                    </p>
                </div>
            @endif
        </div>
    @endif

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnOpen = document.getElementById('btnSidebar');
            const drawer = document.getElementById('sidebarMobile');
            const btnClose = document.getElementById('btnSidebarClose');
            const backdrop = document.getElementById('backdropMobile');

            function openSidebar() {
                if (!drawer || !backdrop || !btnOpen) return;
                drawer.setAttribute('data-open', 'true');
                backdrop.setAttribute('data-open', 'true');
                btnOpen.setAttribute('aria-expanded', 'true');
            }

            function closeSidebar() {
                if (!drawer || !backdrop || !btnOpen) return;
                drawer.removeAttribute('data-open');
                backdrop.removeAttribute('data-open');
                btnOpen.setAttribute('aria-expanded', 'false');
            }

            btnOpen?.addEventListener('click', openSidebar);
            btnClose?.addEventListener('click', closeSidebar);
            backdrop?.addEventListener('click', closeSidebar);
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeSidebar();
            });

            // auto dismiss toast
            const toast = document.getElementById('toastContainer');
            if (toast) {
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity .4s ease';
                    setTimeout(() => toast.remove(), 400);
                }, 3500);
            }
        });
    </script>

    @stack('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 700, // lama animasi (ms)
            once: true, // animasi hanya sekali saat muncul
        });
    </script>

</body>

</html>
