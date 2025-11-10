@extends('layouts.app')
@section('title', $store->name.' — B’cake')

@push('head')
<style>
  .card{background:#fff;border-radius:1rem;box-shadow:0 24px 48px rgba(137,5,36,.08)}
  .btn{background:#890524;color:#fff;padding:.55rem .9rem;border-radius:.7rem;transition:.2s}
  .btn:hover{filter:brightness(.95);transform:translateY(-1px)}
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
  <div class="flex items-center gap-4 mb-8">
    <img src="{{ $store->logo ? asset('storage/'.$store->logo) : Vite::asset('resources/images/default-store.png') }}"
         class="w-16 h-16 rounded-full object-cover" alt="{{ $store->name }}">
    <div>
      <h1 class="text-2xl font-semibold text-[#890524]">{{ $store->name }}</h1>
      <p class="text-gray-600">{{ $store->description }}</p>
      <div class="mt-2">
        <a href="{{ route('buyer.stores.index') }}" class="text-[#890524] underline text-sm">← Kembali ke daftar toko</a>
      </div>
    </div>
  </div>

  @if($store->products->count())
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
      @foreach($store->products as $p)
        <div class="card p-4">
          <a href="{{ route('products.show', $p->slug ?? $p->id) }}">
            <img src="{{ $p->image_url ?? Vite::asset('resources/images/placeholder-product.jpg') }}"
                 class="w-full h-40 object-cover rounded-lg" alt="{{ $p->name }}">
          </a>
          <div class="mt-3">
            <a href="{{ route('products.show', $p->slug ?? $p->id) }}" class="font-medium line-clamp-1">
              {{ $p->name }}
            </a>
            <div class="text-[#890524] font-semibold mt-1">
              Rp {{ number_format($p->price ?? 0,0,',','.') }}
            </div>
          </div>
          <form method="post" action="{{ route('cart.add', $p->slug ?? $p->id) }}" class="mt-3">
            @csrf
            <button class="btn w-full">Tambah ke Keranjang</button>
          </form>
        </div>
      @endforeach
    </div>
  @else
    <div class="text-gray-500">Belum ada produk di toko ini.</div>
  @endif
</div>
@endsection
