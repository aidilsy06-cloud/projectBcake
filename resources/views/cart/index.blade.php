@extends('layouts.app')
@section('title', 'Keranjang — B’cake')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="font-display text-3xl mb-6">Keranjang</h1>

    @if(session('ok'))
        <div class="mb-4 p-3 rounded bg-green-100 border border-green-300 text-green-700">
            {{ session('ok') }}
        </div>
    @endif

    @if(empty($cart))
        <p class="text-bcake-truffle text-center py-10">Keranjang masih kosong.</p>
    @else
        <form method="POST" action="{{ route('cart.update') }}">
            @csrf

            <div class="overflow-hidden rounded-xl2 border border-bcake-truffle/20 bg-white">
                <table class="w-full">
                    <thead class="bg-bcake-icing">
                        <tr class="text-left text-sm">
                            <th class="p-4">Produk</th>
                            <th class="p-4">Harga</th>
                            <th class="p-4">Qty</th>
                            <th class="p-4">Subtotal</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $row)
                            <tr class="border-t">
                                <td class="p-4 flex items-center gap-3">
                                    <img src="{{ $row['product']->image_url }}" class="w-14 h-14 object-cover rounded-xl2">
                                    <div class="font-medium">{{ $row['product']->name }}</div>
                                </td>
                                <td class="p-4">Rp {{ number_format($row['product']->price,0,',','.') }}</td>
                                <td class="p-4">
                                    <input type="number" name="qty[{{ $row['product']->slug }}]" value="{{ $row['qty'] }}" min="1" class="w-20 rounded-xl2 border">
                                </td>
                                <td class="p-4">Rp {{ number_format($row['qty'] * $row['product']->price,0,',','.') }}</td>
                                <td class="p-4">
                                    <form method="POST" action="{{ route('cart.remove', $row['product']->slug) }}">
                                        @csrf
                                        <button class="text-sm text-bcake-cherry hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="text-bcake-truffle">Total:
                    <span class="text-2xl font-semibold text-bcake-wine">Rp {{ number_format($total,0,',','.') }}</span>
                </div>

                <div class="flex gap-3">
                    <button class="px-5 py-3 rounded-xl2 shadow-soft bg-bcake-cherry text-white hover:bg-bcake-wine">
                        Perbarui
                    </button>
                    <a href="#" class="px-5 py-3 rounded-xl2 shadow-soft bg-bcake-wine text-white hover:bg-bcake-bitter">
                        Checkout
                    </a>
                </div>
            </div>
        </form>
    @endif
</section>
@endsection
