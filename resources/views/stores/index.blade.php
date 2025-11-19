@extends('layouts.app')

@section('title', 'Daftar Toko — B’cake')

@section('content')
<section class="bg-rose-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- HEADER --}}
        <div class="text-center mb-4">
            <h1 class="text-2xl md:text-3xl font-semibold text-rose-900">
                Jelajahi Toko Favorit di B’cake
            </h1>
            <p class="text-sm text-rose-500 mt-1">
                Pilih toko untuk melihat katalog kue, custom cake, dan dessert mereka.
            </p>
        </div>

        {{-- GRID TOKO --}}
        @if ($stores->isEmpty())
            <div class="bg-white rounded-3xl shadow-sm px-6 py-10 text-center">
                <p class="text-rose-700 font-medium mb-1">Belum ada toko yang terdaftar.</p>
                <p class="text-sm text-rose-500">
                    Toko-toko B’cake akan muncul di sini setelah penjual mendaftarkan tokonya.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($stores as $store)
                    <div class="bg-white rounded-2xl shadow-sm border border-rose-100/70 overflow-hidden flex flex-col">
                        {{-- Banner sederhana --}}
                        <div class="h-20 bg-gradient-to-r from-rose-100 via-rose-50 to-amber-50"></div>

                        <div class="px-5 pb-4 pt-3 flex-1 flex flex-col">
                            <h2 class="text-base font-semibold text-rose-900">
                                {{ $store->name }}
                            </h2>

                            @if($store->tagline)
                                <p class="text-xs text-rose-400 mt-1">
                                    {{ $store->tagline }}
                                </p>
                            @endif

                            @if($store->description)
                                <p class="text-xs text-rose-500 mt-2 line-clamp-3">
                                    {{ $store->description }}
                                </p>
                            @endif

                            <div class="mt-4 flex items-center justify-between">
                                @if($store->whatsapp)
                                    <span class="text-[11px] text-rose-400">
                                        WA: {{ $store->whatsapp }}
                                    </span>
                                @else
                                    <span class="text-[11px] text-rose-300">
                                        WhatsApp belum diatur
                                    </span>
                                @endif

                                <a href="{{ route('stores.show', $store->slug) }}"
                                   class="inline-flex items-center px-3 py-1 rounded-full
                                          bg-rose-500 text-white text-xs font-semibold
                                          hover:bg-rose-600">
                                    Lihat Toko →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $stores->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
