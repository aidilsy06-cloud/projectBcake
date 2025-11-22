@extends('layouts.app')

@section('title', 'Detail Pesanan — #ORD'.$order->id)

@section('content')
<div class="max-w-5xl mx-auto py-10 space-y-6">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-rose-500 mb-2">&larr; Kembali</a>

    <div class="bg-white rounded-3xl shadow-soft p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div>
                <h1 class="text-xl font-bold text-rose-900">
                    Pesanan #ORD{{ $order->id }}
                </h1>
                <p class="text-sm text-rose-400">
                    {{ $order->created_at->format('d M Y H:i') }} ·
                    Toko: {{ $order->store->name ?? '-' }}
                </p>
            </div>

            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}"
                  class="flex flex-col items-end gap-2">
                @csrf
                <select name="status" class="border rounded-full px-3 py-1 text-sm">
                    @foreach (['pending','diproses','dikirim','selesai','dibatalkan'] as $st)
                        <option value="{{ $st }}" @selected($order->status === $st)>
                            {{ ucfirst($st) }}
                        </option>
                    @endforeach
                </select>
                <button class="px-4 py-1 rounded-full bg-rose-600 text-white text-xs font-semibold">
                    Update Status
                </button>
            </form>
        </div>

        <div class="grid md:grid-cols-2 gap-6 text-sm">
            <div>
                <h2 class="font-semibold text-rose-900 mb-2">Data Pembeli</h2>
                <p class="text-rose-900">{{ $order->customer_name }}</p>
                <p class="text-rose-500">{{ $order->customer_phone }}</p>
                @if($order->customer_address)
                    <p class="mt-2 text-rose-500">{{ $order->customer_address }}</p>
                @endif
            </div>
            <div>
                <h2 class="font-semibold text-rose-900 mb-2">Info Pesanan</h2>
                <p>Total:
                    <span class="font-semibold">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                </p>
                <p>Status: <span class="font-semibold">{{ $order->status_label }}</span></p>
            </div>
        </div>

        @if($order->note)
            <div class="mt-4 pt-4 border-t border-rose-50 text-sm">
                <h2 class="font-semibold text-rose-900 mb-1">Catatan Pembeli</h2>
                <p class="text-rose-500 whitespace-pre-line">{{ $order->note }}</p>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-3xl shadow-soft p-6">
        <h2 class="font-semibold text-rose-900 mb-3">Item Pesanan</h2>
        <table class="w-full text-sm">
            <thead class="text-rose-500">
                <tr>
                    <th class="text-left py-2">Produk</th>
                    <th class="text-center py-2">Qty</th>
                    <th class="text-right py-2">Harga</th>
                    <th class="text-right py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order->items as $item)
                    <tr class="border-t border-rose-50">
                        <td class="py-2">{{ $item->product_name }}</td>
                        <td class="py-2 text-center">{{ $item->qty }}</td>
                        <td class="py-2 text-right">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="py-2 text-right">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-rose-300">
                            Tidak ada item tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
