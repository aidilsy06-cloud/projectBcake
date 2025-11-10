@extends('layouts.app')
@section('title','Pilih Toko — B’cake')

@push('head')
<style>
  .card{background:#fff;border-radius:1.25rem;box-shadow:0 24px 48px rgba(137,5,36,.08)}
  .rose{background:#fff1f5}
  .btn{background:#890524;color:#fff;padding:.65rem 1rem;border-radius:.8rem;transition:.2s}
  .btn:hover{filter:brightness(.95);transform:translateY(-1px)}
</style>
@endpush

@section('content')
<div class="min-h-[60vh] rose/50 py-10">
  <div class="max-w-6xl mx-auto px-4">
    <h1 class="text-2xl md:text-3xl font-semibold text-[#362320] mb-6">🛍️ Pilih Toko untuk Belanja</h1>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
      @forelse($stores as $store)
        <div class="card p-5 text-center">
          <img
            src="{{ $store->logo ? asset('storage/'.$store->logo) : Vite::asset('resources/images/default-store.png') }}"
            alt="{{ $store->name }}"
            class="w-24 h-24 rounded-full object-cover mx-auto mb-3">

          <h2 class="text-lg font-semibold">{{ $store->name }}</h2>
          <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $store->description }}</p>

          <a class="btn inline-block" href="{{ route('buyer.stores.show',$store->slug) }}">Lihat Produk</a>
        </div>
      @empty
        <div class="col-span-full text-gray-500">Belum ada toko.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection
