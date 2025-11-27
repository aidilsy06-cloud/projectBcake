@extends('layouts.app')

@section('title', 'Dashboard Seller — B’cake')

@section('content')
<section class="bg-rose-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- HEADER --}}
        <div class="bg-white rounded-3xl shadow-xl px-6 py-6">
            <h1 class="text-2xl font-semibold text-rose-900">
                Halo, {{ $user->name ?? 'Seller' }} ✨
            </h1>
            <p class="text-rose-500 text-sm mt-1">
                Selamat datang di dashboard seller B’cake. Kelola toko & katalogmu dengan mudah.
            </p>
        </div>

        {{-- STATISTIK KECIL --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- TOTAL PRODUK --}}
            <div class="bg-white rounded-2xl px-5 py-4 shadow-md">
                <p class="text-xs text-rose-400 mb-1">Total Produk</p>

                @php
                    use App\Models\Product;

                    $authUser = auth()->user();

                    // Hitung semua produk milik seller ini berdasarkan user_id
                    $totalProductsDisplay = $authUser
                        ? Product::where('user_id', $authUser->id)->count()
                        : 0;
                @endphp

                <p class="text-3xl font-semibold text-rose-900">
                    {{ $totalProductsDisplay }}
                </p>
            </div>

            {{-- KELOLA PRODUK --}}
            <div class="bg-white rounded-2xl px-5 py-4 shadow-md">
                <p class="text-xs text-rose-400 mb-1">Katalog</p>
                <p class="text-sm text-rose-900 font-semibold">Kelola Produk</p>
                <a href="{{ route('seller.products.index') }}"
                   class="text-xs inline-block mt-2 px-3 py-1 rounded-full
                          border border-rose-200 text-rose-700 hover:bg-rose-50">
                    Buka Katalog →
                </a>
            </div>

            {{-- PROFIL TOKO --}}
            <div class="bg-white rounded-2xl px-5 py-4 shadow-md">
                <p class="text-xs text-rose-400 mb-1">Profil Toko</p>
                <p class="text-sm text-rose-900 font-semibold">Edit Toko</p>
                <a href="{{ route('seller.store.edit') }}"
                   class="text-xs inline-block mt-2 px-3 py-1 rounded-full
                          border border-rose-200 text-rose-700 hover:bg-rose-50">
                    Edit Profil →
                </a>
            </div>
        </div>

        {{-- GRID: CHART + PESANAN TERBARU --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- CHART PENJUALAN --}}
            <div class="bg-white rounded-3xl shadow-md px-6 py-6 lg:col-span-3">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-base font-semibold text-rose-900">
                            Ringkasan Penjualan 6 Bulan Terakhir
                        </h2>
                        <p class="text-xs text-rose-400">
                            Total omzet per bulan untuk toko kamu.
                        </p>
                    </div>
                </div>

                <div class="h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- PESANAN TERBARU --}}
            <div class="bg-white rounded-3xl shadow-md px-5 py-6 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-base font-semibold text-rose-900">
                            Pesanan Terbaru
                        </h2>
                        <p class="text-xs text-rose-400">
                            Pesanan yang masuk ke toko kamu.
                        </p>
                    </div>
                    {{-- link ke daftar pesanan seller --}}
                    <a href="{{ route('seller.orders.index') }}"
                       class="text-[11px] text-rose-500 hover:text-rose-700">
                        Lihat semua →
                    </a>
                </div>

                @php
                    $ordersList = $recentOrders ?? collect();
                @endphp

                @if($ordersList->isEmpty())
                    <p class="text-xs text-rose-400">
                        Belum ada pesanan masuk. Link checkout dari pembeli akan muncul di sini ✨
                    </p>
                @else
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                        @foreach($ordersList as $order)
                            @php
                                $status    = $order->status ?? 'draft';
                                $badgeText = $status === 'draft'
                                    ? 'Menunggu konfirmasi'
                                    : ucfirst($status);
                            @endphp

                            <div class="border border-rose-100 rounded-2xl px-3 py-3 flex items-start gap-3">
                                <div class="mt-1 text-xs text-rose-400">
                                    #ORD{{ $order->id }}
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-rose-900">
                                        {{ $order->customer_name }}
                                    </p>
                                    <p class="text-[11px] text-rose-400">
                                        {{ $order->created_at?->format('d M Y, H:i') }}
                                    </p>
                                    <p class="text-[11px] text-rose-500 mt-1">
                                        {{ \Illuminate\Support\Str::limit(str_replace(["\r", "\n"], ' ', $order->order_summary), 80) }}
                                    </p>

                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px]
                                            {{ $status === 'draft'
                                                ? 'bg-amber-50 text-amber-700 border border-amber-100'
                                                : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                                            {{ $badgeText }}
                                        </span>

                                        {{-- tombol cepat untuk buka WA pembeli --}}
                                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', $order->customer_phone) }}"
                                           target="_blank"
                                           class="inline-flex items-center text-[10px] text-emerald-600 hover:text-emerald-700">
                                            Chat Pembeli
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
    {{-- Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('salesChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            const labels = @json($salesLabels ?? []);
            const data   = @json($salesValues ?? []);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: data,
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        borderColor: 'rgba(244, 63, 94, 1)',       // rose-500
                        backgroundColor: 'rgba(248, 113, 113, .18)' // rose-400 transparan
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y || 0;
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                },
                                font: { size: 11 }
                            },
                            grid: { color: 'rgba(248, 250, 252, 1)' }
                        },
                        x: {
                            ticks: { font: { size: 11 } },
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
@endpush
