@extends('layouts.app')

@section('title', 'Produk Toko Saya — B’cake')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    @if (session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-rose-900">Produk Toko Saya</h1>
            <p class="text-sm text-rose-500">Kelola semua kue yang tampil di katalog B’cake.</p>
        </div>
        <a href="{{ route('seller.products.create') }}"
           class="inline-flex items-center rounded-full bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-rose-700">
            + Tambah Produk
        </a>
    </div>

    @if ($products->isEmpty())
        <div class="rounded-2xl border border-dashed border-rose-200 bg-rose-50/60 px-6 py-10 text-center">
            <p class="text-rose-700 font-medium mb-1">Belum ada produk.</p>
            <p class="text-sm text-rose-500 mb-4">
                Yuk tambah produk pertama supaya pelanggan bisa mulai pesan kue kamu.
            </p>
            <a href="{{ route('seller.products.create') }}"
               class="inline-flex items-center rounded-full bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                Tambah Produk Pertama
            </a>
        </div>
    @else
        <div class="overflow-x-auto rounded-2xl border border-rose-100 bg-white shadow-sm">
            <table class="min-w-full text-sm">
                <thead class="bg-rose-50/80">
                    <tr class="text-left text-rose-500">
                        <th class="px-4 py-3 font-semibold">Produk</th>
                        <th class="px-4 py-3 font-semibold">Harga</th>
                        <th class="px-4 py-3 font-semibold">Stok</th>
                        <th class="px-4 py-3 font-semibold">Kategori</th>
                        <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-t border-rose-50 hover:bg-rose-50/40">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($product->image_path ?? false)
                                        <img src="{{ asset('storage/'.$product->image_path) }}"
                                             class="h-10 w-10 rounded-xl object-cover border border-rose-100">
                                    @endif
                                    <div>
                                        <div class="font-semibold text-rose-900 text-sm">
                                            {{ $product->name }}
                                        </div>
                                        <div class="text-xs text-rose-400">
                                            {{ $product->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-rose-900">
                                Rp {{ number_format($product->price,0,',','.') }}
                            </td>
                            <td class="px-4 py-3 text-rose-700">
                                {{ $product->stock ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-rose-700">
                                {{ $product->category ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('seller.products.edit', $product) }}"
                                       class="rounded-full border border-rose-200 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('seller.products.destroy', $product) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-full border border-rose-200 px-3 py-1 text-xs font-medium text-rose-500 hover:bg-rose-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
