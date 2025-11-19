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
                <p class="text-3xl font-semibold text-rose-900">
                    {{ $totalProducts }}
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

        {{-- CHART PENJUALAN --}}
        <div class="bg-white rounded-3xl shadow-md px-6 py-6">
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

    </div>
</section>
@endsection

@push('scripts')
    {{-- Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('salesChart').getContext('2d');

            const labels = @json($salesLabels);
            const data   = @json($salesValues);

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
                        borderColor: 'rgba(244, 63, 94, 1)',      // rose-500
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
