@extends('layouts.app')

@section('title', 'B’cake — Elegant Bakery')

@push('head')
    <style>
        /* 🎀 Background stripes pakai warna palette kamu */
        .hero-cupcake-bg {
            background:
                repeating-linear-gradient(to bottom,
                    #f6c2d0 0px,
                    /* soft pink muda */
                    #f6c2d0 14px,
                    #f3a9c0 14px,
                    /* soft pink dalam */
                    #f3a9c0 28px);
        }

        /* 🎀 Scallop lace bawah */
        .hero-scallop {
            position: relative;
            overflow: hidden;
        }

        .hero-scallop::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -18px;
            height: 36px;
            background:
                radial-gradient(circle at 18px -6px, #ffffff 18px, transparent 19px) repeat-x;
            background-size: 36px 36px;
        }
    </style>
@endpush

@section('content')

    {{-- ================= HERO CUPCAKE SIMPLE (MODEL BARU) ================= --}}
    <section class="w-full overflow-hidden">

        <div x-data="{
            active: 0,
            slides: [
                { image: '{{ asset('image/slicecake.jpg') }}', title: 'Sweet. Stunning. So You.' },
                { image: '{{ asset('image/longcake.jpg') }}', title: 'Cantik di mata, manis di rasa.' },
            ],
            next() { this.active = (this.active + 1) % this.slides.length },
            prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length },
        }" x-init="setInterval(() => next(), 5000)" class="relative w-full">

            <template x-for="(s, i) in slides" :key="i">
                <div x-show="active === i" class="relative w-full hero-cupcake-bg">

                    <!-- GRID -->
                    <div class="grid grid-cols-1 md:grid-cols-2 md:items-center px-6 py-12 md:py-20 gap-6">

                        <!-- FOTO – mobile di atas -->
                        <div class="order-1 md:order-2 flex justify-center">
                            <img :src="s.image"
                                class="w-full max-w-md md:max-w-xl rounded-3xl shadow-lg object-cover">
                        </div>

                        <!-- TEKS – mobile di bawah -->
                        <div class="order-2 md:order-1 text-center md:text-left space-y-4">

                            <!-- LOGO slide 1 -->
                            <template x-if="i === 0">
                                <div class="flex justify-center md:justify-start">
                                    <div
                                        class="rounded-3xl bg-white/70 p-3 shadow-lg backdrop-blur-md border border-white/60">
                                        <img src="{{ asset('image/logo_bcake.jpg') }}"
                                            class="w-16 md:w-20 rounded-xl object-contain">
                                    </div>
                                </div>
                            </template>

                            <!-- JUDUL -->
                            <h2
                                class="font-display text-3xl sm:text-4xl md:text-5xl leading-tight
                                   text-white drop-shadow-md">
                                <span x-text="s.title"></span>
                            </h2>

                            <!-- SUBTEKS -->
                            <p class="text-white/90 max-w-md mx-auto md:mx-0">
                                Pilihan kue cantik dari baker lokal, siap manisin harimu.
                            </p>

                            <!-- BUTTON -->
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

                    <!-- SCALLOP -->
                    <div class="hero-scallop h-10 bg-[#f3a9c0]"></div>

                </div>
            </template>

            <!-- LEFT BUTTON -->
            <button @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 h-9 w-9 rounded-full
                   bg-white/85 hover:bg-white shadow-md z-30">
                ‹
            </button>

            <!-- RIGHT BUTTON -->
            <button @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 h-9 w-9 rounded-full
                   bg-white/85 hover:bg-white shadow-md z-30">
                ›
            </button>

            <!-- DOTS -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-30">
                <template x-for="(s, i) in slides" :key="i">
                    <button @click="active = i" class="h-2.5 w-2.5 rounded-full shadow-md transition"
                        :class="active === i ? 'bg-bcake-wine' : 'bg-white/70'"></button>
                </template>
            </div>

        </div>
    </section>

    {{-- ========= WHY + FEATURED GRID (pakai cake.jpg sementara) ========= --}}
    <section class="py-10 md:py-14">
        <div class="max-w-[90rem] mx-auto px-4">

            {{-- ROW 1 --}}
            <div class="grid md:grid-cols-12 gap-6 items-stretch">

                {{-- Left category: Custom Cake & Modern Cake --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'custom-cake-modern') }}"
                        class="category-card block rounded-3xl shadow-sm group" style="background-color:#6a4e4a4d;">
                        <img src="{{ asset('image/cakemodern.jpg') }}" alt="Modern & Custom Cake"
                            class="w-full aspect-[4/3] object-cover group-hover:scale-[1.02]">
                        <div class="py-4 text-center relative z-[1]">
                            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
                                Custom Cake & Modern Cake
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- Center content --}}
                <div class="md:col-span-6">
                    <div class="card h-full flex flex-col items-center justify-center text-center p-8">
                        <p class="uppercase tracking-widest text-bcake-truffle/60 text-xs">
                            Since 2025
                        </p>
                        <h2 class="font-display text-3xl md:text-4xl mt-2">
                            Kenapa Harus B'cake?
                        </h2>
                        <p class="mt-3 text-bcake-truffle/80 max-w-xl">
                            B'cake menghadirkan ruang istemewa bagi para pembuat kue untuk menampilkan
                            kreasi terbaik mereka. Kami menghubungkan para pembuat kue dengan menampilkan
                            kreasi terbaik mereka dan pecinta kue dalam satu tempat yang hangat, dan penuh
                            cita rasa.
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-ghost mt-6">
                            Lihat Menu Kami
                        </a>
                    </div>
                </div>

                {{-- Right category: Cupcake & Brownies --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'cupcake-brownies') }}"
                        class="category-card block rounded-3xl shadow-sm group" style="background-color:#6a4e4a4d;">
                        <img src="{{ asset('image/cupcake.jpg') }}" alt="Cupcake & Brownies"
                            class="w-full aspect-[4/3] object-cover group-hover:scale-[1.02]">
                        <div class="py-4 text-center relative z-[1]">
                            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
                                Cupcake & Brownies
                            </h3>
                        </div>
                    </a>
                </div>

            </div>

            {{-- ROW 2 --}}
            <div class="grid md:grid-cols-12 gap-6 mt-6">

                {{-- Pastry & Roti --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'pastry-roti') }}"
                        class="category-card block rounded-3xl shadow-sm group" style="background-color:#6a4e4a4d;">
                        <img src="{{ asset('image/Pastry.jpg') }}" alt="Pastry & Roti"
                            class="w-full aspect-[4/3] object-cover group-hover:scale-[1.02]">
                        <div class="py-4 text-center relative z-[1]">
                            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
                                Pastry & Roti
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- Dessert Box --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'dessert-box') }}"
                        class="category-card block rounded-3xl shadow-sm group" style="background-color:#6a4e4a4d;">
                        <img src="{{ asset('image/dessertbox.jpg') }}" alt="Dessertbox"
                            class="w-full aspect-[4/3] object-cover group-hover:scale-[1.02]">
                        <div class="py-4 text-center relative z-[1]">
                            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
                                Dessert Box
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- Snack --}}
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'snack') }}"
                        class="category-card block rounded-3xl shadow-sm group" style="background-color:#6a4e4a4d;">
                        <img src="{{ asset('image/snack.jpg') }}" alt="Snack"
                            class="w-full aspect-[4/3] object-cover group-hover:scale-[1.02]">
                        <div class="py-4 text-center relative z-[1]">
                            <h3 class="text-sm font-medium tracking-wide text-[#362320]">
                                Snack
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- Right promo --}}
                <div class="md:col-span-3">
                    <div class="card h-full p-6 flex flex-col justify-between">
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
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-6 self-start">
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

            {{-- Tombol kiri --}}
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

            {{-- Tombol kanan --}}
            <button
                class="hidden md:flex absolute -right-10 top-1/2 -translate-y-1/2 h-9 w-9
                   items-center justify-center rounded-full ring-1 ring-rose-200 
                   bg-white shadow hover:bg-rose-50">
                ›
            </button>
        </div>
    </section>

    {{-- ============ BANNER PROMO (HARI BESAR — SLIDER) ============ --}}
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

            @foreach ($slides as $i => $slide)
                <div x-show="active === {{ $i }}" x-transition>
                    <div class="grid md:grid-cols-2">

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

            {{-- PANAH KIRI --}}
            <button type="button"
                class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2
                   h-9 w-9 rounded-full bg-white/95 border border-rose-200 shadow-sm
                   flex items-center justify-center text-[#890524]
                   hover:bg-rose-50 hover:scale-[1.04] transition z-20"
                @click="prev()">
                ‹
            </button>

            {{-- PANAH KANAN --}}
            <button type="button"
                class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2
                   h-9 w-9 rounded-full bg-white/95 border border-rose-200 shadow-sm
                   flex items-center justify-center text-[#890524]
                   hover:bg-rose-50 hover:scale-[1.04] transition z-20"
                @click="next()">
                ›
            </button>

            {{-- DOTS --}}
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                <template x-for="i in 4">
                    <button class="h-2.5 w-2.5 rounded-full border border-rose-300 transition-all"
                        :class="active === (i - 1) ?
                            'bg-[#890524] border-[#890524] scale-110' :
                            'bg-rose-100 hover:bg-rose-200'"
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
