@extends('layouts.app')

@section('title', 'Riwayat Pesanan — B’cake')

@section('content')
<section class="bg-rose-50/70 min-h-[60vh]">
    <div class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-display text-bcake-bitter mb-2">
            Riwayat Pesanan
        </h1>
        <p class="text-sm text-bcake-truffle/70 mb-6">
            Lihat kembali pesanan yang pernah kamu buat di B’cake 💌
        </p>

        @if($orders->isEmpty())
            <div class="bg-white border border-rose-100 rounded-3xl p-10 text-center">
                <div class="h-14 w-14 rounded-full bg-rose-50 flex items-center justify-center mx-auto mb-4">
                    🧾
                </div>
                <p class="font-semibold text-bcake-bitter mb-1">
                    Belum ada riwayat pesanan
                </p>
                <p class="text-sm text-bcake-truffle/70 mb-4">
                    Setelah kamu melakukan pemesanan, daftar pesananmu akan muncul di sini.
                </p>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-bcake-cherry text-white text-sm font-semibold hover:bg-bcake-wine">
                    Jelajahi Kue Manis
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white border border-rose-100 rounded-2xl p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3 shadow-soft">
                        <div class="text-left">
                            <p class="text-xs text-bcake-truffle/60 mb-1">
                                #ORD{{ $order->id }} • {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="font-semibold text-bcake-bitter">
                                {{ $order->store->name ?? 'Toko tidak ditemukan' }}
                            </p>
                            <p class="text-xs text-bcake-truffle/70 mt-1">
                                {{ \Illuminate\Support\Str::limit(str_replace(["\r", "\n"], ' ', $order->order_summary), 90) }}
                            </p>
                        </div>

                        <div class="flex flex-col items-start md:items-end gap-2">
                            @php
                                $status = $order->status ?? 'draft';
                                $badgeText = $status === 'draft'
                                    ? 'Menunggu konfirmasi'
                                    : ucfirst($status);
                            @endphp

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs
                                {{ $status === 'draft'
                                    ? 'bg-amber-50 text-amber-700 border border-amber-100'
                                    : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                                {{ $badgeText }}
                            </span>

                            <a href="{{ route('orders.success', $order) }}"
                               class="inline-flex items-center gap-1 text-xs text-bcake-cherry hover:text-bcake-wine">
                                Lihat detail / buka WhatsApp
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 12h14m-7-7l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
