@extends('layouts.app')
@section('title','Dashboard Pembeli — B’cake')

@section('content')
<div class="grid gap-6">
  <h1 class="text-2xl font-semibold text-bcake-bitter">Dashboard Pembeli</h1>

  <div class="rounded-xl2 border p-5 bg-white">
    <div class="text-gray-600">Selamat datang di B’cake! Lihat katalog untuk mulai belanja.</div>
    <a href="{{ route('products.index') }}" class="mt-4 inline-flex px-4 py-2 rounded-xl bg-bcake-wine text-white">Lihat Katalog</a>
  </div>
</div>
@endsection
