@extends('layouts.app')

@section('title','Tambah Produk — B’cake Seller')

@section('content')
<div class="page-bg min-h-screen py-10">
  <div class="max-w-3xl mx-auto px-4 md:px-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-rose-900 mb-2">
      Tambah Produk Baru
    </h1>
    <p class="text-sm text-rose-500 mb-6">
      Lengkapi detail produk agar tampil manis di katalog tokomu 🍰
    </p>

    <form action="{{ route('seller.products.store') }}" method="POST" class="bg-white/80 rounded-2xl p-6 shadow-soft space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-rose-900 mb-1">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name') }}"
               class="w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300">
        @error('name')
          <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-rose-900 mb-1">Harga (Rp)</label>
        <input type="number" name="price" value="{{ old('price') }}"
               class="w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300">
        @error('price')
          <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-rose-900 mb-1">Deskripsi Singkat</label>
        <textarea name="short_description" rows="3"
                  class="w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300">{{ old('short_description') }}</textarea>
        @error('short_description')
          <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-rose-900 mb-1">URL Gambar (opsional)</label>
        <input type="text" name="image_url" value="{{ old('image_url') }}"
               class="w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300"
               placeholder="https://…">
        @error('image_url')
          <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between pt-4">
        <a href="{{ route('seller.products.index') }}"
           class="text-sm text-rose-500 hover:text-rose-700">
          ← Kembali ke katalog
        </a>

        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-rose-600 to-amber-400 text-white text-sm font-medium px-6 py-2.5 shadow-lg hover:scale-[1.02] transition">
          Simpan Produk
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
