@extends('layouts.app')
@section('title','Edit Toko — B’cake')

@push('head')
<style>
  :root{
    --wine:#890524; --deep:#57091d; --cocoa:#362320;
    --glass: rgba(255,255,255,.65);
  }
  .glass-card{
    background: var(--glass);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(244,63,94,.18);
    box-shadow:
      0 30px 60px rgba(54,35,32,.12),
      inset 0 1px 0 rgba(255,255,255,.5);
  }
  .hero-soft{
    background:
      radial-gradient(900px 420px at 85% -10%, #ffe9f0, transparent 60%),
      radial-gradient(700px 360px at 10% -5%, #fff1f5, transparent 55%),
      linear-gradient(180deg,#fff,#fff8f2);
  }
  .btn-wine{
    background: linear-gradient(135deg, var(--deep), var(--wine));
    color:#fff; border-radius: .8rem; padding:.7rem 1.1rem;
    box-shadow: 0 10px 22px rgba(137,5,36,.18);
    transition:.18s ease;
  }
  .btn-wine:hover{ filter:brightness(1.05); transform: translateY(-1px); }
  .field{ @apply w-full rounded-xl border border-rose-200/70 bg-white/90 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-300; }
  .label{ @apply block text-sm font-medium text-rose-900/80 mb-1; }
  .hint{ @apply text-xs text-gray-500 mt-1; }
</style>
@endpush

@section('content')
<div class="hero-soft">
  <div class="max-w-4xl mx-auto px-4 md:px-8 py-8 md:py-12">

    {{-- Flash success --}}
    @if(session('success'))
      <div class="mb-6 rounded-xl bg-green-50/90 border border-green-200 px-4 py-3 text-green-700">
        {{ session('success') }}
      </div>
    @endif

    {{-- Header mini --}}
    <div class="mb-6 flex items-center gap-3">
      <div class="h-10 w-10 rounded-xl bg-white shadow ring-1 ring-rose-200/60 grid place-items-center">🛠️</div>
      <div>
        <h1 class="text-xl md:text-2xl font-semibold text-[var(--cocoa)]">Edit Profil Toko</h1>
        <p class="text-sm text-rose-900/70">Perbarui identitas toko, gambar, dan deskripsi.</p>
      </div>
    </div>

    {{-- CARD FORM --}}
    <div class="glass-card rounded-2xl p-5 md:p-7">
      <form method="POST" action="{{ route('seller.store.update') }}" enctype="multipart/form-data" class="space-y-6" id="storeEditForm">
        @csrf
        @method('PUT')

        {{-- Row: Nama + Slug --}}
        <div class="grid md:grid-cols-2 gap-5">
          <div>
            <label class="label">Nama Toko</label>
            <input name="name" value="{{ old('name', $store->name) }}" class="field" required placeholder="Mis. B’cake Seller Store">
            @error('name') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label class="label">Slug (URL)</label>
            <input id="slug" name="slug" value="{{ old('slug', $store->slug) }}" class="field" required placeholder="mis. bcake-seller">
            <p class="hint">Akan tampil di URL publik: <code>/store/&lt;slug&gt;</code></p>
            @error('slug') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>
        </div>

        {{-- Tagline --}}
        <div>
          <label class="label">Tagline</label>
          <input name="tagline" value="{{ old('tagline', $store->tagline) }}" class="field" placeholder="Sweet & Elegant">
          @error('tagline') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
          <label class="label">Deskripsi</label>
          <textarea name="description" rows="4" class="field" placeholder="Ceritakan singkat tentang toko dan produk unggulan…">{{ old('description', $store->description) }}</textarea>
          @error('description') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Gambar: Logo + Banner --}}
        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="label">Logo</label>
            <input type="file" id="logo" name="logo" accept="image/*" class="field">
            @error('logo') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
            <div class="mt-3 flex items-center gap-3">
              <img id="logoPreview"
                   src="{{ $store->logo ? asset('storage/'.$store->logo) : asset('image/Cake Pinky.jpg') }}"
                   class="h-16 w-16 rounded-xl object-cover ring-1 ring-rose-200/60 shadow"
                   alt="Logo preview">
              <div class="text-xs text-gray-600">
                JPG/PNG/WEBP • Maks 2 MB<br> Disarankan rasio persegi (1:1)
              </div>
            </div>
          </div>

          <div>
            <label class="label">Banner</label>
            <input type="file" id="banner" name="banner" accept="image/*" class="field">
            @error('banner') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
            <div class="mt-3 rounded-xl overflow-hidden ring-1 ring-rose-200/60 shadow">
              <img id="bannerPreview"
                   src="{{ $store->banner ? asset('storage/'.$store->banner) : asset('image/Cake Softpink.jpg') }}"
                   class="w-full h-40 object-cover"
                   alt="Banner preview">
            </div>
            <p class="hint">Disarankan rasio 16:9, ukuran lebar ≥ 1280px.</p>
          </div>
        </div>

        {{-- Actions --}}
        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
          <a href="{{ route('seller.store.show') }}" class="px-5 py-2.5 rounded-xl border border-rose-200/70 bg-white hover:bg-rose-50 text-center">Batal</a>
          <button type="submit" class="btn-wine px-6 py-2.5">Simpan Perubahan</button>
        </div>
      </form>
    </div>

    {{-- Kembali --}}
    <div class="mt-6">
      <a href="{{ route('seller.store.show') }}" class="text-rose-700 hover:underline">← Kembali ke Toko Saya</a>
    </div>
  </div>
</div>
@endsection

@push('head')
<script>
  // helper slugify sederhana
  function slugify(text){
    return text
      .toString()
      .normalize('NFKD')                 // handle aksen
      .replace(/[^\w\s-]/g,'')           // buang simbol
      .trim()
      .replace(/\s+/g,'-')               // spasi -> dash
      .replace(/-+/g,'-')                // dash ganda -> tunggal
      .toLowerCase();
  }
  document.addEventListener('DOMContentLoaded', () => {
    const nameEl = document.querySelector('input[name="name"]');
    const slugEl = document.getElementById('slug');

    // auto generate slug saat user mengetik nama (hanya jika slug belum disentuh)
    let slugDirty = false;
    slugEl.addEventListener('input', () => slugDirty = true);
    if (nameEl && slugEl){
      nameEl.addEventListener('input', () => {
        if (!slugDirty) slugEl.value = slugify(nameEl.value);
      });
    }

    // live preview logo & banner
    const bindPreview = (inputId, imgId) => {
      const input = document.getElementById(inputId);
      const img   = document.getElementById(imgId);
      if (!input || !img) return;
      input.addEventListener('change', (e) => {
        const f = e.target.files && e.target.files[0];
        if (!f) return;
        const url = URL.createObjectURL(f);
        img.src = url;
      });
    };
    bindPreview('logo','logoPreview');
    bindPreview('banner','bannerPreview');
  });
</script>
@endpush
