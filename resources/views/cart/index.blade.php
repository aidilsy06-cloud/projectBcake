@extends('layouts.app')

@section('title','Keranjang — B’cake')

@section('content')
@php
    // $cart dikirim dari CartController (array: slug => ['product' => Product, 'qty' => int])
    $items   = collect($cart ?? []);
    $isEmpty = $items->isEmpty();
@endphp

<div class="space-y-6">

  {{-- TITLE --}}
  <div>
    <h1 class="text-2xl md:text-3xl font-display text-bcake-wine">Keranjang Belanja</h1>
    <p class="text-sm text-gray-500 mt-1">
      Cek lagi pesananmu sebelum lanjut ke tahap berikutnya 💗
    </p>
  </div>

  {{-- WRAPPER KARTU --}}
  <div class="rounded-3xl bg-white border border-rose-200 shadow-[0_20px_40px_rgba(244,63,94,.06)] overflow-hidden">

    @if($isEmpty)
      {{-- STATE KOSONG --}}
      <div class="px-6 py-10 text-center">
        <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-rose-50 flex items-center justify-center">
          <span class="text-3xl">🧺</span>
        </div>
        <p class="text-base font-medium text-bcake-bitter">Keranjangmu masih kosong</p>
        <p class="text-sm text-gray-500 mt-1">
          Yuk jelajahi koleksi kue manis di B’cake dan tambahkan ke keranjang.
        </p>

        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 rounded-full bg-bcake-wine text-white text-sm hover:bg-bcake-deep">
          Lihat Produk
        </a>
      </div>
    @else
      {{-- LIST ITEM --}}
      <div class="px-4 md:px-6 py-5 overflow-x-auto">
        <table class="min-w-full text-sm align-middle">
          <thead>
            <tr class="border-b border-rose-100 text-gray-500 text-xs uppercase tracking-wide">
              <th class="py-3 text-left">Produk</th>
              <th class="py-3 text-center w-24">Qty</th>
              <th class="py-3 text-right w-32">Harga</th>
              <th class="py-3 text-right w-32">Subtotal</th>
              <th class="py-3 text-right w-24"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $row)
              @php
                /** @var \App\Models\Product $p */
                $p        = $row['product'];
                $qty      = $row['qty'];
                $price    = $p->price ?? 0;
                $subtotal = $price * $qty;
              @endphp
              <tr class="border-b border-rose-50 last:border-0">
                {{-- PRODUK --}}
                <td class="py-3 pr-4">
                  <div class="flex items-center gap-3">
                    <div class="h-14 w-14 rounded-xl overflow-hidden bg-rose-50 border border-rose-100 flex-shrink-0">
                      <img src="{{ $p->image_url ?? 'https://via.placeholder.com/80x80?text=Cake' }}"
                           alt="{{ $p->name }}"
                           class="w-full h-full object-cover">
                    </div>
                    <div>
                      <a href="{{ route('products.show', $p->slug) }}"
                         class="font-medium text-bcake-bitter hover:text-bcake-wine">
                        {{ $p->name }}
                      </a>
                      @if(!empty($p->store?->name))
                        <p class="text-xs text-gray-500 mt-0.5">
                          dari <span class="font-medium">{{ $p->store->name }}</span>
                        </p>
                      @endif
                    </div>
                  </div>
                </td>

                {{-- QTY (hanya tampil, tidak bisa di-edit) --}}
                <td class="py-3 text-center">
                  <span class="inline-flex items-center justify-center min-w-[2.5rem] rounded-full bg-rose-50 px-2 py-1 text-xs font-medium text-bcake-bitter">
                    {{ $qty }}
                  </span>
                </td>

                {{-- HARGA --}}
                <td class="py-3 text-right text-gray-700">
                  Rp {{ number_format($price, 0, ',', '.') }}
                </td>

                {{-- SUBTOTAL --}}
                <td class="py-3 text-right font-semibold text-bcake-bitter">
                  Rp {{ number_format($subtotal, 0, ',', '.') }}
                </td>

                {{-- HAPUS --}}
                <td class="py-3 text-right">
                  <form action="{{ route('cart.remove', $p->slug) }}" method="POST"
                        onsubmit="return confirm('Hapus {{ $p->name }} dari keranjang?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center h-8 w-8 rounded-full border border-rose-200 text-rose-500 hover:bg-rose-50 text-xs"
                            title="Hapus dari keranjang">
                      ✕
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- FOOTER TOTAL --}}
      <div class="border-t border-rose-100 px-4 md:px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-3">
        <div class="text-sm text-gray-500">
          Total item:
          <span class="font-semibold text-bcake-bitter">
            {{ $items->sum(fn($row) => $row['qty']) }}
          </span>
        </div>

        <div class="flex items-center gap-3">
          <div class="text-right mr-2">
            <p class="text-xs text-gray-500">Total pembayaran</p>
            <p class="text-lg font-semibold text-bcake-wine">
              Rp {{ number_format($total ?? 0, 0, ',', '.') }}
            </p>
          </div>

          {{-- Tombol lanjut belanja --}}
          <a href="{{ route('products.index') }}"
             class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-rose-200 text-sm text-bcake-bitter bg-white hover:bg-rose-50">
            Lanjut Belanja
          </a>

          {{-- Placeholder checkout (nanti bisa disambung ke WA / halaman checkout beneran) --}}
          <button type="button"
                  class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-bcake-wine text-white text-sm hover:bg-bcake-deep">
            Checkout (Coming Soon)
          </button>
        </div>
      </div>
    @endif
  </div>

</div>
@endsection
