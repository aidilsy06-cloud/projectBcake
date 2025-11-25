@extends('layouts.app')

@section('title', 'Edit Produk — B’cake Seller')

@section('content')
<section class="bg-rose-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl px-6 py-8 space-y-6">

            {{-- HEADER --}}
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-semibold text-rose-900">Edit Produk</h1>
                    <p class="text-sm text-rose-500 mt-1">
                        Perbarui informasi produk di katalog toko kamu.
                    </p>
                </div>
                <a href="{{ route('seller.products.index') }}"
                   class="text-xs text-rose-500 hover:text-rose-700">
                    ← Kembali ke daftar produk
                </a>
            </div>

            {{-- ERROR VALIDATION --}}
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-2xl px-4 py-3">
                    <p class="font-semibold mb-1">Ada beberapa error:</p>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('seller.products.update', $product) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-5">
                @csrf
                @method('PUT')

                {{-- NAMA PRODUK --}}
                <div>
                    <label class="block text-xs font-semibold text-rose-500 mb-1">
                        Nama Produk
                    </label>
                    <input type="text" name="name"
                           value="{{ old('name', $product->name) }}"
                           class="w-full rounded-2xl border border-rose-200 px-4 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
                </div>

                {{-- HARGA --}}
                <div>
                    <label class="block text-xs font-semibold text-rose-500 mb-1">
                        Harga (Rp)
                    </label>
                    <input type="number" name="price"
                           value="{{ old('price', $product->price) }}"
                           class="w-full rounded-2xl border border-rose-200 px-4 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
                </div>

                {{-- KATEGORI --}}
                <div>
                    <label class="block text-xs font-semibold text-rose-500 mb-1">
                        Kategori
                    </label>
                    <select name="category_id"
                            class="w-full rounded-2xl border border-rose-200 px-4 py-2.5 text-sm bg-white
                                   focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
                        <option value="">Pilih kategori…</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                    @selected(old('category_id', $product->category_id) == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- STOK --}}
                <div>
                    <label class="block text-xs font-semibold text-rose-500 mb-1">
                        Stok Produk
                    </label>
                    <input type="number" name="stock"
                           value="{{ old('stock', $product->stock) }}"
                           min="0"
                           class="w-full rounded-2xl border border-rose-200 px-4 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label class="block text-xs font-semibold text-rose-500 mb-1">
                        Deskripsi Produk
                    </label>
                    <textarea name="description" rows="4"
                              class="w-full rounded-2xl border border-rose-200 px-4 py-2.5 text-sm
                                     focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- GAMBAR --}}
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-rose-500 mb-1">
                        Gambar Produk
                    </label>

                    @if($product->image_url)
                        <div class="flex items-center gap-3">
                            <div class="h-20 w-20 rounded-2xl overflow-hidden bg-rose-50 border border-rose-100">
                                <img src="{{ $product->image_url }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <p class="text-[11px] text-rose-400">
                                Gambar saat ini. Kamu bisa upload gambar baru untuk menggantinya.
                            </p>
                        </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <label class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-rose-100 text-rose-700 text-xs font-medium cursor-pointer hover:bg-rose-200">
                            Pilih file baru
                            <input type="file" name="image" class="hidden" accept="image/*">
                        </label>
                        <p class="text-[11px] text-rose-400">
                            Kosongkan jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG, WEBP — maks. 2 MB.
                        </p>
                    </div>
                </div>

                {{-- TOMBOL --}}
                <div class="pt-2 flex flex-wrap gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-full bg-rose-600 text-white text-sm font-semibold
                                   hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-300">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('seller.products.index') }}"
                       class="px-5 py-2.5 rounded-full border border-rose-200 text-rose-600 text-sm hover:bg-rose-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
