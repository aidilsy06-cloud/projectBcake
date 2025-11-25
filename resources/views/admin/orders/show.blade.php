@extends('layouts.app')

@section('title', 'Detail Pesanan #ORD'.$order->id.' — Admin B’cake')

@section('content')
<section class="bg-rose-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-rose-200 text-xs text-rose-700 hover:bg-rose-50">
            ← Kembali ke daftar
        </a>

        <div class="bg-white rounded-2xl shadow-md px-6 py-5 space-y-5">

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-rose-900">
                        Pesanan #ORD{{ $order->id }}
                    </h1>
                    <p class="text-xs text-rose-500 mt-1">
                        Dibuat pada {{ $order->created_at->format('d M Y H:i') }}
                    </p>
                </div>
                @php
                    $status = $order->status ?? 'pending';
                    $classes = match ($status) {
                        'pending'    => 'bg-amber-50 text-amber-700 border border-amber-100',
                        'diproses'   => 'bg-sky-50 text-sky-700 border border-sky-100',
                        'dikirim'    => 'bg-indigo-50 text-indigo-700 border border-indigo-100',
                        'selesai'    => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                        'dibatalkan' => 'bg-rose-50 text-rose-700 border border-rose-100',
                        default      => 'bg-gray-50 text-gray-600 border border-gray-100',
                    };
                @endphp
                <span class="inline-flex px-3 py-1 rounded-full text-[11px] {{ $classes }}">
                    Status: {{ ucfirst($status) }}
                </span>
            </div>

            {{-- DATA PEMBELI --}}
            <div class="grid sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <h2 class="font-semibold text-rose-900 mb-1">Data Pembeli</h2>
                    <p><span class="text-gray-500">Nama:</span> {{ $order->customer_name }}</p>
                    <p><span class="text-gray-500">WhatsApp:</span> {{ $order->customer_phone }}</p>
                    @if($order->customer_address)
                        <p><span class="text-gray-500">Alamat:</span> {{ $order->customer_address }}</p>
                    @endif
                </div>
                <div>
                    <h2 class="font-semibold text-rose-900 mb-1">Toko</h2>
                    <p><span class="text-gray-500">Nama Toko:</span> {{ $order->store->name ?? '-' }}</p>
                    @if($order->store && $order->store->whatsapp)
                        <p>
                            <span class="text-gray-500">WA Toko:</span>
                            {{ $order->store->whatsapp }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- DETAIL ITEM --}}
            <div class="border-t border-rose-100 pt-4">
                <h2 class="text-sm font-semibold text-rose-900 mb-2">Item Pesanan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead class="bg-rose-50 text-rose-500">
                            <tr>
                                <th class="px-3 py-2 text-left">Produk</th>
                                <th class="px-3 py-2 text-right">Qty</th>
                                <th class="px-3 py-2 text-right">Harga</th>
                                <th class="px-3 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($order->items as $item)
                            <tr class="border-t border-rose-50">
                                <td class="px-3 py-2">{{ $item->product_name }}</td>
                                <td class="px-3 py-2 text-right">{{ $item->qty }}</td>
                                <td class="px-3 py-2 text-right">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-2 text-right">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-gray-500">
                                    Tidak ada item tersimpan.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 text-right text-sm font-semibold text-rose-900">
                    Total: Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                </div>
            </div>

            {{-- CATATAN / RINGKASAN --}}
            @if($order->order_summary)
                <div class="border-t border-rose-100 pt-4 text-xs">
                    <h2 class="font-semibold text-rose-900 mb-1">Ringkasan dari Form Checkout</h2>
                    <p class="whitespace-pre-line text-gray-700 text-[11px]">
                        {{ $order->order_summary }}
                    </p>
                </div>
            @endif

            {{-- FORM UBAH STATUS --}}
            <div class="border-t border-rose-100 pt-4">
                <h2 class="text-sm font-semibold text-rose-900 mb-2">Ubah Status Pesanan</h2>

                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}"
                      class="space-y-3 text-xs">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select name="status"
                                class="border border-rose-200 rounded-xl px-3 py-2 w-full sm:w-48 focus:ring-rose-300 focus:border-rose-300">
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>

                        <input type="text" name="note"
                               placeholder="Catatan admin (opsional)…"
                               class="flex-1 border border-rose-200 rounded-xl px-3 py-2 focus:ring-rose-300 focus:border-rose-300">
                    </div>

                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-full bg-rose-600 text-white text-xs hover:bg-rose-700">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection
