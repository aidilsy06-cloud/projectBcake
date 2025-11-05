@extends('layouts.app')
@section('title','Dashboard Penjual — B’cake')

@section('content')
<div class="grid gap-6">
  <h1 class="text-2xl font-semibold text-bcake-bitter">Dashboard Penjual</h1>

  <div class="grid sm:grid-cols-2 gap-4">
    <div class="rounded-xl2 border p-5 bg-white">
      <div class="text-sm text-gray-500">Produk Saya</div>
      <div class="text-3xl font-bold mt-1">{{ $stats['my_products'] ?? 0 }}</div>
    </div>
  </div>

  <div class="rounded-xl2 border p-5 bg-white">
    <div class="font-medium mb-2">Aksi Cepat</div>
    <div class="flex gap-3">
      <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl bg-bcake-wine text-white">Tambah / Kelola Produk</a>
      <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl border">Kunjungi Toko</a>
    </div>
  </div>
</div>
@endsection
