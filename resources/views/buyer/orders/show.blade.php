@extends('layouts.app')

@section('title','Detail Pesanan — B’cake')

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
</style>
@endpush

@section('content')
@php
  $code   = $order->code ?? ('ORD'.$order->id);
  $amount = $order->total_price ?? $order->total ?? 0;
  $status = $order->status ?? 'pending';

  // step tracking sederhana
  $steps = [
      'pending'   => 'Pesanan dibuat',
      'processed' => 'Sedang diproses',
      'shipped'   => 'Dalam pengiriman',
      'completed' => 'Selesai',
  ];

  $statusOrder = array_keys($steps);
@endphp

<div class="page-bg min-h-[calc(100vh-4rem)]">
  <div class="max-w-5xl mx-auto px-4 lg:px-8 py-8 space-y-6">

    {{-- Header + back --}}
    <div class="flex items-center justify-between gap-3">
      <div>
        <p class="text-xs text-gray-500 mb-1">
          <a href="{{ route('buyer.orders.index') }}" class="hover:underline">Riwayat Pesanan</a>
          <span class="mx-1">/</span>
          <span class="text-[var(--bcake-wine)]">#{{ $code }}</span>
        </p>
        <h1 class="text-2xl md:text-3xl font-semibold text-bcake-grad">
          Pesanan #{{ $code }}
        </h1>
        <p class="text-xs text-gray-500 mt-1">
          {{ $order->created_at?->format('d M Y, H:i') }}
        </p>
      </div>

      <a href="{{ route('buyer.orders.index') }}"
         class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-100 text-[var(--bcake-wine)] text-xs hover:bg-rose-200">
        ← Kembali ke riwayat
      </a>
    </div>

    {{-- TRACKING STATUS --}}
    <section class="bg-white rounded-2xl shadow-soft ring-soft p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold text-sm md:text-base">Tracking Status</h2>
        <span class="text-xs px-3 py-1 rounded-full bg-rose-100 text-[var(--bcake-wine)]">
          Status: {{ ucfirst($status) }}
        </span>
      </div>

      {{-- garis step --}}
      <div class="relative mt-4">
        <div class="absolute left-4 right-4 top-1/2 h-px bg-rose-100"></div>
        <div class="flex justify-between relative z-10">
          @foreach($steps as $key => $label)
            @php
              $indexCur = array_search($status, $statusOrder);
              $indexKey = array_search($key, $statusOrder);
              $active   = $indexKey <= $indexCur;
            @endphp
            <div class="flex flex-col items-center text-xs md:text-sm w-1/4">
              <div class="h-8 w-8 rounded-full flex items-center justify-center
                          {{ $active ? 'bg-[var(--bcake-wine)] text-white shadow-md' : 'bg-rose-50 text-gray-400 border border-rose-100' }}">
                {{ $loop->iteration }}
              </div>
              <span class="mt-2 {{ $active ? 'text-[var(--bcake-wine)] font-semibold' : 'text-gray-500' }}">
                {{ $label }}
              </span>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    {{-- DETAIL UTAMA --}}
    <section class="grid md:grid-cols-3 gap-6">
      {{-- info pesanan --}}
      <div class="md:col-span-2 bg-white rounded-2xl shadow-soft ring-soft p-6 space-y-4">
        <h2 class="font-semibold mb-2">Ringkasan Pesanan</h2>

        {{-- Items --}}
        <div class="border border-rose-100 rounded-xl overflow-hidden">
          <table class="w-full text-sm">
            <thead class="bg-rose-50/70 text-gray-600">
              <tr>
                <th class="text-left px-3 py-2">Produk</th>
                <th class="text-center px-3 py-2">Qty</th>
                <th class="text-right px-3 py-2">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @forelse($order->items as $item)
                @php
                  $name = $item->product->name ?? $item->product_name ?? 'Produk';
                  $qty  = $item->quantity ?? $item->qty ?? 1;
                  $sub  = $item->subtotal ?? ($item->price ?? 0) * $qty;
                @endphp
                <tr class="border-t border-rose-100">
                  <td class="px-3 py-2">
                    <div class="font-medium text-sm">{{ $name }}</div>
                    @if($item->note ?? null)
                      <div class="text-[11px] text-gray-500">Catatan: {{ $item->note }}</div>
                    @endif
                  </td>
                  <td class="px-3 py-2 text-center text-xs">
                    {{ $qty }}
                  </td>
                  <td class="px-3 py-2 text-right text-sm">
                    Rp {{ number_format($sub,0,',','.') }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="px-3 py-4 text-center text-gray-500 text-sm">
                    Tidak ada item pada pesanan ini.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- total --}}
        <div class="flex justify-end mt-3">
          <div class="text-sm">
            <div class="flex justify-between gap-8">
              <span class="text-gray-500">Total</span>
              <span class="font-semibold text-bcake-grad">
                Rp {{ number_format($amount,0,',','.') }}
              </span>
            </div>
          </div>
        </div>
      </div>

      {{-- info toko & pemesan --}}
      <div class="space-y-4">
        <div class="bg-white rounded-2xl shadow-soft ring-soft p-5">
          <h3 class="font-semibold text-sm mb-3">Toko</h3>
          <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-rose-50 overflow-hidden">
              @if($order->store && $order->store->logo_url)
                <img src="{{ $order->store->logo_url }}" class="w-full h-full object-cover" alt="">
              @else
                <div class="w-full h-full flex items-center justify-center text-xs text-[var(--bcake-wine)]">
                  🧁
                </div>
              @endif
            </div>
            <div class="text-xs">
              <div class="font-medium">
                {{ $order->store->name ?? 'Toko B’cake' }}
              </div>
              <div class="text-gray-500">
                {{ $order->store->tagline ?? 'Sweet & Elegant' }}
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-soft ring-soft p-5 text-xs space-y-1.5">
          <h3 class="font-semibold text-sm mb-2">Detail Pemesan</h3>
          <div><span class="text-gray-500">Nama:</span> {{ $order->customer_name ?? auth()->user()->name }}</div>
          <div><span class="text-gray-500">WhatsApp:</span> {{ $order->customer_phone ?? '-' }}</div>
          <div class="mt-1">
            <span class="text-gray-500">Alamat:</span>
            <div class="mt-0.5">
              {{ $order->customer_address ?? 'Tidak ada alamat yang diisi.' }}
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-soft ring-soft p-5 text-xs">
          <h3 class="font-semibold text-sm mb-2">Catatan Pesanan</h3>
          <p class="text-gray-600">
            {{ $order->note ?? 'Tidak ada catatan tambahan.' }}
          </p>
        </div>
      </div>
    </section>

  </div>
</div>
@endsection
