@extends('layouts.app')
@section('title', 'Edit Profil Toko — B’cake')

@push('head')
<style>
  .shadow-soft{box-shadow:0 20px 40px rgba(137,5,36,.08)}
</style>
@endpush

@section('content')
<div class="bg-rose-50/60 min-h-[60vh]">
  <div class="max-w-5xl mx-auto px-4 md:px-6 py-8 md:py-10">

    {{-- Back link --}}
    <a href="{{ route('seller.store.show') }}"
       class="inline-flex items-center text-sm text-rose-600 hover:text-rose-800 mb-4">
      ← Kembali ke Toko Saya
    </a>

    {{-- Card utama --}}
    <div class="rounded-3xl bg-white border border-rose-100/80 shadow-soft px-5 md:px-8 py-7 space-y-7">

      {{-- Header --}}
      <div class="flex items-start gap-3">
        <div
          class="h-9 w-9 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500">
          ✨
        </div>
        <div>
          <h1 class="text-lg md:text-xl font-semibold text-rose-900">
            Edit Profil Toko
          </h1>
          <p class="text-sm text-rose-600/80">
            Sesuaikan nama, deskripsi, dan tampilan toko agar lebih menarik bagi pembeli.
          </p>
        </div>
      </div>

      {{-- Form --}}
      <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- =================== DATA UTAMA =================== --}}
        <div class="grid md:grid-cols-2 gap-6">
          {{-- Kolom kiri --}}
          <div class="space-y-4">
            {{-- Nama toko --}}
            <div>
              <label class="block text-sm font-medium text-rose-900 mb-1.5">
                Nama Toko
              </label>
              <input type="text" name="name"
                     value="{{ old('name', $store->name) }}"
                     class="w-full rounded-2xl border border-rose-200/80 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-400">
            </div>

            {{-- Tagline --}}
            <div>
              <label class="block text-sm font-medium text-rose-900 mb-1.5">
                Tagline
              </label>
              <input type="text" name="tagline"
                     value="{{ old('tagline', $store->tagline ?? 'Sweet & Elegant') }}"
                     class="w-full rounded-2xl border border-rose-200/80 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-400">
            </div>

            {{-- Deskripsi --}}
            <div>
              <label class="block text-sm font-medium text-rose-900 mb-1.5">
                Deskripsi
              </label>
              <textarea name="description" rows="4"
                        placeholder="Ceritakan singkat tentang toko dan produk unggulan..."
                        class="w-full rounded-2xl border border-rose-200/80 px-3 py-2.5 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-400">{{ old('description', $store->description) }}</textarea>
            </div>
          </div>

          {{-- Kolom kanan --}}
          <div class="space-y-4">
            {{-- Slug --}}
            <div>
              <label class="block text-sm font-medium text-rose-900 mb-1.5">
                Slug (URL)
              </label>
              <input type="text" name="slug"
                     value="{{ old('slug', $store->slug) }}"
                     class="w-full rounded-2xl border border-rose-200/80 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-400">
              <p class="mt-1 text-[11px] text-rose-500/80">
                Tampil di URL publik sebagai:
                <span class="font-mono text-[11px] text-rose-700">/store/&lt;slug&gt;</span>
              </p>
            </div>

            {{-- Tip kecil --}}
            <div class="rounded-2xl bg-rose-50/70 border border-rose-100 px-4 py-3 text-[11px] text-rose-700 leading-relaxed">
              Pilih nama dan slug yang singkat, mudah diingat, dan konsisten dengan brand toko kamu.
            </div>
          </div>
        </div>

        {{-- =================== LOGO & BANNER =================== --}}
        <div class="border-t border-rose-100 pt-6 space-y-4">
          <h2 class="text-sm font-semibold text-rose-900">
            Logo &amp; Banner
          </h2>

          <div class="grid md:grid-cols-2 gap-6">

            {{-- === LOGO === --}}
            <div class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-rose-900 mb-1.5">
                  Logo
                </label>
                <input type="file" name="logo"
                       class="block w-full text-xs text-rose-700 file:mr-3 file:rounded-xl file:border-0 file:bg-rose-600 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:file:bg-rose-700">
                <p class="mt-1 text-[11px] text-rose-500/80">
                  JPG/PNG/WEBP • Maks 2 MB • Disarankan rasio persegi (1:1).
                </p>
              </div>

              <div class="rounded-2xl border border-rose-100 bg-rose-50/60 px-3 py-3 flex items-center gap-3">
                <div class="h-14 w-14 rounded-2xl bg-white overflow-hidden flex items-center justify-center">
                  <img src="{{ $store->logo_url ?? ($store->logo ? asset('storage/'.$store->logo) : asset('image/logo_bcake.jpg')) }}"
                       alt="Logo preview"
                       class="h-full w-full object-cover">
                </div>
                <div class="text-[11px] text-rose-700/90 leading-snug">
                  <p class="font-semibold mb-0.5">Logo preview</p>
                  <p>Ditampilkan di daftar toko dan header halaman toko.</p>
                </div>
              </div>
            </div>

            {{-- === BANNER === --}}
            <div class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-rose-900 mb-1.5">
                  Banner
                </label>
                <input type="file" name="banner"
                       class="block w-full text-xs text-rose-700 file:mr-3 file:rounded-xl file:border-0 file:bg-rose-600 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:file:bg-rose-700">
                <p class="mt-1 text-[11px] text-rose-500/80">
                  Disarankan rasio 16:9, lebar ≥ 1280px untuk tampilan yang tajam.
                </p>
              </div>

              <div class="rounded-2xl border border-rose-100 bg-rose-50/60 px-3 py-3">
                <div class="h-24 md:h-28 rounded-2xl bg-white overflow-hidden flex items-center justify-center">
                  @if($store->banner_url ?? $store->banner ?? false)
                    <img src="{{ $store->banner_url ?? asset('storage/'.$store->banner) }}"
                         alt="Banner preview"
                         class="h-full w-full object-cover">
                  @else
                    <span class="text-[11px] text-rose-500/80">
                      Banner preview akan tampil di sini setelah kamu mengunggah gambar.
                    </span>
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- =================== TOMBOL AKSI =================== --}}
        <div class="flex items-center justify-end gap-3 pt-2">
          <a href="{{ route('seller.store.show') }}"
             class="px-4 py-2.5 rounded-full text-sm border border-rose-100 text-rose-700 hover:bg-rose-50">
            Batal
          </a>
          <button type="submit"
                  class="px-5 py-2.5 rounded-full text-sm font-semibold text-white bg-rose-700 hover:bg-rose-800 shadow-soft">
            Simpan Perubahan
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection
