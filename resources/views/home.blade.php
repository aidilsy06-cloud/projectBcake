@extends('layouts.app')

@section('title', 'B’cake — Elegant Bakery')

@push('head')
    <style>
        /* 🎀 Background stripes horizontal (garis ke samping) */
        .hero-cupcake-bg {
            background:
                repeating-linear-gradient(to bottom,
                    #f7d2da 0px,
                    /* pink muda */
                    #f7d2da 22px,
                    /* tebal warna 1 */
                    #b55c69 22px,
                    /* wine/truffle */
                    #b55c69 44px
                    /* total 44px per pola */
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

        /* 🌸 PANEL TEKS HERO – clean & premium */
        .hero-text-panel {
            position: relative;
            display: inline-block;
            padding: 1.6rem 2.4rem;
            border-radius: 2rem;
            background: rgba(255, 248, 250, 0.92);
            /* krem soft */
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

        /* ✨ ANIMASI FLOAT SLOW-MOTION */
        @keyframes floatY {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }
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

        /* 🎂 FRAME FOTO TANPA GERIGI (FOTO HERO) */
        .hero-photo-scallop {
            border-radius: 1.45rem;
            overflow: hidden;
            background-color: #f7d2da;
            /* pink muda, nyatu sama background */
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

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        /* 🧁 Scrollbar horizontal hilang untuk slider */
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        /* 🍓 Animasi muncul untuk kartu rekomendasi */
        .rec-card {
            opacity: 0;
            transform: translateY(26px);
            transition:
                opacity .65s ease-out,
                transform .65s ease-out;
            will-change: opacity, transform;
        }

        .rec-card.rec-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* 🍰 BADGE SLICE CAKE DI ATAS REKOMENDASI */
        .bcake-reco-shell {
            position: relative;
            margin-top: 1rem;
        }

        .bcake-reco-cake-badge {
            position: absolute;
            top: -44px;
            left: 50%;
            transform: translateX(-50%);
            width: 88px;
            height: 88px;
            border-radius: 999px;
            background: radial-gradient(circle at 30% 20%, #ffeef7, #ffb9cf 60%, #f06b88);
            box-shadow: 0 14px 30px rgba(176, 13, 58, .28);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            z-index: 5;
        }

        .bcake-reco-cake-inner {
            width: 100%;
            height: 100%;
            border-radius: 999px;
            background: #fff7fb;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            animation: bcake-reco-float 2.3s ease-in-out infinite;
        }

        .bcake-reco-cake-inner img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        @keyframes bcake-reco-float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .bcake-reco-title {
            margin-top: 2.2rem;
        }
    </style>
@endpush

@section('content')

    {{-- ================= HERO CUPCAKE SIMPLE (RAPI & SEIMBANG) ================= --}}
    <section class="w-full overflow-visible relative">
        <div x-data="{
            active: 0,
            slides: [
                {
                    image: '{{ asset('image/slicecake.jpg') }}',
                    title: 'Welcome to a world of sweetness.',
                    tagline: 'Dunia manis yang hangat untuk menyenangkan hati.'
                },
                {
                    image: '{{ asset('image/longcake.jpg') }}',
                    title: 'Cute treats, happy hearts.',
                    tagline: 'Cemilan imut, memberi kebahagiaan dan hari yang manis.'
                }
            ],
            next() { this.active = (this.active + 1) % this.slides.length },
            prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length },
        }" x-init="setInterval(() => next(), 5000)" class="relative w-full">

            {{-- ============== MOBILE HERO (≤ md) ============== --}}
            <div class="md:hidden hero-cupcake-bg hero-scallop-wrap">
                <div class="max-w-md mx-auto px-4 py-10 space-y-6">
                    <template x-for="(s, i) in slides" :key="'m-' + i">
                        <div x-show="active === i" x-transition.opacity.duration.400ms class="space-y-4">
                            {{-- FOTO --}}
                            <div class="flex justify-center">
                                <div class="hero-photo-scallop w-full shadow-xl rounded-3xl overflow-hidden">
                                    <img :src="s.image" class="w-full h-full object-cover">
                                </div>
                            </div>

                            {{-- TEKS + BUTTON --}}
                            <div class="text-center space-y-3">
                                <div class="hero-text-panel">
                                    <h2 class="font-display text-2xl leading-tight hero-title" x-text="s.title"></h2>
                                    <p class="hero-tagline leading-relaxed text-sm" x-text="s.tagline"></p>
                                </div>

                                <div class="pt-2">
                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center justify-center px-6 py-2.5 rounded-full
                                          bg-bcake-cherry hover:bg-bcake-wine text-white font-medium text-sm
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
                            <button @click="active = i" class="h-2.5 w-2.5 rounded-full shadow-md transition"
                                :class="active === i ? 'bg-bcake-wine' : 'bg-white/70'">
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ============== DESKTOP HERO (≥ md) ============== --}}
            <div class="hidden md:block overflow-visible relative">
                {{-- STRIPES: lebih pendek kanan kiri, lebih tinggi atas–bawah --}}
                <div class="relative hero-cupcake-bg hero-scallop-wrap max-w-5xl mx-auto rounded-[2.3rem]">
                    <div
                        class="relative 
                            px-8 lg:px-12
                            py-16 lg:py-20
                            min-h-[460px] lg:min-h-[520px]">

                        <template x-for="(s, i) in slides" :key="'d-' + i">
                            <div class="absolute inset-0 grid grid-cols-2 items-center gap-10
                                   transition-opacity duration-700 ease-out"
                                :class="active === i ? 'opacity-100 z-20' :
                                    'opacity-0 z-10 pointer-events-none'">

                                {{-- FOTO (ada space dari pinggir kanan) --}}
                                <div class="order-1 md:order-2 flex justify-center items-center ml-4 lg:ml-6">
                                    <div
                                        class="hero-photo-scallop w-full max-w-[27rem]
                                            h-[240px] lg:h-[290px] shadow-xl rounded-2xl overflow-hidden bg-[#f7d2da]">
                                        <img :src="s.image" class="w-full h-full object-cover">
                                    </div>
                                </div>

                                {{-- TEKS (nggak terlalu mepet kiri) --}}
                                <div class="order-2 md:order-1 text-left space-y-5 pl-8 lg:pl-10 pr-4">
                                    <div class="hero-text-panel">
                                        <h2 class="font-display text-[1.9rem] lg:text-[2.2rem] leading-tight hero-title"
                                            x-text="s.title"></h2>

                                        <p class="hero-tagline max-w-md leading-relaxed text-sm lg:text-base"
                                            x-text="s.tagline"></p>
                                    </div>

                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center justify-center px-7 py-3 rounded-full
                                          bg-bcake-cherry hover:bg-bcake-wine text-white font-medium
                                          shadow-md transition text-sm lg:text-base w-fit">
                                        Order Now
                                    </a>
                                </div>

                            </div>
                        </template>
                    </div>

                    {{-- DOTS DESKTOP (di dalam stripes) --}}
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-30">
                        <template x-for="(s, i) in slides" :key="'ddot-' + i">
                            <button @click="active = i" class="h-2.5 w-2.5 rounded-full shadow-md transition"
                                :class="active === i ? 'bg-bcake-wine' : 'bg-white/70'">
                            </button>
                        </template>
                    </div>
                </div>

                {{-- PANAH DI LUAR STRIPES --}}
                <button @click="prev()"
                    class="hidden md:flex absolute left-6 lg:left-10 top-1/2 -translate-y-1/2 
                       h-8 w-8 rounded-full items-center justify-center text-sm
                       bg-[#890524] text-white shadow-2xl border border-[#57091d]
                       hover:bg-[#57091d] hover:scale-[1.10] transition z-50">
                    ‹
                </button>

                <button @click="next()"
                    class="hidden md:flex absolute right-6 lg:right-10 top-1/2 -translate-y-1/2 
                       h-8 w-8 rounded-full items-center justify-center text-sm
                       bg-[#890524] text-white shadow-2xl border border-[#57091d]
                       hover:bg-[#57091d] hover:scale-[1.10] transition z-50">
                    ›
                </button>
            </div>

        </div>
    </section>

    {{-- 🍒 Heart Cherry B'cake --}}
    <div class="bcake-heart-cherry-wrap">
        <svg viewBox="0 0 140 120" xmlns="http://www.w3.org/2000/svg" class="bcake-heart-cherry-svg w-[110px] h-[90px]"
            aria-hidden="true">
            <defs>
                <radialGradient id="hc-cherry" cx="30%" cy="20%" r="80%">
                    <stop offset="0%" stop-color="#ffd7e6" />
                    <stop offset="45%" stop-color="#e85b88" />
                    <stop offset="100%" stop-color="#890524" />
                </radialGradient>
                <linearGradient id="hc-stem" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#6a4e4a" />
                    <stop offset="100%" stop-color="#362320" />
                </linearGradient>
            </defs>

            <ellipse cx="70" cy="96" rx="32" ry="10" fill="#d0d1c9" opacity="0.35" />
            <path d="M45,36
                                                             C40,26 42,16 50,12
                                                             C58,8 66,12 70,18
                                                             C74,12 82,8 90,12
                                                             C98,16 100,26 95,36
                                                             C90,46 80,54 70,62
                                                             C60,54 50,46 45,36Z" fill="none" stroke="url(#hc-stem)"
                stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M62,60 C56,70 54,78 53,86" fill="none" stroke="url(#hc-stem)" stroke-width="3"
                stroke-linecap="round" />
            <path d="M78,60 C84,70 86,78 87,86" fill="none" stroke="url(#hc-stem)" stroke-width="3"
                stroke-linecap="round" />
            <circle cx="52" cy="88" r="18" fill="url(#hc-cherry)" />
            <circle cx="88" cy="88" r="18" fill="url(#hc-cherry)" />
            <ellipse cx="46" cy="80" rx="6" ry="4" fill="#ffeef7" opacity="0.9" />
            <ellipse cx="57" cy="93" rx="4" ry="2.6" fill="#ffeef7" opacity="0.65" />
            <ellipse cx="82" cy="80" rx="6" ry="4" fill="#ffeef7" opacity="0.9" />
            <ellipse cx="93" cy="93" rx="4" ry="2.6" fill="#ffeef7" opacity="0.65" />
        </svg>
    </div>

    {{-- ========= WHY + FEATURED GRID (KATEGORI FLOAT) ========= --}}
    <section class="py-10 md:py-14">
        <div class="max-w-[90rem] mx-auto px-4">
            {{-- ROW 1 --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'custom-cake-modern') }}" class="category-float block w-full">
                        <img src="{{ asset('image/cakemodern.jpg') }}"
                            class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Custom Cake &amp; Modern Cake
                            </h3>
                        </div>
                    </a>
                </div>

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
                        <a href="{{ route('products.index') }}" class="btn btn-ghost mt-6 hover:scale-105 transition">
                            Lihat Menu Kami
                        </a>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'cupcake-brownies') }}" class="category-float block w-full">
                        <img src="{{ asset('image/cupcake.jpg') }}"
                            class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Cupcake &amp; Brownies
                            </h3>
                        </div>
                    </a>
                </div>
            </div>

            {{-- ROW 2 --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">
                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'pastry-roti') }}" class="category-float block w-full">
                        <img src="{{ asset('image/Pastry.jpg') }}"
                            class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Pastry &amp; Roti
                            </h3>
                        </div>
                    </a>
                </div>

                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'dessert-box') }}" class="category-float block w-full">
                        <img src="{{ asset('image/dessertbox.jpg') }}"
                            class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Dessert Box
                            </h3>
                        </div>
                    </a>
                </div>

                <div class="md:col-span-3">
                    <a href="{{ route('categories.show', 'snack') }}" class="category-float block w-full">
                        <img src="{{ asset('image/snack.jpg') }}"
                            class="w-full aspect-[4/3] object-cover rounded-t-3xl">
                        <div class="py-3 text-center">
                            <h3 class="text-sm md:text-base font-medium text-[#362320]">
                                Snack
                            </h3>
                        </div>
                    </a>
                </div>

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

    {{-- 🍰 Cake Icon Divider B'cake --}}
    <div class="bcake-ribbon-wrap">
        <svg viewBox="0 0 160 120" xmlns="http://www.w3.org/2000/svg" class="bcake-cake-svg w-[150px] h-[110px]"
            aria-hidden="true">
            <defs>
                <!-- garis lembut pakai icing mist -->
                <linearGradient id="bc-line" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#d0d1c9" />
                    <stop offset="50%" stop-color="#d0d1c9" />
                    <stop offset="100%" stop-color="#d0d1c9" />
                </linearGradient>

                <!-- atas kue: coklat tapi glossy -->
                <radialGradient id="bc-top" cx="30%" cy="20%" r="80%">
                    <stop offset="0%" stop-color="#6a4e4a" />
                    <stop offset="40%" stop-color="#362320" />
                    <stop offset="100%" stop-color="#57091d" />
                </radialGradient>

                <!-- sisi kue: sedikit lebih terang -->
                <linearGradient id="bc-side" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#890524" />
                    <stop offset="100%" stop-color="#6a4e4a" />
                </linearGradient>

                <!-- filling di dalam slice -->
                <linearGradient id="bc-filling" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#ffe6c4" />
                    <stop offset="100%" stop-color="#f2c07a" />
                </linearGradient>

                <!-- cherry -->
                <linearGradient id="bc-cherry" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#ffd7e6" />
                    <stop offset="100%" stop-color="#890524" />
                </linearGradient>

                <!-- batang cherry -->
                <linearGradient id="bc-stem" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#6a4e4a" />
                    <stop offset="100%" stop-color="#362320" />
                </linearGradient>
            </defs>

            <!-- garis divider lembut -->
            <path d="M0,90 C40,82 80,86 120,84 C140,83 150,82 160,80" fill="none" stroke="url(#bc-line)"
                stroke-width="6" stroke-linecap="round" opacity="0.35" />

            <!-- bayangan lembut di bawah kue -->
            <ellipse cx="80" cy="88" rx="42" ry="10" fill="#d0d1c9" opacity="0.25" />

            <!-- ===== KUE UTAMA (tanpa slice) ===== -->
            <!-- sisi -->
            <path d="M38,52
                   C38,64 38,74 38,80
                   C38,88 122,88 122,80
                   C122,74 122,64 122,52
                   Z" fill="url(#bc-side)" />
            <!-- atas -->
            <ellipse cx="80" cy="52" rx="42" ry="14" fill="url(#bc-top)" />

            <!-- beberapa garis potongan tipis di atas kue -->
            <path d="M80,38 L80,66" stroke="#362320" stroke-width="1.3" opacity="0.55" />
            <path d="M58,40 L66,64" stroke="#362320" stroke-width="1.1" opacity="0.45" />
            <path d="M102,40 L94,64" stroke="#362320" stroke-width="1.1" opacity="0.45" />

            <!-- beberapa cherry kecil di atas -->
            <g opacity="0.95">
                <g>
                    <path d="M52,30 C52,24 50,20 48,17" fill="none" stroke="url(#bc-stem)" stroke-width="1.4" />
                    <circle cx="52" cy="32" r="4.2" fill="url(#bc-cherry)" />
                    <circle cx="50.5" cy="30.5" r="1.5" fill="#ffeef7" opacity="0.9" />
                </g>
                <g>
                    <path d="M80,26 C80,20 79,16 77,13" fill="none" stroke="url(#bc-stem)" stroke-width="1.4" />
                    <circle cx="80" cy="28" r="4.2" fill="url(#bc-cherry)" />
                    <circle cx="78.5" cy="26.5" r="1.5" fill="#ffeef7" opacity="0.9" />
                </g>
                <g>
                    <path d="M108,30 C108,24 110,20 112,17" fill="none" stroke="url(#bc-stem)" stroke-width="1.4" />
                    <circle cx="108" cy="32" r="4.2" fill="url(#bc-cherry)" />
                    <circle cx="106.5" cy="30.5" r="1.5" fill="#ffeef7" opacity="0.9" />
                </g>
            </g>

            <!-- ===== SLICE YANG BERGERAK KELUAR-MASUK ===== -->
            <g class="bcake-cake-slice">
                <!-- sisi slice -->
                <path d="M80,52
                       L120,44
                       C124,45 128,49 127,54
                       L123,80
                       C122,84 118,86 114,86
                       L80,82 Z" fill="url(#bc-side)" />

                <!-- filling di dalam slice -->
                <path d="M82,54
                       L118,47
                       C121,48 123,51 122,54
                       L119,78
                       C118,80 116,82 113,82
                       L82,79 Z" fill="url(#bc-filling)" opacity="0.95" />

                <!-- garis layer dalam slice -->
                <path d="M83,60 L119,53" stroke="#d8a869" stroke-width="1.3" opacity="0.9" />
                <path d="M83,66 L118,60" stroke="#d8a869" stroke-width="1.3" opacity="0.9" />
                <path d="M84,72 L117,67" stroke="#d8a869" stroke-width="1.3" opacity="0.9" />

                <!-- cherry di atas slice -->
                <g transform="translate(118,40)">
                    <path d="M0,-6 C-1,-10 -2,-14 -3,-17" fill="none" stroke="url(#bc-stem)" stroke-width="1.3" />
                    <circle cx="0" cy="-3" r="4" fill="url(#bc-cherry)" />
                    <circle cx="-1" cy="-4.5" r="1.4" fill="#ffeef7" opacity="0.9" />
                </g>
            </g>
        </svg>
    </div>

    {{-- ============ REKOMENDASI SPESIAL (PAKE image_url) ============ --}}
    <section id="rekomendasi" class="py-14">
        <div class="bcake-reco-shell max-w-7xl mx-auto px-6 text-center">
            <h2 class="font-display text-3xl bcake-reco-title">Rekomendasi Spesial</h2>
            <p class="text-center text-gray-600 mt-2">
                Deretan pilihan kue terbaik yang direkomendasikan untuk kamu.
            </p>

            <div class="mt-8">
                <div class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-3 scrollbar-none"
                    style="-ms-overflow-style: none; scrollbar-width: none;">

                    @forelse ($bestSellers as $product)
                        @php
                            // fallback kalau belum ada foto
                            $img = asset('image/dessertbox.jpg');
                            // ideal: image_url = "products/nama-file.jpg"
                            $raw = trim($product->image_url ?? '');

                            if ($raw !== '') {
                                $raw = ltrim($raw, '/');

                                if (\Illuminate\Support\Str::startsWith($raw, ['http://', 'https://'])) {
                                    // URL penuh
                                    $img = $raw;
                                } else {
                                    // path relatif dari storage/
                                    $img = asset('storage/' . $raw);
                                }
                            }
                        @endphp

                        <div class="rec-card snap-start bg-white rounded-2xl shadow group overflow-hidden shrink-0 
                            border border-pink-100 min-w-[300px] w-[300px]"
                            style="transition-delay: {{ $loop->index * 90 }}ms">

                            <img src="{{ $img }}" alt="{{ $product->name }}"
                                class="w-full h-52 object-cover transition duration-300 group-hover:scale-[1.02]">

                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-bcake-cocoa">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Rekomendasi pilihan B’cake
                                </p>

                                @if (!is_null($product->price ?? null))
                                    <p class="mt-2 text-base font-semibold text-rose-700">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-6">
                            Belum ada produk yang bisa ditampilkan saat ini.
                        </p>
                    @endforelse

                </div>
            </div>
        </div>
    </section>

    {{-- ============ (di bawah sini kalau kamu punya banner promo / section lain, lanjutkan seperti biasa) ============ --}}

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.rec-card');

            if (!('IntersectionObserver' in window)) {
                cards.forEach(c => c.classList.add('rec-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('rec-visible');
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });

            cards.forEach(card => observer.observe(card));
        });
    </script>
@endpush
