@extends('layouts.app')

@section('title', 'Katalog — B’cake')

@push('head')
<style>
    @keyframes bcake-pop {
        0%   { transform: translateY(12px) scale(.96); opacity: 0; }
        60%  { transform: translateY(-2px) scale(1.02); opacity: 1; }
        100% { transform: translateY(0) scale(1); }
    }
    .bcake-notfound { animation: bcake-pop .55s ease-out; }

    @keyframes bcake-heartbeat {
        0%,100% { transform: scale(1); }
        50%     { transform: scale(1.18); }
    }
    .bcake-heart { animation: bcake-heartbeat 1.8s ease-in-out infinite; }

    @keyframes bcake-soft-bounce {
        0%   { transform: translateY(0); }
        25%  { transform: translateY(-2px); }
        50%  { transform: translateY(1px); }
        75%  { transform: translateY(-1px); }
        100% { transform: translateY(0); }
    }
    .bcake-soft-bounce { animation: bcake-soft-bounce 3.5s ease-in-out infinite; }
</style>
@endpush

@section('content')
<section
    x-data="{
        openFilter: false,
        activeTab: 'harga',
        selectedPrice: @js($priceRange ?? ''),
        selectedCategory: @js((string)($currentCategoryId ?? ''))
    }"
    class="max-w-6xl mx-auto px-6 py-10"
>

    {{-- Tombol kembali --}}
    <div class="mb-4">
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 px-5 py-2 rounded-full 
                  bg-rose-200 text-bcake-wine font-medium 
                  shadow-md hover:bg-rose-300 hover:shadow-lg transition">
            ← Kembali
        </a>
    </div>

    {{-- Judul --}}
    <h2 class="font-display text-3xl mb-3">
        Katalog Produk
    </h2>

    {{-- ========================= FILTER BAR ========================= --}}
    <div class="flex flex-wrap items-center gap-3 mb-6">

        {{-- Search + tombol filter nempel --}}
        <form action="{{ route('products.index') }}" method="get" class="flex items-center gap-2 flex-1 min-w-[260px]">
            {{-- bawa filter lain --}}
            <input type="hidden" name="category_id" :value="selectedCategory">
            <input type="hidden" name="price_range" :value="selectedPrice">

            <div class="relative flex-1">
                <input type="text" name="q" placeholder="Cari kue…" value="{{ $q }}"
                       class="w-full rounded-full border border-rose-200 bg-white/70 px-4 py-2 pr-10 text-sm
                              focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
                <button class="absolute right-3 top-1/2 -translate-y-1/2">
                    🔍
                </button>
            </div>

            <button type="button"
                    @click="openFilter = true"
                    class="inline-flex items-center justify-center h-9 px-3 rounded-full border border-rose-200 bg-white/80
                           text-xs md:text-sm text-bcake-wine hover:bg-rose-50 whitespace-nowrap">
                Filter
                <span class="ml-1 h-2 w-2 rounded-full bg-bcake-wine"
                      x-show="selectedPrice || selectedCategory"></span>
            </button>
        </form>

        {{-- Reset semua filter --}}
        @if($q || $currentCategoryId || $priceRange)
            <a href="{{ route('products.index') }}"
               class="text-sm underline text-bcake-truffle/60 hover:text-bcake-wine">
                Reset
            </a>
        @endif

    </div>

    {{-- Info filter aktif --}}
    @if($q || $currentCategoryId || $priceRange)
        @php
            $priceLabel = null;
            switch ($priceRange) {
                case 'lt_10k':  $priceLabel = '< Rp 10.000'; break;
                case '10_25':   $priceLabel = 'Rp 10.000 – Rp 25.000'; break;
                case '25_50':   $priceLabel = 'Rp 25.001 – Rp 50.000'; break;
                case '50_100':  $priceLabel = 'Rp 50.001 – Rp 100.000'; break;
                case 'gt_100':  $priceLabel = '> Rp 100.000'; break;
            }
        @endphp

        <div class="text-sm text-bcake-truffle/70 mb-6 flex flex-wrap gap-2 items-center">
            <span>Menampilkan:</span>

            @if($q)
                <span class="px-3 py-1 rounded-full bg-rose-50 text-bcake-wine text-xs">
                    Keyword: "{{ $q }}"
                </span>
            @endif

            @if($currentCategoryId)
                @php $catNow = $categories->firstWhere('id', $currentCategoryId); @endphp
                @if($catNow)
                    <span class="px-3 py-1 rounded-full bg-rose-50 text-bcake-wine text-xs">
                        Kategori: {{ $catNow->name }}
                    </span>
                @endif
            @endif

            @if($priceLabel)
                <span class="px-3 py-1 rounded-full bg-rose-50 text-bcake-wine text-xs">
                    Harga: {{ $priceLabel }}
                </span>
            @endif
        </div>
    @else
        <p class="text-sm text-bcake-truffle/70 mb-6">
            Jelajahi koleksi kue manis pilihan B’cake untuk setiap momen spesialmu ✨
        </p>
    @endif

    {{-- ================== NOT FOUND ================== --}}
    @if($notFound)
        <div class="mb-10 relative bcake-notfound">

            <div class="absolute -inset-1 rounded-[2.2rem] 
                bg-gradient-to-r from-[#ffd1e3] via-[#ffe6f2] to-[#ffd1e3] 
                opacity-70 blur-xl"></div>

            <div class="relative bg-[#fff7fb]/95 border border-rose-200/80 rounded-[2rem]
                px-6 py-7 text-center shadow-[0_18px_55px_rgba(244,63,94,0.18)] bcake-soft-bounce">

                <p class="text-bcake-wine text-lg font-semibold mb-1 flex items-center justify-center gap-2">
                    <span class="bcake-heart text-2xl">💔</span>
                    <span>Tidak ditemukan</span>
                </p>

                <p class="text-bcake-truffle/80">
                    Tidak ada hasil yang cocok dengan filter yang kamu pilih.
                </p>

                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    <a href="{{ route('products.index', ['q' => 'ultah']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-medium bg-[#ffe3f0] text-bcake-wine">
                        🎂 Kue Ulang Tahun
                    </a>
                    <a href="{{ route('products.index', ['q' => 'donat']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-medium bg-[#ffe3f0] text-bcake-wine">
                        🍩 Donat Lucu
                    </a>
                    <a href="{{ route('products.index', ['q' => 'coklat']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-medium bg-[#ffe3f0] text-bcake-wine">
                        🍫 Coklat
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
                    $raw = $p->image_url ?? $p->cover_url ?? $p->photo ?? $p->image ?? null;
                    if ($raw) {
                        $raw = ltrim($raw, '/');
                        if (substr($raw, 0, 4) === 'http') {
                            $img = $raw;
                        } elseif (strpos($raw, 'storage/') === 0 || strpos($raw, 'image/') === 0) {
                            $img = asset($raw);
                        } else {
                            $img = asset('storage/'.$raw);
                        }
                    } else {
                        $img = asset('image/cake.jpg');
                    }
                    $to = route('products.show', $p->slug ?? $p->id);
                @endphp

                <article class="grid md:grid-cols-12 gap-4 items-center rounded-3xl bg-white/80 backdrop-blur 
                    border border-rose-200 shadow-[0_20px_40px_rgba(137,5,36,0.06)] overflow-hidden">

                    {{-- Thumbnail --}}
                    <div class="md:col-span-3">
                        <div class="p-4">
                            <a href="{{ $to }}" class="block group">
                                <img src="{{ $img }}" alt="{{ $p->name }}"
                                     class="w-full aspect-[4/3] md:aspect-square object-cover rounded-2xl 
                                        ring-1 ring-rose-100 shadow-md 
                                        transition duration-300 group-hover:scale-[1.03] group-hover:shadow-lg" />
                            </a>
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div class="md:col-span-9 pr-4 md:pr-6 py-4">
                        <h3 class="font-medium text-lg md:text-xl text-bcake-bitter">
                            {{ $p->name }}
                        </h3>

                        <p class="mt-2 text-sm text-bcake-truffle/80">
                            {{ $p->short_description ?? 'Kue segar setiap hari dengan bahan premium.' }}
                        </p>

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center rounded-full bg-[#fce7ef] text-bcake-wine font-semibold px-4 py-2">
                                {{ 'Rp ' . number_format($p->price, 0, ',', '.') }}
                            </span>

                            <a href="{{ $to }}"
                               class="inline-flex items-center text-sm px-4 py-2 rounded-full border border-rose-200 
                                  text-bcake-wine hover:bg-rose-50">
                                Detail
                            </a>

                            <form action="{{ route('cart.add', $p) }}" method="POST">
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
    @endif

    {{-- Tidak ada produk sama sekali --}}
    @if($products->isEmpty() && !$q && !$currentCategoryId && !$priceRange)
        <div class="mt-6 bg-rose-50 border border-dashed border-rose-200 rounded-3xl px-6 py-8 text-center text-bcake-truffle/80">
            Belum ada produk yang ditambahkan ke katalog B’cake.
        </div>
    @endif

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $products->links() }}
    </div>

    {{-- ================== BOTTOM SHEET FILTER ================== --}}
    <div x-show="openFilter"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-end justify-center bg-black/30"
         style="display:none;">
        <div class="absolute inset-0" @click="openFilter = false"></div>

        <div x-transition.origin.bottom
             class="relative w-full max-w-md bg-white rounded-t-3xl shadow-2xl p-5 pb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-bcake-bitter">
                    Filter sesuai kebutuhan
                </h3>
                <a href="{{ route('products.index', ['q' => $q]) }}"
                   class="text-sm text-rose-500 font-semibold">
                    Reset
                </a>
            </div>

            <div class="flex gap-6 border-b border-slate-200 mb-4 text-sm">
                <button type="button"
                        @click="activeTab = 'harga'"
                        :class="activeTab === 'harga' ? 'border-b-2 border-bcake-wine text-bcake-wine font-semibold pb-2' : 'pb-2 text-slate-400'">
                    Harga
                </button>
                <button type="button"
                        @click="activeTab = 'kategori'"
                        :class="activeTab === 'kategori' ? 'border-b-2 border-bcake-wine text-bcake-wine font-semibold pb-2' : 'pb-2 text-slate-400'">
                    Kategori
                </button>
                <button type="button"
                        @click="activeTab = 'lainnya'"
                        :class="activeTab === 'lainnya' ? 'border-b-2 border-bcake-wine text-bcake-wine font-semibold pb-2' : 'pb-2 text-slate-400'">
                    Lainnya
                </button>
            </div>

            <form action="{{ route('products.index') }}" method="get" class="space-y-3">
                <input type="hidden" name="q" value="{{ $q }}">

                {{-- TAB HARGA --}}
                <div x-show="activeTab === 'harga'" x-cloak class="space-y-3">
                    @php
                        $options = [
                            ''         => 'Semua harga',
                            'lt_10k'   => '< Rp 10.000',
                            '10_25'    => 'Rp 10.000 – Rp 25.000',
                            '25_50'    => 'Rp 25.001 – Rp 50.000',
                            '50_100'   => 'Rp 50.001 – Rp 100.000',
                            'gt_100'   => '> Rp 100.000',
                        ];
                    @endphp

                    @foreach($options as $value => $label)
                        <label class="flex items-center justify-between py-1.5 cursor-pointer">
                            <span class="text-sm text-bcake-bitter">
                                {{ $label }}
                            </span>
                            <span
                                class="inline-flex items-center justify-center h-5 w-5 rounded-full border-2"
                                :class="selectedPrice === @js($value) ? 'border-bcake-wine' : 'border-slate-300'">
                                <input type="radio" name="price_range" value="{{ $value }}"
                                       class="sr-only"
                                       x-model="selectedPrice">
                                <span class="h-2.5 w-2.5 rounded-full bg-bcake-wine"
                                      x-show="selectedPrice === @js($value)"></span>
                            </span>
                        </label>
                        @if(!$loop->last)
                            <div class="h-px bg-slate-100"></div>
                        @endif
                    @endforeach
                </div>

                {{-- TAB KATEGORI --}}
                <div x-show="activeTab === 'kategori'" x-cloak class="space-y-3">
                    <label class="flex items-center justify-between py-1.5 cursor-pointer">
                        <span class="text-sm text-bcake-bitter">
                            Semua kategori
                        </span>
                        <span
                            class="inline-flex items-center justify-center h-5 w-5 rounded-full border-2"
                            :class="!selectedCategory ? 'border-bcake-wine' : 'border-slate-300'">
                            <input type="radio" name="category_id" value=""
                                   class="sr-only"
                                   x-model="selectedCategory">
                            <span class="h-2.5 w-2.5 rounded-full bg-bcake-wine"
                                  x-show="!selectedCategory"></span>
                        </span>
                    </label>
                    <div class="h-px bg-slate-100"></div>

                    @foreach($categories as $cat)
                        <label class="flex items-center justify-between py-1.5 cursor-pointer">
                            <span class="text-sm text-bcake-bitter">
                                {{ $cat->name }}
                            </span>
                            <span
                                class="inline-flex items-center justify-center h-5 w-5 rounded-full border-2"
                                :class="selectedCategory === @js((string)$cat->id) ? 'border-bcake-wine' : 'border-slate-300'">
                                <input type="radio" name="category_id" value="{{ $cat->id }}"
                                       class="sr-only"
                                       x-model="selectedCategory">
                                <span class="h-2.5 w-2.5 rounded-full bg-bcake-wine"
                                      x-show="selectedCategory === @js((string)$cat->id)"></span>
                            </span>
                        </label>
                        @if(!$loop->last)
                            <div class="h-px bg-slate-100"></div>
                        @endif
                    @endforeach
                </div>

                {{-- TAB LAINNYA --}}
                <div x-show="activeTab === 'lainnya'" x-cloak class="pt-2 pb-4 text-sm text-bcake-truffle/80">
                    Fitur filter lainnya (rating, tipe kue, dsb) bisa ditambah nanti 🍰
                </div>

                {{-- hidden yang benar-benar dikirim --}}
                <input type="hidden" name="price_range" :value="selectedPrice">
                <input type="hidden" name="category_id" :value="selectedCategory">

                <button type="submit"
                        class="mt-4 w-full py-3 rounded-full bg-rose-600 text-white font-semibold text-sm">
                    Terapkan
                </button>
            </form>
        </div>
    </div>

</section>
@endsection
