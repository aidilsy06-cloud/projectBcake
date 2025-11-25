{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Produk — Admin')

@section('content')
<section class="bg-rose-50 py-8">
    <div class="max-w-6xl mx-auto px-4 space-y-6">

        <h1 class="text-2xl font-semibold text-rose-900 mb-2">
            Kelola Produk
        </h1>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl px-4 py-3 shadow-sm">
                <p class="text-xs text-rose-400">Total</p>
                <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl px-4 py-3 shadow-sm">
                <p class="text-xs text-amber-500">Pending</p>
                <p class="text-2xl font-bold">{{ $stats['pending'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl px-4 py-3 shadow-sm">
                <p class="text-xs text-emerald-500">Approved</p>
                <p class="text-2xl font-bold">{{ $stats['approved'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl px-4 py-3 shadow-sm">
                <p class="text-xs text-rose-500">Rejected</p>
                <p class="text-2xl font-bold">{{ $stats['rejected'] ?? 0 }}</p>
            </div>
        </div>

        {{-- Filter --}}
        <form method="GET" class="flex flex-wrap gap-3 items-center bg-white rounded-2xl px-4 py-3 shadow-sm">
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari produk / toko..."
                   class="border rounded-xl px-3 py-2 text-sm flex-1">

            <select name="status" class="border rounded-xl px-3 py-2 text-sm">
                @php $s = request('status', 'all'); @endphp
                <option value="all"      {{ $s === 'all' ? 'selected' : '' }}>Semua status</option>
                <option value="pending"  {{ $s === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $s === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $s === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <button class="bg-rose-600 text-white px-4 py-2 rounded-xl text-sm">
                Terapkan
            </button>
        </form>

        {{-- Tabel produk --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-rose-50 text-xs text-rose-500">
                    <tr>
                        <th class="px-3 py-2 text-left">Produk</th>
                        <th class="px-3 py-2 text-left">Toko</th>
                        <th class="px-3 py-2 text-left">Kategori</th>
                        <th class="px-3 py-2 text-right">Harga</th>
                        <th class="px-3 py-2 text-center">Status</th>
                        <th class="px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr class="border-t">
                            <td class="px-3 py-2">
                                <div class="font-semibold">{{ $p->name }}</div>
                                <div class="text-[11px] text-gray-400">#{{ $p->id }}</div>
                            </td>
                            <td class="px-3 py-2">
                                {{ $p->store->name ?? '-' }}
                            </td>
                            <td class="px-3 py-2">
                                {{ $p->category->name ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-right">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-2 text-center">
                                @php
                                    $color = match($p->status) {
                                        'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
                                        default    => 'bg-amber-50 text-amber-700 border-amber-100',
                                    };
                                @endphp
                                <span class="inline-flex px-2 py-1 rounded-full border text-[11px] {{ $color }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- tombol approve --}}
                                    <form action="{{ route('admin.products.updateStatus', $p) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button class="text-[11px] px-2 py-1 rounded-full bg-emerald-500 text-white">
                                            Approve
                                        </button>
                                    </form>

                                    {{-- tombol reject --}}
                                    <form action="{{ route('admin.products.updateStatus', $p) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="text-[11px] px-2 py-1 rounded-full bg-rose-500 text-white">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-6 text-center text-gray-500">
                                Belum ada produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-3 py-2">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>

    </div>
</section>
@endsection
