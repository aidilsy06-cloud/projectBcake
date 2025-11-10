@extends('layouts.app')

@section('title','B’cake — Keranjang')

@section('content')
<section class="min-h-[70vh] bg-rose-50 py-6">
  <div class="max-w-md mx-auto px-4">
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-4">
      <h1 class="font-display text-3xl">My Bag</h1>
      <a href="{{ route('products.index') }}" class="text-sm text-bcake-wine hover:underline">×</a>
    </div>

    {{-- KARTU WRAPPER --}}
    <div class="rounded-3xl bg-white border border-rose-200 shadow-[0_20px_40px_rgba(137,5,36,.06)] overflow-hidden">

      {{-- LIST ITEM --}}
      @php
        // contoh bentuk $cartItems:
        // $cartItems = collect(session('cart', [])); // id => ['name','price','qty','image']
        $cartItems = $cartItems ?? collect(session('cart', []));
        $isEmpty   = $cartItems->isEmpty();
        $subtotal  = $cartItems->sum(fn($i)=> $i['price'] * $i['qty']);
      @endphp

      @if($isEmpty)
        <div class="p-8 text-center">
          <p class="text-bcake-truffle/70">Keranjangmu masih kosong.</p>
          <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">Belanja sekarang</a>
        </div>
      @else
        <ul class="divide-y divide-rose-100">
          @foreach($cartItems as $rowId => $item)
          <li class="p-4">
            <div class="flex gap-3">
              {{-- Thumbnail --}}
              <img src="{{ $item['image'] ?? asset('image/cake.jpg') }}"
                   alt="{{ $item['name'] }}"
                   class="w-16 h-16 rounded-xl object-cover border border-rose-100">

              <div class="flex-1">
                <div class="flex items-start justify-between gap-2">
                  <div>
                    <div class="font-medium leading-tight">{{ $item['name'] }}</div>
                    <div class="text-xs text-bcake-truffle/60 mt-0.5">
                      {{ 'Rp '.number_format($item['price'],0,',','.') }}
                    </div>
                  </div>

                  {{-- Hapus --}}
                  <form action="{{ route('cart.remove', $rowId) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                    @csrf @method('DELETE')
                    <button class="w-8 h-8 rounded-full border border-rose-200 text-bcake-truffle/60 hover:text-bcake-wine">×</button>
                  </form>
                </div>

                {{-- Qty controls --}}
                <div class="mt-2 flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <form action="{{ route('cart.update', $rowId) }}" method="POST">
                      @csrf @method('PATCH')
                      <input type="hidden" name="qty" value="{{ max(1, $item['qty'] - 1) }}">
                      <button class="w-8 h-8 rounded-full border border-rose-200 flex items-center justify-center">−</button>
                    </form>

                    <div class="px-3 text-sm font-medium">{{ $item['qty'] }}</div>

                    <form action="{{ route('cart.update', $rowId) }}" method="POST">
                      @csrf @method('PATCH')
                      <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                      <button class="w-8 h-8 rounded-full border border-rose-200 flex items-center justify-center">＋</button>
                    </form>
                  </div>

                  {{-- line total --}}
                  <div class="font-semibold">
                    {{ 'Rp '.number_format($item['price'] * $item['qty'],0,',','.') }}
                  </div>
                </div>
              </div>
            </div>
          </li>
          @endforeach
        </ul>

        {{-- Total + CTA --}}
        <div class="px-4 pt-4 pb-5">
          <div class="flex items-center justify-between text-sm text-bcake-truffle/70">
            <span>Total Amount</span>
            <span class="text-lg font-semibold text-bcake-bitter">
              {{ 'Rp '.number_format($subtotal,0,',','.') }}
            </span>
          </div>

          {{-- Checkout Button --}}
          <a href="{{ route('checkout.index') }}"
             class="mt-4 block text-center rounded-full bg-[#ffd89a] hover:bg-[#ffc96b] text-bcake-bitter font-medium py-3 shadow-[0_8px_18px_rgba(0,0,0,.08)]">
            Check out
          </a>

          <a href="{{ route('products.index') }}"
             class="mt-2 block text-center text-sm text-bcake-truffle/70 hover:text-bcake-wine">
            Continue shopping
          </a>
        </div>
      @endif
    </div>

    {{-- handle notch indikator bawah (opsional estetika mobile) --}}
    <div class="mt-4 flex justify-center">
      <span class="h-1.5 w-24 rounded-full bg-rose-200/80"></span>
    </div>
  </div>
</section>
@endsection

