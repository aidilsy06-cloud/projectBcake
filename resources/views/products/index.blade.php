@extends('layouts.app')

@section('title', 'Katalog — B’cake')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="font-display text-3xl mb-6">Katalog Produk</h1>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $p)
        <a href="{{ route('products.show', $p->slug) }}"
            class="rounded-xl2 bg-white shadow-soft border border-bcake-truffle/10 overflow-hidden">
            <img src="{{ $p->image_url }}" class="h-44 w-full object-cover" alt="{{ $p->name }}">
            <div class="p-4">
                <div class="font-medium">{{ $p->name }}</div>
                <div class="mt-3 font-semibold text-bcake-wine">Rp {{ number_format($p->price,0,',','.') }}</div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</section>
@endsection
