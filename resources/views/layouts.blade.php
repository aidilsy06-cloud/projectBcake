<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'B’cake' }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  @vite(['resources/js/app.js'])
  <style>
    .grain{ position:relative; }
    .grain:before{
      content:""; position:absolute; inset:0; pointer-events:none;
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' opacity='0.05'%3E%3Cfilter id='n'%3E%3CfeTurbulence baseFrequency='0.65' numOctaves='2'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
      mix-blend-mode:multiply;
    }
  </style>
</head>
<body class="bg-bcake-icing/30 text-bcake-bitter">
  <!-- Navbar -->
  <header class="sticky top-0 z-40 backdrop-blur bg-bcake-icing/60 border-b border-bcake-truffle/20">
    <nav class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="{{ route('home') }}" class="flex items-center gap-2">
        <!-- simple logo lockup -->
        <span class="inline-flex h-9 w-9 rounded-full bg-bcake-cherry text-white items-center justify-center font-bold">B</span>
        <span class="font-display text-xl tracking-wide">B’cake</span>
      </a>
      <ul class="hidden md:flex items-center gap-6">
        <li><a href="{{ route('products.index') }}" class="hover:text-bcake-cherry transition">Produk</a></li>
        <li><a href="#" class="hover:text-bcake-cherry transition">Tentang</a></li>
        <li><a href="#" class="hover:text-bcake-cherry transition">Kontak</a></li>
      </ul>
      <div class="flex items-center gap-3">
        @auth
          <a href="#" class="text-sm hover:text-bcake-cherry">Hi, {{ auth()->user()->name }}</a>
        @else
          <a href="{{ route('login') }}" class="text-sm hover:text-bcake-cherry">Masuk</a>
          <x-button as="a" href="{{ route('register') }}">Daftar</x-button>
        @endauth
      </div>
    </nav>
  </header>

  <!-- Page -->
  <main class="min-h-[70vh]">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <footer class="mt-16 border-t border-bcake-truffle/20 bg-white">
    <div class="max-w-6xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-8">
      <div>
        <div class="font-display text-2xl">B’cake</div>
        <p class="mt-2 text-sm text-bcake-truffle">
          Rasa manis elegan, dari dapur kami ke momen spesialmu.
        </p>
      </div>
      <div>
        <div class="font-semibold mb-2">Tautan</div>
        <ul class="space-y-2 text-sm">
          <li><a class="hover:text-bcake-cherry" href="{{ route('products.index') }}">Katalog</a></li>
          <li><a class="hover:text-bcake-cherry" href="#">Cara Pemesanan</a></li>
          <li><a class="hover:text-bcake-cherry" href="#">Kebijakan</a></li>
        </ul>
      </div>
      <div>
        <div class="font-semibold mb-2">Kontak</div>
        <p class="text-sm">Instagram: @bcake.id<br>Email: hello@bcake.local</p>
      </div>
    </div>
    <div class="text-center text-xs text-bcake-truffle/80 py-4">
      © {{ date('Y') }} B’cake.
    </div>
  </footer>
</body>
</html>
