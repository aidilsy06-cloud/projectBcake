@extends('layouts.app')

@section('title', 'Pesanan Berhasil — B’cake')

@section('content')
<section class="bg-rose-50/70 min-h-[60vh]">
    <div class="max-w-xl mx-auto px-4 py-12">
        <div class="bg-white rounded-3xl shadow-soft border border-rose-100 p-8 text-center">
            <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-emerald-50 flex items-center justify-center">
                <span class="text-3xl">✅</span>
            </div>

            <h1 class="text-2xl font-display text-bcake-bitter mb-2">
                Pesanan Berhasil Dibuat 🎉
            </h1>
            <p class="text-sm text-bcake-truffle/70 mb-6">
                Detail pesananmu sudah tersimpan di B’cake dan siap dikirim ke WhatsApp penjual.
                Silakan cek dan konfirmasi lewat chat ya 💌
            </p>

            <div class="bg-rose-50/80 border border-rose-100 rounded-2xl p-4 text-left text-sm mb-6">
                <p class="text-bcake-truffle/80 mb-1">
                    Kode Pesanan
                </p>
                <p class="font-semibold text-bcake-bitter mb-3">
                    #ORD{{ $order->id }}
                </p>

                <p class="text-bcake-truffle/80 mb-1">
                    Toko
                </p>
                <p class="font-medium text-bcake-bitter">
                    {{ $store->name }}
                </p>
            </div>

            @if($waUrl)
                <a href="{{ $waUrl }}" target="_blank"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 mb-3">
                    <span>Buka WhatsApp Penjual</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 12h14m-7-7l7 7-7 7"/>
                    </svg>
                </a>

                <p class="text-xs text-bcake-truffle/60 mb-6">
                    Jika WhatsApp tidak terbuka otomatis, klik tombol di atas ya 💕
                </p>
            @endif

            <a href="{{ route('cart.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-rose-200 text-xs text-bcake-truffle/80 hover:bg-rose-50">
                Kembali ke Keranjang
            </a>
        </div>
    </div>
</section>

@if($waUrl)
    {{-- Auto buka WA di tab baru, tapi user tetap di halaman sukses --}}
    <script>
        setTimeout(function () {
            try {
                window.open(@json($waUrl), '_blank');
            } catch (e) {
                // diam saja kalau popup diblokir
            }
        }, 800);
    </script>
@endif
@endsection
