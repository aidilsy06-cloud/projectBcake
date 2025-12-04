{{-- resources/views/products/by-category.blade.php --}}
@extends('layouts.app')

@section('title', 'Kategori ' . ($category->name ?? '') . ' — B’cake')
@section('meta_description', 'Menampilkan kue dalam kategori ' . ($category->name ?? ''))

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<section class="py-6">

    {{-- HEADER KATEGORI --}}
    <header class="mb-8">
        <p class="text-sm tracking-[.25em] uppercase text-rose-400">
            KATEGORI
        </p>
        <h1 class="mt-1 font-display text-3xl md:text-4xl text-bcake-wine">
            Kategori: {{ $category->name ?? '-' }}
        </h1>
        <p class="mt-2 text-sm md:text-base text-gray-600 max-w-2xl">
            Menampilkan kue dalam kategori
            <span class="font-semibold text-rose-600">{{ $category->name ?? '-' }}</span>.
        </p>
    </header>

    {{-- GRID PRODUK --}}
    @if($products->count())
        <div class="grid gap-6 md:gap-7 md:grid-cols-2 lg:grid-cols-3">

            @foreach ($products as $product)
                @php
                    // ==========================
                    // AMBIL URL GAMBAR YANG VALID
                    // ==========================
                    $raw = $product->image_url ?? '';

                    if (!$raw || trim($raw) === '') {
                        // fallback gambar default
                        $img = asset('image/slicecake.jpg');
                    } else {
                        if (Str::startsWith($raw, ['http://', 'https://'])) {
                            // sudah full URL (Unsplash, dll.)
                            $img = $raw;
                        } elseif (Str::startsWith($raw, ['storage/', 'image/'])) {
                            // path relatif dari folder public
                            $img = asset($raw);
                        } else {
                            // contoh: "products/xxx.jpg" atau "uploads/xxx"
                            // -> asumsikan di storage: /storage/{image_url}
                            $img = asset('storage/' . ltrim($raw, '/'));
                        }
                    }

                    // Format harga
                    $price = 'Rp ' . number_format((int) $product->price, 0, ',', '.');
                @endphp

                <article class="bg-white rounded-3xl shadow-soft overflow-hidden border border-rose-100/70">
                    {{-- IMG WRAPPER --}}
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="block overflow-hidden">
                        <img src="{{ $img }}"
                             alt="{{ $product->name }}"
                             class="w-full aspect-[4/3] object-cover transform hover:scale-[1.03] transition duration-300 ease-out">
                    </a>

                    {{-- BODY CARD --}}
                    <div class="p-4 md:p-5 flex flex-col gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-bcake-wine">
                                {{ strtoupper($product->name) }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                {{ $product->short_description ?? 'Kue manis siap menemani harimu 💗' }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between mt-2">
                            <span
                                class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-sm font-semibold text-rose-700 shadow-sm">
                                {{ $price }}
                            </span>

                            <a href="{{ route('products.show', $product->slug) }}"
                               class="inline-flex items-center justify-center rounded-full border border-rose-200 px-4 py-1.5 text-sm text-rose-700 hover:border-rose-400 hover:bg-rose-50 transition">
                                Detail
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        @if (method_exists($products, 'links'))
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif

    @else
        {{-- JIKA TIDAK ADA PRODUK --}}
        <div
            class="mt-10 rounded-2xl border border-dashed border-rose-200 bg-rose-50/60 px-6 py-10 text-center max-w-xl mx-auto">
            <p class="text-lg font-semibold text-bcake-wine">
                Belum ada produk di kategori ini.
            </p>
            <p class="mt-2 text-sm text-gray-600">
                Coba kembali beberapa saat lagi, atau jelajahi kategori lainnya di halaman produk.
            </p>
            <a href="{{ route('products.index') }}"
               class="mt-4 inline-flex items-center justify-center rounded-full bg-rose-600 px-5 py-2 text-sm font-medium text-white hover:bg-rose-700">
                Lihat Semua Produk
            </a>
        </div>
    @endif

</section>
@endsection
