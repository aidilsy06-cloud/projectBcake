@extends('layouts.app')

@section('title', 'Tambah Produk — B’cake')

@section('content')
<section class="bg-rose-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-6">
            <a href="{{ route('seller.products.index') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-full text-sm bg-white shadow border border-rose-100 text-rose-600 hover:bg-rose-50">
                ← Kembali ke daftar produk
            </a>

            <h1 class="mt-4 text-2xl font-semibold text-rose-900">
                Tambah Produk Baru
            </h1>
            <p class="text-sm text-rose-500 mt-1">
                Lengkapi detail kue yang ingin kamu tampilkan di katalog B’cake.
            </p>
        </div>

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())
            <div class="mb-4 rounded-2xl bg-rose-100 border border-rose-200 text-rose-800 px-4 py-3 text-sm">
                <div class="font-semibold mb-1">Oops, ada yang perlu dicek lagi:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl px-6 py-6">
            <form action="{{ route('seller.products.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-5">
                @csrf

                {{-- NAMA PRODUK --}}
                <div>
                    <label class="block text-sm font-medium text-rose-900 mb-1">
                        Nama Produk
                    </label>
                    <input type="text" name="name"
                           value="{{ old('name') }}"
                           placeholder="Contoh: Custom Cake Ulang Tahun Cherry"
                           class="w-full rounded-2xl border border-rose-200 bg-rose-50/60 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white">
                </div>

                {{-- HARGA --}}
                <div>
                    <label class="block text-sm font-medium text-rose-900 mb-1">
                        Harga (Rp)
                    </label>
                    <input type="number" name="price"
                           value="{{ old('price') }}"
                           placeholder="Contoh: 150000"
                           min="0"
                           class="w-full rounded-2xl border border-rose-200 bg-rose-50/60 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white">
                </div>

                {{-- KATEGORI + STOK --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    {{-- KATEGORI --}}
                    <div>
                        <label class="block text-sm font-medium text-rose-900 mb-1">
                            Kategori
                        </label>
                        <select name="category_id"
                                class="w-full rounded-2xl border border-rose-200 bg-rose-50/60 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white">
                            <option value="">— Pilih kategori —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STOK --}}
                    <div>
                        <label class="block text-sm font-medium text-rose-900 mb-1">
                            Stok
                        </label>
                        <input type="number" name="stock"
                               value="{{ old('stock', 0) }}"
                               min="0"
                               class="w-full rounded-2xl border border-rose-200 bg-rose-50/60 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white">
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label class="block text-sm font-medium text-rose-900 mb-1">
                        Deskripsi Singkat
                    </label>
                    <textarea name="description" rows="4"
                              placeholder="Ceritakan rasa, varian, ukuran, atau catatan khusus untuk kue ini…"
                              class="w-full rounded-2xl border border-rose-200 bg-rose-50/60 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white">{{ old('description') }}</textarea>
                </div>

                {{-- UPLOAD GAMBAR --}}
                <div>
                    <label class="block text-sm font-medium text-rose-900 mb-1">
                        Upload Gambar
                    </label>
                    <p class="text-xs text-rose-400 mb-2">
                        Format: JPG, JPEG, PNG, WEBP — maks. 2 MB.
                    </p>

                    <input type="file" name="image"
                           class="block w-full text-sm text-rose-900
                                  file:mr-3 file:py-2.5 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-rose-500 file:text-white
                                  hover:file:bg-rose-600">
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-rose-600 text-white px-6 py-2.5 text-sm font-semibold shadow-md hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-300">
                        Simpan Produk
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
