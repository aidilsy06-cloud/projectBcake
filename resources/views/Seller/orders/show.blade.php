@extends('layouts.app')

@section('title', 'Detail Pesanan — B’cake')

@section('content')
<section class="bg-rose-50 py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white rounded-3xl shadow-xl px-6 py-6">
            <a href="{{ route('seller.orders.index') }}"
               class="text-xs text-rose-500 hover:text-rose-700">
                ← Kembali ke daftar pesanan
            </a>

            <div class="mt-3 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-rose-900">
                        Pesanan #ORD{{ $order->id }}
                    </h1>
                    <p class="text-xs text-rose-400 mt-1">
                        {{ $order->created_at?->format('d M Y, H:i') }}
                    </p>
                </div>
                @php $status = $order->status ?? 'pending'; @endphp
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px]
                    @switch($status)
                        @case('pending')    bg-amber-50 text-amber-700 border border-amber-100 @break
                        @case('diproses')  bg-sky-50 text-sky-700 border border-sky-100 @break
                        @case('dikirim')   bg-indigo-50 text-indigo-700 border border-indigo-100 @break
                        @case('selesai')   bg-emerald-50 text-emerald-700 border border-emerald-100 @break
                        @case('dibatalkan') bg-rose-50 text-rose-700 border border-rose-100 @break
                        @default           bg-gray-50 text-gray-600 border border-gray-100
                    @endswitch
                ">
                    {{ ucfirst($status) }}
                </span>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-md px-6 py-6 space-y-5">
            {{-- DATA PEMBELI --}}
            <div>
                <h2 class="text-sm font-semibold text-rose-900 mb-2">Data Pembeli</h2>
                <dl class="text-xs text-rose-700 space-y-1">
                    <div class="flex">
                        <dt class="w-24 text-rose-400">Nama</dt>
                        <dd>{{ $order->customer_name }}</dd>
                    </div>
                    <div class="flex">
                        <dt class="w-24 text-rose-400">WhatsApp</dt>
                        <dd>{{ $order->customer_phone }}</dd>
                    </div>
                    @if($order->customer_address)
                        <div class="flex">
                            <dt class="w-24 text-rose-400">Alamat</dt>
                            <dd>{{ $order->customer_address }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- RINGKASAN PESANAN --}}
            <div>
                <h2 class="text-sm font-semibold text-rose-900 mb-2">Ringkasan Pesanan</h2>
                <div class="text-xs text-rose-700 whitespace-pre-line bg-rose-50/70 rounded-xl px-3 py-3">
                    {{ $order->order_summary }}
                </div>
            </div>

            {{-- CATATAN TAMBAHAN --}}
            @if($order->note)
                <div>
                    <h2 class="text-sm font-semibold text-rose-900 mb-2">Catatan Pembeli</h2>
                    <div class="text-xs text-rose-700 bg-rose-50/70 rounded-xl px-3 py-3">
                        {{ $order->note }}
                    </div>
                </div>
            @endif

            {{-- TOTAL & AKSI --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-rose-100">
                <div>
                    <p class="text-xs text-rose-400">Total Estimasi</p>
                    <p class="text-lg font-semibold text-rose-900">
                        Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-2 justify-end">
                    {{-- Update status --}}
                    <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST"
                          class="flex items-center gap-2 text-xs">
                        @csrf
                        <select name="status"
                                class="border border-rose-200 rounded-full px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-rose-300">
                            <option value="pending"    @selected($order->status === 'pending')>Pending</option>
                            <option value="diproses"  @selected($order->status === 'diproses')>Diproses</option>
                            <option value="dikirim"   @selected($order->status === 'dikirim')>Dikirim</option>
                            <option value="selesai"   @selected($order->status === 'selesai')>Selesai</option>
                            <option value="dibatalkan" @selected($order->status === 'dibatalkan')>Dibatalkan</option>
                        </select>
                        <button type="submit"
                                class="px-4 py-1.5 rounded-full bg-rose-600 text-white hover:bg-rose-700">
                            Update Status
                        </button>
                    </form>

                    {{-- Chat pembeli --}}
                    <a href="https://wa.me/{{ preg_replace('/\D+/', '', $order->customer_phone) }}"
                       target="_blank"
                       class="px-4 py-1.5 rounded-full bg-emerald-600 text-white text-xs hover:bg-emerald-700">
                        Chat Pembeli
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
