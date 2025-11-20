@extends('layouts.app')

@section('title', 'Keranjang — B’cake')

@section('content')
<section class="bg-rose-50/60 min-h-[60vh]">
    <div class="max-w-6xl mx-auto px-4 py-10">

        <h1 class="text-2xl md:text-3xl font-display text-bcake-bitter mb-2">
            Keranjang Belanja
        </h1>
        <p class="text-sm text-bcake-truffle/70 mb-6">
            Cek lagi pesananmu sebelum lanjut ke tahap berikutnya 💗
        </p>

        @if($items->isEmpty())
            {{-- STATE KOSONG --}}
            <div class="rounded-3xl bg-white border border-rose-100 py-16 flex flex-col items-center justify-center">
                <div class="h-16 w-16 rounded-full bg-rose-50 flex items-center justify-center mb-4">
                    🧺
                </div>
                <p class="font-semibold text-bcake-bitter mb-1">Keranjangmu masih kosong</p>
                <p class="text-sm text-bcake-truffle/70 mb-6">
                    Yuk jelajahi koleksi kue manis di B’cake dan tambahkan ke keranjang.
                </p>
                <a href="{{ route('products.index') }}"
                   class="px-5 py-2.5 rounded-full bg-bcake-cherry text-white text-sm font-semibold hover:bg-bcake-wine">
                    Lihat Produk
                </a>
            </div>
        @else
            {{-- LIST ITEM --}}
            <div class="bg-white rounded-3xl border border-rose-100 p-6 mb-6">
                @foreach($items as $item)
                    <div class="flex items-center gap-4 py-3 border-b border-rose-50 last:border-b-0">
                        <div class="w-16 h-16 rounded-2xl overflow-hidden bg-rose-50">
                            <img src="{{ $item->product->image_url }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-bcake-bitter">
                                {{ $item->product->name }}
                            </p>
                            <p class="text-xs text-bcake-truffle/70">
                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="text-sm text-bcake-truffle/80">
                            x {{ $item->qty }}
                        </div>
                        <div class="w-28 text-right text-sm font-semibold text-bcake-bitter">
                            Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                        </div>
                        <form method="POST"
                              action="{{ route('cart.remove', $item->product) }}"
                              class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button class="text-xs text-rose-500 hover:text-rose-700">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- RINGKASAN --}}
            <div class="flex items-center justify-between bg-white rounded-3xl border border-rose-100 px-6 py-4">
                <div>
                    <p class="text-xs uppercase tracking-wide text-bcake-truffle/60">Total</p>
                    <p class="text-xl font-semibold text-bcake-bitter">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>

                {{-- TOMBOL LANJUT KE PEMESANAN --}}
                <a href="{{ route('cart.checkout') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-bcake-cherry text-white text-sm font-semibold hover:bg-bcake-wine transition">
                    <span>Lanjut ke Pemesanan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 12h14m-7-7l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
