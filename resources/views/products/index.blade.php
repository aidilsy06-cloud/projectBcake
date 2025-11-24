@extends('layouts.app')

@section('title', 'Katalog — B’cake')

@section('content')
    {{-- ================== KATALOG (List ala brochure) ================== --}}
    <section class="max-w-6xl mx-auto px-6 py-10">
        {{-- Kembali ke Home --}}
        <div class="mb-4">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-100 text-bcake-wine text-sm hover:bg-rose-200 transition">
                ← Kembali ke Home
            </a>
        </div>



        <h2 class="font-display text-3xl mb-6">Katalog Produk</h2>

        <div class="space-y-6">
            @foreach ($products as $p)
                @php
                    $img = $p->image_path ? asset('storage/' . $p->image_path) : asset('image/cake.jpg'); // fallback
                @endphp

                <article
                    class="grid md:grid-cols-12 gap-4 items-center rounded-3xl bg-white/80 backdrop-blur border border-rose-200 shadow-[0_20px_40px_rgba(137,5,36,0.06)] overflow-hidden">
                    {{-- Thumbnail kiri --}}
                    <div class="md:col-span-3">
                        <div class="relative p-4">

                            <a href="{{ route('products.show', $p->slug ?? $p->id) }}" class="block group">
                                <img src="{{ $img }}" alt="{{ $p->name }}"
                                    class="w-full aspect-[4/3] md:aspect-square object-cover rounded-2xl ring-1 ring-rose-100 shadow-md 
                  transition duration-300 group-hover:scale-[1.03] group-hover:shadow-lg" />
                            </a>

                            {{-- contoh badge diskon opsional --}}
                            @if (isset($p->discount) && $p->discount > 0)
                                <div
                                    class="absolute left-3 top-3 bg-bcake-wine text-white text-xs font-semibold px-2 py-1 rounded-full">
                                    -{{ $p->discount }}%
                                </div>
                            @endif

                        </div>
                    </div>


                    {{-- Konten kanan --}}
                    <div class="md:col-span-9 pr-4 md:pr-6 py-4">
                        {{-- Header: title + badge --}}
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <h3 class="font-medium text-lg md:text-xl text-bcake-bitter">
                                {{ $p->name }}
                            </h3>
                            <span
                                class="inline-flex items-center gap-1 text-xs uppercase tracking-widest text-bcake-truffle/70">
                                <span class="h-1.5 w-1.5 rounded-full bg-bcake-cherry"></span> New Arrival
                            </span>
                        </div>

                        {{-- Deskripsi singkat --}}
                        <p class="mt-2 text-sm text-bcake-truffle/80">
                            {{ $p->short_description ?? 'Lezat & elegan untuk momen spesial. Dibuat segar setiap hari dengan bahan premium.' }}
                        </p>

                        {{-- Bawah: harga pill + tombol --}}
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <span
                                class="inline-flex items-center rounded-full bg-[#fce7ef] text-bcake-wine font-semibold px-4 py-2">
                                {{ 'Rp ' . number_format($p->price, 0, ',', '.') }}
                            </span>

                            {{-- Tombol detail --}}
                            <a href="{{ route('products.show', $p->slug ?? $p->id) }}"
                                class="inline-flex items-center text-sm px-4 py-2 rounded-full border border-rose-200 text-bcake-wine hover:bg-rose-50">
                                Detail
                            </a>

                            {{-- Tombol Tambah ke Keranjang (qty default = 1) --}}
                            <form action="{{ route('cart.add', $p) }}" method="POST" class="inline-flex">
                                @csrf
                                <input type="hidden" name="qty" value="1">
                                <button type="submit"
                                    class="inline-flex items-center text-sm px-4 py-2 rounded-full bg-bcake-wine text-white hover:bg-bcake-cherry shadow-sm">
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination (opsional) --}}
        <div class="mt-8">
            {{ $products->links() ?? '' }}
        </div>
    </section>

@endsection
