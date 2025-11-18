@extends('layouts.app')
@section('title', $title.' — B’cake')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 space-y-6">

  {{-- Header --}}
  <div>
    <p class="text-xs uppercase tracking-[0.2em] text-rose-400">Kategori</p>
    <h1 class="text-3xl md:text-4xl font-bold text-bcake-bitter mt-1">
      {{ $title }}
    </h1>
    <p class="text-gray-500 text-sm mt-2 max-w-2xl">
      Temukan pilihan kue terbaik di kategori <span class="font-semibold">{{ $title }}</span>.
      Cocok untuk momen istimewa maupun camilan manis sehari-hari.
    </p>
  </div>

  {{-- Daftar produk --}}
  @if($products->count())
    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
      @foreach ($products as $product)
        <a href="{{ route('products.show', $product->id) }}"
           class="bg-white rounded-2xl shadow-sm border border-rose-100/60 overflow-hidden group hover:shadow-xl transition-all duration-200">
          <div class="aspect-[4/3] overflow-hidden">
            <img
              src="{{ $product->image_url ?? asset('storage/'.$product->image) }}"
              alt="{{ $product->name }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
            >
          </div>
          <div class="p-4 space-y-1">
            <h3 class="text-sm font-semibold text-bcake-bitter line-clamp-2">
              {{ $product->name }}
            </h3>
            <div class="text-xs text-gray-400">
              {{ $title }}
            </div>
            <div class="text-base font-bold text-bcake-wine mt-1">
              Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>
          </div>
        </a>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $products->links() }}
    </div>
  @else
    <div class="bg-white rounded-2xl p-8 text-center border border-dashed border-rose-200 text-gray-500">
      Belum ada produk di kategori ini. ✨
    </div>
  @endif

</div>
@endsection
