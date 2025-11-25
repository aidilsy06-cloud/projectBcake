@extends('layouts.app')

@section('title', 'Kelola Pesanan — Admin B’cake')

@section('content')
<section class="bg-rose-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- HEADER --}}
        <div class="bg-white rounded-2xl shadow-md px-5 py-4 flex flex-col sm:flex-row sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-semibold text-rose-900">
                    Kelola Pesanan
                </h1>
                <p class="text-xs text-rose-500 mt-1">
                    Lihat dan atur semua pesanan yang masuk di B’cake.
                </p>
            </div>

            <form method="GET" class="sm:ml-auto flex items-center gap-2 text-xs">
                <label for="status" class="text-gray-500">Filter status:</label>
                <select id="status" name="status"
                        class="border border-rose-200 rounded-full px-3 py-1 text-xs focus:ring-rose-300 focus:border-rose-300">
                    @php $current = $status ?? 'all'; @endphp
                    <option value="all" {{ $current === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="pending" {{ $current === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ $current === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="dikirim" {{ $current === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="selesai" {{ $current === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ $current === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button class="px-3 py-1 rounded-full bg-rose-600 text-white text-xs hover:bg-rose-700">
                    Terapkan
                </button>
            </form>
        </div>

        {{-- KARTU STATISTIK --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 text-xs">
            <div class="bg-white rounded-2xl shadow-sm px-4 py-3">
                <p class="text-rose-400">Total</p>
                <p class="text-2xl font-semibold text-rose-900">{{ $stats['total'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm px-4 py-3">
                <p class="text-amber-500">Pending</p>
                <p class="text-2xl font-semibold text-rose-900">{{ $stats['pending'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm px-4 py-3">
                <p class="text-sky-500">Diproses</p>
                <p class="text-2xl font-semibold text-rose-900">{{ $stats['diproses'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm px-4 py-3">
                <p class="text-indigo-500">Dikirim</p>
                <p class="text-2xl font-semibold text-rose-900">{{ $stats['dikirim'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm px-4 py-3">
                <p class="text-emerald-500">Selesai</p>
                <p class="text-2xl font-semibold text-rose-900">{{ $stats['selesai'] ?? 0 }}</p>
            </div>
        </div>

        {{-- TABEL PESANAN --}}
        <div class="bg-white rounded-2xl shadow-md px-5 py-4">
            <h2 class="text-sm font-semibold text-rose-900 mb-3">Daftar Pesanan</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead class="bg-rose-50 text-rose-500">
                        <tr>
                            <th class="px-3 py-2 text-left">ID</th>
                            <th class="px-3 py-2 text-left">Toko</th>
                            <th class="px-3 py-2 text-left">Pembeli</th>
                            <th class="px-3 py-2 text-left">Tanggal</th>
                            <th class="px-3 py-2 text-right">Total</th>
                            <th class="px-3 py-2 text-center">Status</th>
                            <th class="px-3 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="border-t border-rose-50">
                                <td class="px-3 py-2 align-top">#ORD{{ $order->id }}</td>
                                <td class="px-3 py-2 align-top">
                                    {{ $order->store->name ?? '-' }}
                                </td>
                                <td class="px-3 py-2 align-top">
                                    <div class="font-medium text-rose-900">{{ $order->customer_name }}</div>
                                    <div class="text-[10px] text-gray-500">
                                        {{ $order->customer_phone }}
                                    </div>
                                </td>
                                <td class="px-3 py-2 align-top">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-3 py-2 text-right align-top">
                                    Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-2 text-center align-top">
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
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] {{ $classes }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-right align-top">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="inline-flex items-center px-3 py-1 rounded-full bg-rose-600 text-white text-[11px] hover:bg-rose-700">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-6 text-center text-gray-500">
                                    Belum ada pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINASI --}}
            <div class="mt-4">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
