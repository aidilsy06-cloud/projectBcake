@extends('layouts.app')

@section('title', 'Tambah Produk — B’cake Seller')

@section('content')
<div class="bg-rose-50/80 py-8">
    <div class="max-w-4xl mx-auto px-4">
        {{-- Header kecil --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-rose-900">Tambah Produk</h1>
            <p class="text-sm text-rose-500">
                Isi detail kue kamu agar tampil cantik di katalog B’cake.
            </p>
        </div>

        {{-- Card form --}}
        <div class="bg-white rounded-3xl shadow-[0_18px_40px_rgba(148,27,73,.12)] border border-rose-100 px-6 md:px-10 py-8">
            <form action="{{ route('seller.products.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-5">
                @csrf

                {{-- Nama Produk --}}
                <div>
                    <label class="block text-sm font-semibold text-rose-900 mb-1">
                        Nama Produk
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-2xl border border-rose-200/70 px-4 py-2.5 text-sm text-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-400"
                        placeholder="Contoh: Custom Cake Ulang Tahun Cherry"
                    >
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-semibold text-rose-900 mb-1">
                        Harga (Rp)
                    </label>
                    <input
                        type="number"
                        name="price"
                        value="{{ old('price') }}"
                        class="w-full rounded-2xl border border-rose-200/70 px-4 py-2.5 text-sm text-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-400"
                        placeholder="Contoh: 150000"
                        min="0"
                    >
                    @error('price')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi Singkat --}}
                <div>
                    <label class="block text-sm font-semibold text-rose-900 mb-1">
                        Deskripsi Singkat
                    </label>
                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-2xl border border-rose-200/70 px-4 py-2.5 text-sm text-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-400"
                        placeholder="Ceritakan rasa, varian, ukuran, atau catatan khusus untuk kue ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Gambar --}}
                <div>
                    <label class="block text-sm font-semibold text-rose-900 mb-1">
                        Upload Gambar
                    </label>
                    <p class="text-[11px] text-rose-400 mb-2">
                        Format: JPG, JPEG, PNG, WEBP &mdash; maks. 2 MB.
                    </p>
                    <input
                        type="file"
                        name="image"
                        class="block w-full text-sm text-rose-900
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-full file:border-0
                               file:text-sm file:font-semibold
                               file:bg-rose-100 file:text-rose-700
                               hover:file:bg-rose-200
                               rounded-2xl border border-rose-200/70 bg-rose-50/60 px-3 py-2"
                    >
                    @error('image')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- (Opsional) Kategori / lainnya, kalau kamu mau tambahkan di sini --}}

                {{-- Tombol aksi --}}
                <div class="flex items-center justify-between pt-3">
                    <a href="{{ route('seller.products.index') }}"
                       class="text-sm text-rose-500 hover:text-rose-700">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full px-8 py-2.5 text-sm font-semibold text-white
                               bg-gradient-to-r from-rose-600 via-rose-500 to-amber-400
                               shadow-[0_14px_30px_rgba(244,63,94,.35)]
                               hover:brightness-105 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:ring-offset-1">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
