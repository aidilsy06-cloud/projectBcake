@extends('layouts.app')
@section('title','Produk — B’cake Seller')

@section('content')
<div class="max-w-5xl mx-auto py-14 text-center text-gray-700">
  <h1 class="text-2xl font-semibold text-rose-900 mb-3">Produk Saya</h1>
  <p class="text-gray-500">Halaman ini masih dalam pengembangan. Nantinya di sini kamu bisa menambah, edit, dan hapus produk.</p>
  <a href="{{ route('seller.dashboard') }}" class="inline-block mt-6 px-5 py-2.5 bg-rose-600 text-white rounded-full hover:bg-rose-700">← Kembali ke Dashboard</a>
</div>
@endsection
