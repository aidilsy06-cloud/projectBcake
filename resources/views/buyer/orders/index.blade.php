@extends('layouts.app')

@section('title','Riwayat Pesanan — B’cake')

@push('head')
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
  }
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }
  .shadow-soft{box-shadow:0 18px 40px rgba(54,35,32,.10)}
  .ring-soft{box-shadow:inset 0 0 0 1px rgba(244,63,94,.22)}
  .text-bcake-grad{
    background: linear-gradient(90deg, var(--bcake-cocoa), var(--bcake-wine));
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
  }
  .badge-status{
    @apply inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium;
  }
</style>
@endpush

@section('content')
<div class="page-bg min-h-[calc(100vh-4rem)]">
  <div class="max-w-5xl mx-auto px-4 lg:px-8 py-8 space-y-6">

    {{-- header --}}
    <div class="flex items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl md:text-3xl font-semibold text-bcake-grad">
          Riwayat Pesanan
        </h1>
        <p class="text-sm text-gray-600">
          Lihat status dan detail pemesananmu di B’cake ✨
        </p>
      </div>

      <a href="{{ route('buyer.dashboard') }}"
         class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-100 text-[var(--bcake-wine)] text-xs hover:bg-rose-200">
        ← Kembali ke dashboard
      </a>
    </div>

    {{-- kartu tabel --}}
    <div class="bg-white rounded-2xl shadow-soft ring-soft overflow-hidden">
      <div class="px-4 py-3 border-b border-rose-100 flex items-center justify-between">
        <span class="text-sm font-medium text-gray-700">Daftar Pesanan</span>
        <span class="text-xs text-gray-500">
          {{ $orders->count() }} pesanan terakhir
        </span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-rose-50/80 text-gray-600">
            <tr>
              <th class="text-left px-4 py-2.5">Order</th>
              <th class="text-left px-4 py-2.5">Toko</th>
              <th class="text-left px-4 py-2.5">Tanggal</th>
              <th class="text-left px-4 py-2.5">Status</th>
              <th class="text-right px-4 py-2.5">Total</th>
            </tr>
          </thead>
          <tbody>
          @forelse($orders as $order)
            @php
              $code   = $order->code ?? ('ORD'.$order->id);
              $amount = $order->total_price ?? $order->total ?? 0;
              $status = $order->status ?? 'pending';
              $store  = $order->store->name ?? '-';

              // warna badge simple
              $statusClass = match($status) {
                  'processed','diproses' => 'bg-amber-100 text-amber-800',
                  'shipped','dikirim'    => 'bg-sky-100 text-sky-800',
                  'completed','selesai'  => 'bg-emerald-100 text-emerald-800',
                  'cancelled','batal'    => 'bg-gray-200 text-gray-700',
                  default                => 'bg-rose-100 text-rose-800',
              };
            @endphp
            <tr class="border-t border-rose-100 hover:bg-rose-50 cursor-pointer"
                onclick="window.location='{{ route('buyer.orders.show', $order) }}'">
              <td class="px-4 py-3 font-medium text-[var(--bcake-wine)]">
                #{{ $code }}
              </td>
              <td class="px-4 py-3 text-xs text-gray-700">
                {{ $store }}
              </td>
              <td class="px-4 py-3 text-xs text-gray-600">
                {{ $order->created_at?->format('d M Y, H:i') }}
              </td>
              <td class="px-4 py-3">
                <span class="badge-status {{ $statusClass }}">
                  {{ ucfirst($status) }}
                </span>
              </td>
              <td class="px-4 py-3 text-right font-semibold text-bcake-grad">
                Rp {{ number_format($amount,0,',','.') }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                Kamu belum pernah membuat pesanan.
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection
