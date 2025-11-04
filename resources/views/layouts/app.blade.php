<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'B’cake' }}</title>

    {{-- Assets --}}
    @vite(['resources/css/app.css'])

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
    </style>
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

            {{-- Links --}}
            <div class="hidden md:flex items-center gap-6">
                @if (Route::has('products.index'))
                    <a href="{{ route('products.index') }}" class="hover:text-bcake-wine">Produk</a>
                @endif

                @if (Route::has('cart.index'))
                    <a href="{{ route('cart.index') }}" class="hover:text-bcake-wine">Keranjang</a>
                @endif

                @auth
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
                @endauth
            </div>

            {{-- Mobile hamburger (opsional, sederhana) --}}
            <div class="md:hidden">
                @includeIf('layouts.navigation') {{-- kalau kamu pakai Breeze navigation.blade.php --}}
            </div>
        </nav>
        <div class="h-1 bg-bcake-gradient"></div>
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
    @if(session('status'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="rounded-xl2 bg-bcake-icing/70 text-bcake-bitter px-4 py-3 shadow-soft">
                {{ session('status') }}
            </div>
        </div>
    @endif

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

    @stack('scripts')
</body>
</html>
