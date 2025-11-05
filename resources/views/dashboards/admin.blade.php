@extends('layouts.app')
@section('title','Dashboard Admin — B’cake')

@section('content')
<div class="grid gap-6">
  <h1 class="text-2xl font-semibold text-bcake-bitter">Dashboard Admin</h1>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="rounded-xl2 border p-5 bg-white">
      <div class="text-sm text-gray-500">Total Produk</div>
      <div class="text-3xl font-bold mt-1">{{ $stats['total_products'] ?? 0 }}</div>
    </div>
    <div class="rounded-xl2 border p-5 bg-white">
      <div class="text-sm text-gray-500">Total User</div>
      <div class="text-3xl font-bold mt-1">{{ $stats['users'] ?? 0 }}</div>
    </div>
  </div>

  <div class="rounded-xl2 border p-5 bg-white">
    <div class="font-medium mb-2">Aksi Cepat</div>
    <div class="flex gap-3">
      <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl bg-bcake-wine text-white">Kelola Produk</a>
      <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl border">Lihat Landing</a>
    </div>
  </div>
</div>
@endsection
