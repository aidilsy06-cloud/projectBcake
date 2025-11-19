@extends('layouts.app')

@section('title','Tambah Produk — B’cake Seller')

@push('head')
<style>
    .form-label{
        @apply block text-sm font-medium text-rose-900 mb-1;
    }
    .form-input{
        @apply w-full rounded-xl border border-rose-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 bg-white/90;
    }
    .preview-box{
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #f9c6d6;
        background: #fff5fa;
        height: 180px;
        display:flex;
        align-items:center;
        justify-content:center;
    }
</style>
@endpush

@section('content')
<div class="page-bg min-h-screen py-10">
  <div class="max-w-3xl mx-auto px-4 md:px-8">

    {{-- FLASH WARNING --}}
    @if(session('warning'))
      <div class="mb-5 bg-amber-100 border border-amber-300 text-amber-900 px-4 py-3 rounded-xl text-sm">
        {{ session('warning') }}
      </div>
    @endif

    <h1 class="text-2xl md:text-3xl font-semibold text-rose-900 mb-2">
      Tambah Produk Baru ✨
    </h1>
    <p class="text-sm text-rose-500 mb-6">
      Lengkapi detail produk agar tampil manis di katalog tokomu 🍰
    </p>

    <form action="{{ route('seller.products.store') }}" method="POST"
          class="bg-white/80 rounded-2xl p-6 shadow-soft space-y-5">
      @csrf

      {{-- NAMA PRODUK --}}
      <div>
        <label class="form-label">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-input">
        @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- HARGA --}}
      <div>
        <label class="form-label">Harga (Rp)</label>
        <input type="number" name="price" value="{{ old('price') }}" class="form-input">
        @error('price')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- DESKRIPSI --}}
      <div>
        <label class="form-label">Deskripsi Singkat</label>
        <textarea name="short_description" rows="3" class="form-input">{{ old('short_description') }}</textarea>
        @error('short_description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- URL GAMBAR + PREVIEW --}}
      <div>
        <label class="form-label">URL Gambar (opsional)</label>
        <input type="text" id="imgInput" name="image_url" value="{{ old('image_url') }}"
               class="form-input" placeholder="https://…"
               oninput="document.getElementById('previewImg').src=this.value">

        <div class="preview-box mt-3">
          <img id="previewImg"
               src="{{ old('image_url') ?: asset('image/cake.jpg') }}"
               alt="Preview"
               class="h-full object-cover rounded-lg">
        </div>

        @error('image_url')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- BUTTONS --}}
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
