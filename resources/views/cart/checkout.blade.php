@extends('layouts.app')

@section('title', 'Checkout — B’cake')

@section('content')

<section class="max-w-4xl mx-auto mb-10">
    <h1 class="text-3xl font-display text-bcake-wine mb-2">Checkout Pesanan</h1>
    <p class="text-sm text-gray-600 mb-6">
        Cek data dan lengkapi informasi sebelum pesananmu dikirim ke WhatsApp penjual 💌
    </p>

    <div class="grid md:grid-cols-5 gap-6">
        {{-- Ringkasan Keranjang --}}
        <div class="md:col-span-3 bg-white border border-rose-200/60 rounded-2xl p-5 shadow-soft">
            <h2 class="text-lg font-semibold text-bcake-bitter mb-3">Ringkasan Pesanan</h2>

            <div class="space-y-3">
                @foreach($items as $item)
                    <div class="flex justify-between items-center text-sm">
                        <div>
                            <p class="font-medium text-bcake-bitter">{{ $item->product->name }}</p>
                            <p class="text-gray-500">
                                {{ $item->qty }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="font-semibold text-bcake-wine">
                            Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 border-t border-rose-100 pt-3 flex justify-between text-sm">
                <span class="font-semibold text-bcake-bitter">Total</span>
                <span class="font-semibold text-bcake-wine">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Form Identitas + Kirim WA --}}
        <div class="md:col-span-2 bg-white border border-rose-200/60 rounded-2xl p-5 shadow-soft">
            <h2 class="text-lg font-semibold text-bcake-bitter mb-3">Data Pemesan</h2>

            <form action="{{ route('stores.order', $store) }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="customer_name"
                           value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                           required
                           class="w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:ring-rose-300 focus:border-rose-300">
                </div>

                <div>
                    <label class="block text-xs font-medium mb-1">Nomor WhatsApp</label>
                    <input type="text" name="customer_phone"
                           value="{{ old('customer_phone') }}"
                           placeholder="08xxxx"
                           required
                           class="w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:ring-rose-300 focus:border-rose-300">
                </div>

                <div>
                    <label class="block text-xs font-medium mb-1">Alamat (Opsional)</label>
                    <textarea name="customer_address" rows="2"
                              class="w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:ring-rose-300 focus:border-rose-300"
                              placeholder="Tulis alamat lengkap jika perlu pengantaran">{{ old('customer_address') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-medium mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="note" rows="2"
                              class="w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:ring-rose-300 focus:border-rose-300"
                              placeholder="Contoh: tanpa kacang, dibungkus terpisah, dll">{{ old('note') }}</textarea>
                </div>

                {{-- Ringkasan pesanan dari keranjang (hidden) --}}
                <textarea name="order_summary" class="hidden" readonly>{{ $orderSummaryText }}</textarea>

                <button type="submit"
                        class="mt-2 w-full px-4 py-2.5 rounded-full bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 inline-flex items-center justify-center gap-2">
                    <span>Kirim ke WhatsApp Penjual</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 12h14m-7-7l7 7-7 7"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
