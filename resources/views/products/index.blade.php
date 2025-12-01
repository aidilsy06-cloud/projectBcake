@extends('layouts.app')

@section('title', 'Katalog — B’cake')

@push('head')
<style>
    /* ✨ CARD MUNCUL PELAN */
    @keyframes bcake-pop {
        0%   { transform: translateY(12px) scale(.96); opacity: 0; }
        60%  { transform: translateY(-2px) scale(1.02); opacity: 1; }
        100% { transform: translateY(0) scale(1); }
    }
    .bcake-notfound {
        animation: bcake-pop .55s ease-out;
    }

    /* 💓 HEART DENYUT */
    @keyframes bcake-heartbeat {
        0%,100% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(244,63,94,0)); }
        50%     { transform: scale(1.18); filter: drop-shadow(0 0 10px rgba(244,63,94,.55)); }
    }
    .bcake-heart {
        animation: bcake-heartbeat 1.8s ease-in-out infinite;
    }

    /* 🌸 SELURUH CARD GOYANG PELAN (SLOWMO) */
    @keyframes bcake-soft-bounce {
        0%   { transform: translateY(0); }
        25%  { transform: translateY(-2px); }
        50%  { transform: translateY(1px); }
        75%  { transform: translateY(-1px); }
        100% { transform: translateY(0); }
    }
    .bcake-soft-bounce {
        animation: bcake-soft-bounce 3.5s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
<section class="max-w-6xl mx-auto px-6 py-10">
    {{-- Tombol kembali --}}
    <div class="mb-4">
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 px-5 py-2 rounded-full 
                  bg-rose-200 text-bcake-wine font-medium 
                  shadow-md hover:bg-rose-300 hover:shadow-lg transition">
            ← Kembali
        </a>
    </div>

    {{-- Judul halaman --}}
    <h2 class="font-display text-3xl mb-2">
        {{ $q ? 'Hasil Pencarian' : 'Katalog Produk' }}
    </h2>

    {{-- Subjudul / info pencarian --}}
    @if($q)
        <p class="text-sm text-bcake-truffle/70 mb-6">
            Menampilkan hasil untuk:
            <span class="font-semibold text-bcake-wine">"{{ $q }}"</span>
        </p>
    @else
        <p class="text-sm text-bcake-truffle/70 mb-6">
            Jelajahi koleksi kue manis pilihan B’cake untuk setiap momen spesialmu ✨
        </p>
    @endif

    {{-- ================== NOTIF JIKA PENCARIAN TIDAK DITEMUKAN ================== --}}
    @if(!empty($notFound) && $notFound)
        <div class="mb-10 relative bcake-notfound">
            {{-- glow lembut belakang card --}}
            <div class="absolute -inset-1 rounded-[2.2rem] 
                        bg-gradient-to-r from-[#ffd1e3] via-[#ffe6f2] to-[#ffd1e3] 
                        opacity-70 blur-xl"></div>

            {{-- CARD NOTIF (SEMUA ISI GOYANG PELAN) --}}
            <div class="relative bg-[#fff7fb]/95 border border-rose-200/80 rounded-[2rem]
                        px-6 py-7 text-center shadow-[0_18px_55px_rgba(244,63,94,0.18)] bcake-soft-bounce">

                <p class="text-bcake-wine text-lg font-semibold mb-1 flex items-center justify-center gap-2">
                    <span class="bcake-heart text-2xl">💔</span>
                    <span>Pencarian tidak ditemukan</span>
                </p>

                <p class="text-bcake-truffle/80">
                    Sepertinya belum ada kue yang cocok dengan pencarianmu.
                </p>
                <p class="text-bcake-truffle/80 mt-1">
                    Pencarian <span class="font-semibold">"{{ $q }}"</span> belum menemukan kue di katalog B’cake.
                </p>
                <p class="text-bcake-truffle/70 mt-1">
                    Coba pakai pilihan kata lain yang lebih manis, misalnya:
                </p>

                {{-- chip saran kata kunci lucu --}}
                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    <a href="{{ route('products.index', ['q' => 'ultah']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-medium 
                              bg-[#ffe3f0] text-bcake-wine hover:bg-[#ffd1e6] transition">
                        🎂 Kue ulang tahun
                    </a>
                    <a href="{{ route('products.index', ['q' => 'donat']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-medium 
                              bg-[#ffe3f0] text-bcake-wine hover:bg-[#ffd1e6] transition">
                        🍩 Donat lucu
                    </a>
                    <a href="{{ route('products.index', ['q' => 'coklat']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-medium 
                              bg-[#ffe3f0] text-bcake-wine hover:bg-[#ffd1e6] transition">
                        🍫 Kue coklat
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- ================== LIST PRODUK ================== --}}
    @if(!$products->isEmpty())
        <div class="space-y-6">
            @foreach ($products as $p)
                @php
                    $img = $p->image_path
                            ? asset('storage/' . $p->image_path)
                            : asset('image/cake.jpg');
                @endphp

                <article
                    class="grid md:grid-cols-12 gap-4 items-center rounded-3xl bg-white/80 backdrop-blur 
                           border border-rose-200 shadow-[0_20px_40px_rgba(137,5,36,0.06)] overflow-hidden">

                    {{-- Thumbnail kiri --}}
                    <div class="md:col-span-3">
                        <div class="relative p-4">
                            <a href="{{ route('products.show', $p->slug ?? $p->id) }}" class="block group">
                                <img src="{{ $img }}" alt="{{ $p->name }}"
                                     class="w-full aspect-[4/3] md:aspect-square object-cover rounded-2xl 
                                            ring-1 ring-rose-100 shadow-md 
                                            transition duration-300 group-hover:scale-[1.03] group-hover:shadow-lg" />
                            </a>

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
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <h3 class="font-medium text-lg md:text-xl text-bcake-bitter">
                                {{ $p->name }}
                            </h3>
                            <span
                                class="inline-flex items-center gap-1 text-xs uppercase tracking-widest text-bcake-truffle/70">
                                <span class="h-1.5 w-1.5 rounded-full bg-bcake-cherry"></span>
                                New Arrival
                            </span>
                        </div>

                        <p class="mt-2 text-sm text-bcake-truffle/80">
                            {{ $p->short_description ?? 'Lezat & elegan untuk momen spesial. Dibuat segar setiap hari dengan bahan premium.' }}
                        </p>

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <span
                                class="inline-flex items-center rounded-full bg-[#fce7ef] text-bcake-wine font-semibold px-4 py-2">
                                {{ 'Rp ' . number_format($p->price, 0, ',', '.') }}
                            </span>

                            <a href="{{ route('products.show', $p->slug ?? $p->id) }}"
                               class="inline-flex items-center text-sm px-4 py-2 rounded-full border border-rose-200 
                                      text-bcake-wine hover:bg-rose-50">
                                Detail
                            </a>

                            <form action="{{ route('cart.add', $p) }}" method="POST" class="inline-flex">
                                @csrf
                                <input type="hidden" name="qty" value="1">
                                <button type="submit"
                                        class="inline-flex items-center text-sm px-4 py-2 rounded-full bg-bcake-wine 
                                               text-white hover:bg-bcake-cherry shadow-sm">
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        {{-- kalau database memang kosong & tidak sedang search --}}
        @unless($q)
            <div class="mt-6 bg-rose-50 border border-dashed border-rose-200 rounded-3xl px-6 py-8 text-center text-bcake-truffle/80">
                Belum ada produk yang ditambahkan ke katalog B’cake.
            </div>
        @endunless
    @endif

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $products->links() ?? '' }}
    </div>
</section>
@endsection
