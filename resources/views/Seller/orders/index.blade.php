@extends('layouts.app')

@section('title', 'Pesanan Toko — B’cake')

@section('content')
<section class="bg-rose-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white rounded-3xl shadow-xl px-6 py-6">
            <h1 class="text-2xl font-semibold text-rose-900">
                Pesanan Toko Saya
            </h1>
            <p class="text-rose-500 text-sm mt-1">
                Kelola semua pesanan yang masuk ke toko {{ $store->name ?? 'kamu' }}.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-md px-6 py-6">
            @if(($orders ?? collect())->isEmpty())
                <p class="text-sm text-rose-400">
                    Belum ada pesanan masuk ke toko kamu ✨
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-rose-100 text-rose-500 text-xs">
                                <th class="py-2 text-left">ID</th>
                                <th class="py-2 text-left">Pembeli</th>
                                <th class="py-2 text-left">Tanggal</th>
                                <th class="py-2 text-left">Status</th>
                                <th class="py-2 text-right">Total</th>
                                <th class="py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b border-rose-50 hover:bg-rose-50/40">
                                    <td class="py-2 pr-3 text-xs text-rose-400">
                                        #ORD{{ $order->id }}
                                    </td>
                                    <td class="py-2 pr-3">
                                        <div class="font-semibold text-rose-900 text-xs">
                                            {{ $order->customer_name }}
                                        </div>
                                        <div class="text-[11px] text-rose-400">
                                            {{ $order->customer_phone }}
                                        </div>
                                    </td>
                                    <td class="py-2 pr-3 text-xs text-rose-500">
                                        {{ $order->created_at?->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-2 pr-3">
                                        @php
                                            $status = $order->status ?? 'pending';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px]
                                            @switch($status)
                                                @case('pending')    bg-amber-50 text-amber-700 border border-amber-100 @break
                                                @case('diproses')  bg-sky-50 text-sky-700 border border-sky-100 @break
                                                @case('dikirim')   bg-indigo-50 text-indigo-700 border border-indigo-100 @break
                                                @case('selesai')   bg-emerald-50 text-emerald-700 border border-emerald-100 @break
                                                @case('dibatalkan') bg-rose-50 text-rose-700 border border-rose-100 @break
                                                @default          bg-gray-50 text-gray-600 border border-gray-100
                                            @endswitch
                                        ">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-3 text-right text-xs font-semibold text-rose-900">
                                        Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2 pl-3 text-right">
                                        <a href="{{ route('seller.orders.show', $order) }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px]
                                                  bg-rose-100 text-rose-700 hover:bg-rose-200">
                                            Detail →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>
</section>
@endsection
