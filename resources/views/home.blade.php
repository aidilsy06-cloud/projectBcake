@extends('layouts.app')

@section('title', 'B’cake — Elegant Bakery')

@push('head')
<style>
    /* 🎀 Background stripes horizontal (garis ke samping) */
    .hero-cupcake-bg {
        background:
            repeating-linear-gradient(
                to bottom,
                #f7d2da 0px,   /* pink muda */
                #f7d2da 22px,  /* tebal warna 1 */
                #b55c69 22px,  /* wine/truffle */
                #b55c69 44px   /* tebal warna 2 (total 44px per pola) */
            );
    }

    /* 🎀 Bungkus hero + gerigi atas & bawah */
    .hero-scallop-wrap {
        position: relative;
        overflow: hidden;
    }

    /* Gerigi atas */
    .hero-scallop-wrap::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: -18px;
        height: 36px;
        background:
            radial-gradient(circle at 18px 18px, #ffffff 18px, transparent 19px) repeat-x;
        background-size: 36px 36px;
        transform: scaleY(-1);
    }

    /* Gerigi bawah */
    .hero-scallop-wrap::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -18px;
        height: 36px;
        background:
            radial-gradient(circle at 18px 18px, #ffffff 18px, transparent 19px) repeat-x;
        background-size: 36px 36px;
    }

    /* 🌸 PANEL TEKS HERO – versi clean & premium */
    .hero-text-panel {
        position: relative;
        display: inline-block;
        padding: 1.6rem 2.4rem;
        border-radius: 2rem;
        background: rgba(255, 248, 250, 0.92); /* krem soft */
        border: 1px solid rgba(255, 255, 255, 0.85);
        box-shadow: 0 16px 35px rgba(137, 5, 36, 0.15);
        backdrop-filter: blur(6px);
        overflow: hidden;
    }

    /* aksen strip gradien tipis di kiri card */
    .hero-text-panel::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: linear-gradient(180deg, #fbb6ce, #890524);
        opacity: 0.7;
    }

    /* ✨ JUDUL UTAMA HERO – slow motion float */
.hero-title {
    color: #6d0b26;
    letter-spacing: 0.02em;
    line-height: 1.1;
    font-weight: 700;
    text-shadow: 0 4px 14px rgba(137, 5, 36, 0.25);
    animation: floatY 6.5s ease-in-out infinite;
}

/* ✨ TAGLINE – slow + sedikit delay */
.hero-tagline {
    margin-top: 0.85rem;
    color: #8a4b58;
    font-size: 0.95rem;
    line-height: 1.6;
    text-shadow: 0 2px 10px rgba(137, 5, 36, 0.18);
    animation: floatY 6.5s ease-in-out infinite;
    animation-delay: .9s;
}

/* ✨ ANIMASI FLOAT VERSE SLOW-MOTION */
@keyframes floatY {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-4px); } /* lebih kecil, lebih mewah */
}

    @media (max-width: 767px) {
        .hero-text-panel {
            padding: 1.2rem 1.7rem;
            border-radius: 1.6rem;
        }
        .hero-title {
            font-size: 1.6rem;
        }
        .hero-tagline {
            font-size: 0.9rem;
        }
    }

    /* 🎂 FRAME FOTO DENGAN GERIGI ATAS & BAWAH (FOTO HERO) */
    .hero-photo-scallop {
        position: relative;
        border-radius: 1.75rem;
        overflow: hidden;
        background-color: #f7d2da; /* pink muda, nyatu sama background */
    }
    .hero-photo-scallop::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: -18px;
        height: 36px;
        background:
            radial-gradient(circle at 18px 18px, #f7d2da 18px, transparent 19px) repeat-x;
        background-size: 36px 36px;
        transform: scaleY(-1);
    }
    .hero-photo-scallop::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -18px;
        height: 36px;
        background:
            radial-gradient(circle at 18px 18px, #f7d2da 18px, transparent 19px) repeat-x;
        background-size: 36px 36px;
    }
    .hero-photo-scallop img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* 🌟 KATEGORY FLOATING ANIMASI */
    .category-float {
        position: relative;
        border-radius: 1.5rem;
        overflow: hidden;
        background-color: #6a4e4a26;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
        animation: floatCard 4s ease-in-out infinite;
        transform-origin: center;
        transition: all .35s ease;
    }
    .category-float img {
        transition: transform .5s ease;
    }
    .category-float::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0);
        transition: .3s ease;
        pointer-events: none;
    }
    .category-float:hover {
        animation-play-state: paused;
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
    }
    .category-float:hover img {
        transform: scale(1.08);
    }
    .category-float:hover::after {
        background: rgba(0, 0, 0, 0.05);
    }

    @keyframes floatCard {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-6px); }
    }
</style>
@endpush

@section('content')

    {{-- ================= HERO CUPCAKE SIMPLE (MODEL BARU, SMOOTH) ================= --}}
    <section class="w-full overflow-visible relative">
        <div
            x-data="{
                active: 0,
                slides: [
                    {
                        image: '{{ asset("image/slicecake.jpg") }}',
                        title: 'Indulge in Every Sweet Creation.',
                        tagline: 'Kelezatan yang dibuat penuh cinta oleh baker lokal — siap memanjakan setiap momen spesialmu.'
                    },
                    {
                        image: '{{ asset("image/longcake.jpg") }}',
                        title: 'Delicate. Dreamy. Delightful.',
                        tagline: 'Kue lembut berlapis krim manis dan buah segar, dibuat khusus untuk momen yang pengin terasa lebih istimewa.'
                    }
                ],
                next() { this.active = (this.active + 1) % this.slides.length },
                prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length },
            }"
            x-init="setInterval(() => next(), 5000)"
            class="relative w-full"
        >

            {{-- ============== MOBILE HERO (≤ md) ============== --}}
            <div class="md:hidden hero-cupcake-bg hero-scallop-wrap">
                <div class="max-w-md mx-auto px-4 py-10 space-y-6">

                    <template x-for="(s, i) in slides" :key="'m-' + i">
                        <div x-show="active === i" x-transition.opacity.duration.400ms class="space-y-4">
                            {{-- FOTO --}}
                            <div class="flex justify-center">
                                <div class="hero-photo-scallop w-full shadow-xl">
                                    <img :src="s.image">
                                </div>
                            </div>

                            {{-- LOGO KHUSUS SLIDE 1 --}}
                            <template x-if="i === 0">
                                <div class="flex justify-center">
                                    <div
                                        class="rounded-3xl bg-white/70 p-3 shadow-lg backdrop-blur-md border border-white/60">
                                        <img src="{{ asset('image/logo_bcake.jpg') }}"
                                             class="w-16 rounded-xl object-contain">
                                    </div>
                                </div>
                            </template>

                            {{-- TEKS --}}
                            <div class="text-center space-y-3">
                                <div class="hero-text-panel">
                                    <h2 class="font-display text-3xl leading-tight hero-title" x-text="s.title"></h2>
                                    <p class="hero-tagline leading-relaxed" x-text="s.tagline"></p>
                                </div>

                                <div class="pt-2">
                                    <a href="{{ route('products.index') }}"
                                       class="inline-flex items-center justify-center px-7 py-3 rounded-full
                                              bg-bcake-cherry hover:bg-bcake-wine text-white font-medium
                                              shadow-md transition">
                                        Order Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- DOTS MOBILE --}}
                    <div class="flex justify-center gap-2 pt-2">
                        <template x-for="(s, i) in slides" :key="'mdot-' + i">
                            <button
                                @click="active = i"
                                class="h-2.5 w-2.5 rounded-full shadow-md transition"
                                :class="active === i ? 'bg-bcake-wine' : 'bg-white/70'">
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ============== DESKTOP HERO (≥ md) ============== --}}
            <div class="hidden md:block overflow-visible relative">
                {{-- BACKGROUND + SCALLOP --}}
                <div class="hero-cupcake-bg hero-scallop-wrap">
                    <div
                        class="relative max-w-6xl mx-auto px-6 md:px-12 py-16
                               min-h-[440px] lg:min-h-[500px]">

                        {{-- SLIDES LAYERED --}}
                        <template x-for="(s, i) in slides" :key="'d-' + i">
                            <div
                                class="absolute inset-0 grid grid-cols-2 items-center gap-10
                                       transition-opacity duration-700 ease-out"
                                :class="active === i
                                    ? 'opacity-100 z-20'
                                    : 'opacity-0 z-10 pointer-events-none'">

                                {{-- FOTO (kanan) --}}
                                <div class="order-1 md:order-2 flex justify-center items-center">
                                    <div class="hero-photo-scallop w-full max-w-xl h-[340px] lg:h-[380px] shadow-xl">
                                        <img :src="s.image">
                                    </div>
                                </div>

                                {{-- TEKS (kiri) --}}
                                <div class="order-2 md:order-1 text-left space-y-4">

                                    {{-- LOGO KHUSUS SLIDE 1 --}}
                                    <template x-if="i === 0">
                                        <div class="flex justify-start mb-3">
                                            <div
                                                class="rounded-3xl bg-white/70 p-3 shadow-lg backdrop-blur-md border border-white/60">
                                                <img src="{{ asset('image/logo_bcake.jpg') }}"
                                                     class="w-20 rounded-xl object-contain">
                                            </div>
                                        </div>
                                    </template>

                                    <div class="hero-text-panel">
                                        <h2 class="font-display text-4xl lg:text-5xl leading-tight hero-title"
                                            x-text="s.title">
                                        </h2>

                                        <p class="hero-tagline max-w-md leading-relaxed text-sm lg:text-base"
                                           x-text="s.tagline">
                                        </p>
                                    </div>

                                    <div class="pt-3">
                                        <a href="{{ route('products.index') }}"
                                           class="inline-flex items-center justify-center px-7 py-3 rounded-full
                                                  bg-bcake-cherry hover:bg-bcake-wine text-white font-medium
                                                  shadow-md transition">
                                            Order Now
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- PANAH KIRI (DESKTOP ONLY) --}}
                <button
                    @click="prev()"
                    class="hidden md:flex absolute left-[-70px] top-1/2 -translate-y-1/2 
                           h-12 w-12 rounded-full items-center justify-center
                           bg-[#890524] text-white shadow-2xl border-2 border-[#57091d]
                           hover:bg-[#57091d] hover:scale-[1.08] transition z-50">
                    ‹
                </button>

                {{-- PANAH KANAN (DESKTOP ONLY) --}}
                <button
                    @click="next()"
                    class="hidden md:flex absolute right-[-70px] top-1/2 -translate-y-1/2 
                           h-12 w-12 rounded-full items-center justify-center
                           bg-[#890524] text-white shadow-2xl border-2 border-[#57091d]
                           hover:bg-[#57091d] hover:scale-[1.08] transition z-50">
                    ›
                </button>

                {{-- DOTS DESKTOP --}}
                <div class="absolute bottom-7 left-1/2 -translate-x-1/2 flex gap-2 z-30">
                    <template x-for="(s, i) in slides" :key="'ddot-' + i">
                        <button
                            @click="active = i"
                            class="h-2.5 w-2.5 rounded-full shadow-md transition"
                            :class="active === i ? 'bg-bcake-wine' : 'bg-white/70'">
                        </button>
                    </template>
                </div>
            </div>

        </div>
    </section>

    {{-- ========= WHY + FEATURED GRID (KATEGORI FLOAT) ========= --}}
    <section class="py-10 md:py-14">
        <div class="max-w-[90rem] mx-auto px-4">

            {{-- ======================== ROW 1 ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

                {{-- LEFT CATEGORY --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show','custom-cake-modern') }}"
                       class="category-float block w-full">
                        <img src="{{ asset('image/cakemodern.jpg') }}"
                             class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Custom Cake & Modern Cake
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- CENTER CARD --}}
                <div class="md:col-span-6">
                    <div
                        class="card h-full flex flex-col items-center justify-center text-center
                               px-8 py-10 rounded-3xl bg-white/70 backdrop-blur-sm
                               shadow-[0_15px_35px_rgba(137,5,36,0.08)]
                               transition-all duration-300 hover:shadow-[0_25px_45px_rgba(137,5,36,0.12)]">
                        <p class="uppercase tracking-widest text-bcake-truffle/60 text-xs">
                            Since 2025
                        </p>
                        <h2 class="font-display text-3xl md:text-4xl mt-2">
                            Kenapa Harus B'cake?
                        </h2>
                        <p class="mt-3 text-bcake-truffle/80 max-w-xl leading-relaxed">
                            B'cake menghadirkan ruang istemewa bagi para pembuat kue untuk menampilkan
                            kreasi terbaik mereka. Kami menghubungkan para pembuat kue dengan pecinta kue
                            dalam satu tempat yang hangat, elegan, dan penuh cita rasa.
                        </p>
                        <a href="{{ route('products.index') }}"
                           class="btn btn-ghost mt-6 hover:scale-105 transition">
                            Lihat Menu Kami
                        </a>
                    </div>
                </div>

                {{-- RIGHT CATEGORY --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show','cupcake-brownies') }}"
                       class="category-float block w-full">
                        <img src="{{ asset('image/cupcake.jpg') }}"
                             class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Cupcake & Brownies
                            </h3>
                        </div>
                    </a>
                </div>

            </div>

            {{-- ======================== ROW 2 ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">

                {{-- PASTRY --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show','pastry-roti') }}"
                       class="category-float block w-full">
                        <img src="{{ asset('image/Pastry.jpg') }}"
                             class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Pastry & Roti
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- DESSERT BOX --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show','dessert-box') }}"
                       class="category-float block w-full">
                        <img src="{{ asset('image/dessertbox.jpg') }}"
                             class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Dessert Box
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- SNACK --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show','snack') }}"
                       class="category-float block w-full">
                        <img src="{{ asset('image/snack.jpg') }}"
                             class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Snack
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- RIGHT PROMO --}}
                <div class="md:col-span-3">
                    <div
                        class="card h-full p-6 flex flex-col justify-between rounded-3xl bg-white
                               shadow-[0_15px_35px_rgba(0,0,0,0.06)]
                               transition-all duration-300 hover:shadow-[0_25px_45px_rgba(0,0,0,0.1)]">
                        <div>
                            <p class="uppercase tracking-widest text-bcake-truffle/60 text-xs">
                                Daily Fresh
                            </p>
                            <h3 class="font-display text-2xl mt-1 leading-tight">
                                Explore. Taste. Celebrate.
                            </h3>
                            <p class="mt-3 text-bcake-truffle/80">
                                Temukan, pilih, dan pesan kue hingga nikmatin manisnya.
                                Semudah itu di B'cake 💗
                            </p>
                        </div>
                        <a href="{{ route('products.index') }}"
                           class="btn btn-primary mt-6 self-start hover:scale-105 transition">
                            Order Now
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ============ REKOMENDASI SPESIAL ============ --}}
    <section id="rekomendasi" class="max-w-7xl mx-auto px-6 py-14">
        <h2 class="font-display text-3xl text-center">Rekomendasi Spesial</h2>
        <p class="text-center text-gray-600 mt-2">
            Deretan pilihan kue terbaik yang direkomendasikan untuk kamu.
        </p>

        <div class="relative mt-8">

            {{-- Tombol kiri (dummy, belum ada JS slider) --}}
            <button
                class="hidden md:flex absolute -left-10 top-1/2 -translate-y-1/2 h-9 w-9
                       items-center justify-center rounded-full ring-1 ring-rose-200 
                       bg-white shadow hover:bg-rose-50">
                ‹
            </button>

            {{-- GRID PRODUK --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($bestSellers as $product)
                    <div class="category-card group rounded-2xl bg-white shadow transition overflow-hidden">
                        {{-- FOTO PRODUK --}}
                        <img src="{{ asset('image/dessertbox.jpg') }}"
                             class="w-full h-52 object-cover transition duration-300 group-hover:scale-[1.02]">

                        <div class="p-4 relative z-[1]">
                            <h3 class="font-semibold text-lg text-bcake-cocoa">
                                {{ $product->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Rekomendasi pilihan B’cake
                            </p>

                            {{-- HARGA --}}
                            @if (!is_null($product->price ?? null))
                                <p class="mt-2 text-base font-semibold text-rose-700">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-400 py-6">
                        Belum ada produk yang bisa ditampilkan saat ini.
                    </p>
                @endforelse
            </div>

            {{-- Tombol kanan (dummy) --}}
            <button
                class="hidden md:flex absolute -right-10 top-1/2 -translate-y-1/2 h-9 w-9
                       items-center justify-center rounded-full ring-1 ring-rose-200 
                       bg-white shadow hover:bg-rose-50">
                ›
            </button>
        </div>
    </section>

    {{-- ============ BANNER PROMO (HARI BESAR — SLIDER SMOOTH) ============ --}}
    <section class="max-w-6xl mx-auto px-6 pb-14" x-data="{
        active: 0,
        max: 3,
        touchStartX: 0,
        touchEndX: 0,
        next() { this.active = (this.active === this.max) ? 0 : this.active + 1 },
        prev() { this.active = (this.active === 0) ? this.max : this.active - 1 },
        onTouchStart(e) { this.touchStartX = e.touches[0].clientX },
        onTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].clientX;
            const diff = this.touchEndX - this.touchStartX;
            if (Math.abs(diff) > 50) diff < 0 ? this.next() : this.prev();
        }
    }">
        <div class="relative rounded-3xl overflow-hidden border border-rose-200 shadow-soft bg-white"
             @touchstart.passive="onTouchStart" @touchend.passive="onTouchEnd">

            @php
                $slides = [
                    [
                        'img' => 'Cake-Pink.jpg',
                        'title' => 'Valentine Collection',
                        'text' => 'Rayakan momen spesial dengan kue pastel romantis pilihan para seller terbaik.',
                        'badge_main' => 'Sweet Deals',
                        'badge_sub' => 'slot terbatas!',
                        'btn' => 'Pesan Sekarang',
                    ],
                    [
                        'img' => 'Cake-Pinky.jpg',
                        'title' => 'Holiday Collection',
                        'text' => 'Kue elegan untuk merayakan liburan akhir tahun bersama keluarga.',
                        'badge_main' => '20% OFF',
                        'badge_sub' => 'untuk pembelian paket',
                        'btn' => 'Order Today',
                    ],
                    [
                        'img' => 'Cake-Rainbow.jpg',
                        'title' => 'Birthday Collection',
                        'text' => 'Kue warna-warni meriah untuk rayakan ulang tahun dengan cara paling manis.',
                        'badge_main' => 'Best Seller',
                        'badge_sub' => 'disukai banyak pembeli',
                        'btn' => 'Lihat Kue Ulang Tahun',
                    ],
                    [
                        'img' => 'Cake-Softpink.jpg',
                        'title' => 'Mother’s Day',
                        'text' => 'Kue lembut pastel untuk hadiah manis penuh cinta buat ibu tersayang.',
                        'badge_main' => 'Special Gift',
                        'badge_sub' => 'siap kirim',
                        'btn' => 'Kirim ke Ibu',
                    ],
                ];
            @endphp

            {{-- CONTAINER SLIDE LAYERED --}}
            <div class="relative min-h-[260px] sm:min-h-[320px] md:min-h-[360px] lg:min-h-[400px]">
                @foreach ($slides as $i => $slide)
                    <div
                        class="absolute inset-0 transition-opacity duration-600 ease-out"
                        :class="active === {{ $i }}
                            ? 'opacity-100 z-20'
                            : 'opacity-0 z-10 pointer-events-none'">
                        <div class="grid md:grid-cols-2 h-full">

                            {{-- GAMBAR --}}
                            <img src="{{ asset('image/' . $slide['img']) }}"
                                 class="w-full h-[240px] sm:h-[300px] md:h-[350px] lg:h-[380px] object-cover">

                            {{-- TEKS --}}
                            <div class="p-8 md:p-10 lg:p-12 bg-rose-50/80 backdrop-blur flex flex-col justify-center">
                                <h3 class="font-display text-3xl md:text-4xl text-bcake-cocoa">
                                    {{ $slide['title'] }}
                                </h3>

                                <p class="text-gray-700 mt-3 text-base max-w-md leading-relaxed">
                                    {{ $slide['text'] }}
                                </p>

                                {{-- BADGE --}}
                                <div
                                    class="mt-5 inline-flex items-center gap-3 rounded-2xl border border-rose-200 bg-white px-5 py-2.5 shadow-sm">
                                    <span class="text-rose-900 font-semibold text-base md:text-lg">
                                        {{ $slide['badge_main'] }}
                                    </span>
                                    <span class="text-gray-600 text-xs md:text-sm">
                                        {{ $slide['badge_sub'] }}
                                    </span>
                                </div>

                                {{-- BUTTON --}}
                                <div class="mt-5">
                                    <a href="{{ route('products.index') }}"
                                       class="inline-flex items-center justify-center rounded-full
                                              bg-bcake-cherry hover:bg-bcake-wine
                                              text-white px-7 py-3 text-sm md:text-base font-medium
                                              shadow-soft transition">
                                        {{ $slide['btn'] }}
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PANAH KIRI --}}
            <button type="button"
                class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2
                       h-9 w-9 rounded-full bg-white/95 border border-rose-200 shadow-sm
                       items-center justify-center text-[#890524]
                       hover:bg-rose-50 hover:scale-[1.04] transition z-20"
                @click="prev()">
                ‹
            </button>

            {{-- PANAH KANAN --}}
            <button type="button"
                class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2
                       h-9 w-9 rounded-full bg-white/95 border border-rose-200 shadow-sm
                       items-center justify-center text-[#890524]
                       hover:bg-rose-50 hover:scale-[1.04] transition z-20"
                @click="next()">
                ›
            </button>

            {{-- DOTS --}}
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                <template x-for="i in 4">
                    <button
                        class="h-2.5 w-2.5 rounded-full border border-rose-300 transition-all"
                        :class="active === (i - 1)
                            ? 'bg-[#890524] border-[#890524] scale-110'
                            : 'bg-rose-100 hover:bg-rose-200'"
                        @click="active = i - 1">
                    </button>
                </template>
            </div>

        </div>
    </section>

    <footer class="relative mt-16 w-full bg-[#f7e3e7] text-bcake-truffle pt-10 pb-6 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-6 bg-repeat-x"
             style="background-image: url('{{ asset('image/lace-border.png') }}'); background-size: auto 100%;">
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6 md:gap-12">
                <div class="text-center md:text-left">
                    <h2 class="font-display text-3xl text-bcake-wine">B’cake</h2>
                    <p class="mt-2 italic text-bcake-truffle/80">“Because elegance can be sweet.”</p>
                </div>

                <div class="text-center">
                    <h3 class="font-medium uppercase tracking-widest text-sm text-bcake-truffle/70 mb-2">
                        Contact &amp; Socials
                    </h3>
                    <div class="flex justify-center md:justify-start gap-4 mt-3">
                        <a href="#"
                           class="w-10 h-10 rounded-full flex items-center justify-center bg-white hover:bg-bcake-wine hover:text-white transition">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        <a href="#"
                           class="w-10 h-10 rounded-full flex items-center justify-center bg-white hover:bg-bcake-wine hover:text-white transition">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                        <a href="#"
                           class="w-10 h-10 rounded-full flex items-center justify-center bg-white hover:bg-bcake-wine hover:text-white transition">
                            <i class="fa-brands fa-tiktok text-lg"></i>
                        </a>
                        <a href="mailto:hello@bcake.local"
                           class="w-10 h-10 rounded-full flex items-center justify-center bg-white hover:bg-bcake-wine hover:text-white transition">
                            <i class="fa-solid fa-envelope text-lg"></i>
                        </a>
                    </div>
                </div>

                <div class="text-center md:text-right">
                    <p class="text-sm text-bcake-truffle/70">© {{ date('Y') }} B’cake Bakery. All rights reserved.</p>
                    <p class="text-xs text-bcake-truffle/60">Designed with 🍒 by Team B’cake</p>
                </div>
            </div>
        </div>
    </footer>

@endsection
