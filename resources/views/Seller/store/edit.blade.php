@extends('layouts.app')
@section('title','Edit Toko — B’cake')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
  @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded-2xl border border-rose-200/60 shadow-soft p-6">
    <h1 class="text-xl font-semibold mb-4">Edit Profil Toko</h1>
    <form method="post" action="{{ route('seller.store.update') }}" enctype="multipart/form-data" class="space-y-4">
      @csrf @method('PUT')

      <div>
        <label class="block text-sm mb-1">Nama Toko</label>
        <input name="name" value="{{ old('name', $store->name) }}" class="w-full rounded-lg border-rose-200" required>
        @error('name')<p class="text-rose-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-sm mb-1">Slug (URL)</label>
        <input name="slug" value="{{ old('slug', $store->slug) }}" class="w-full rounded-lg border-rose-200" required>
        @error('slug')<p class="text-rose-600 text-sm mt-1">{{ $message }}</p>@enderror
        <p class="text-xs text-gray-500 mt-1">Contoh: <code>chels-bakery</code> → /store/chels-bakery (untuk rute publik jika diaktifkan).</p>
      </div>

      <div>
        <label class="block text-sm mb-1">Tagline</label>
        <input name="tagline" value="{{ old('tagline', $store->tagline) }}" class="w-full rounded-lg border-rose-200">
        @error('tagline')<p class="text-rose-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-sm mb-1">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full rounded-lg border-rose-200">{{ old('description', $store->description) }}</textarea>
        @error('description')<p class="text-rose-600 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm mb-1">Logo</label>
          <input type="file" name="logo" accept="image/*" class="w-full rounded-lg border-rose-200">
          @error('logo')<p class="text-rose-600 text-sm mt-1">{{ $message }}</p>@enderror
          @if($store->logo)
            <img src="{{ asset('storage/'.$store->logo) }}" class="mt-2 h-16 rounded-lg object-cover" alt="Logo">
          @endif
        </div>
        <div>
          <label class="block text-sm mb-1">Banner</label>
          <input type="file" name="banner" accept="image/*" class="w-full rounded-lg border-rose-200">
          @error('banner')<p class="text-rose-600 text-sm mt-1">{{ $message }}</p>@enderror
          @if($store->banner)
            <img src="{{ asset('storage/'.$store->banner) }}" class="mt-2 h-16 rounded-lg object-cover" alt="Banner">
          @endif
        </div>
      </div>

      <div class="flex items-center gap-3 pt-2">
        <a href="{{ route('seller.store.show') }}" class="px-4 py-2 rounded-lg border border-rose-200/70">Batal</a>
        <button class="px-4 py-2 rounded-lg bg-rose-700 text-white">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection
