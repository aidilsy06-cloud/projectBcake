<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "B’cake" }}</title>

    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-rose-50 text-gray-800">

    {{-- Navbar (Breeze partial) --}}
    @includeIf('layouts.navigation')

    {{-- Header opsional (Breeze biasa pakai $header) --}}
    @if (isset($header))
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
    @endif

    {{-- Konten utama: dukung $slot (komponen) & @section('content') (layout klasik) --}}
    <main class="max-w-6xl mx-auto px-6 py-8">
        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <footer class="text-center py-6 text-sm text-gray-500 border-t mt-10">
        © {{ date('Y') }} B’cake. All Rights Reserved.
    </footer>

    @stack('scripts')
</body>
</html>
