@extends('layouts.app')

@section('title','Daftar Toko — B’cake')

@push('head')
<style>
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }
  .card-soft{
    background: linear-gradient(145deg,#fff,#fff6f7 60%,#ffecef 100%);
    box-shadow:0 18px 40px rgba(54,35,32,.10);
  }
</style>
@endpush

@section('content')
<div class="page-bg min-h-screen py-10">
  <div class="max-w-7xl mx-auto px-4 md:px-8">

    <h1 class="text-3xl font-bold text-rose-900">Daftar Toko</h1>
    <p class="text-rose-600 mt-1">Temukan toko-toko favoritmu 🍰</p>

    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

      @forelse($stores as $store)
        <div class="card-soft p-5 rounded-2xl">
          <div class="flex items-center gap-3">
            <img src="{{ $store->logo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($store->name).'&background=ffe9f0&color=890524' }}"
                 class="w-14 h-14 rounded-xl object-cover"
                 alt="Logo">

            <div>
              <div class="font-semibold text-rose-900">{{ $store->name }}</div>
              <div class="text-xs text-gray-500">{{ $store->tagline ?? 'Sweet & Elegant' }}</div>
            </div>
          </div>

          <div class="mt-4 flex justify-between items-center">
            <span class="text-xs text-gray-500">
              {{ $store->products_count ?? 0 }} produk
            </span>

            <a href="{{ route('stores.show', $store->slug) }}"
               class="px-4 py-2 rounded-full bg-rose-600 text-white text-sm hover:bg-rose-700">
              Lihat Toko →
            </a>
          </div>
        </div>
      @empty
        <div class="col-span-full text-center text-gray-500 py-10">
          Belum ada toko terdaftar.
        </div>
      @endforelse

    </div>
  </div>
</div>
@endsection
