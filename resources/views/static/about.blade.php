@extends('layouts.app')
@section('title', 'Tentang Kami — B’cake')
@section('content')
<section class="space-y-4">
  <h1 class="font-display text-3xl">Tentang B’cake</h1>
  <p class="text-bcake-truffle">
    B’cake adalah bakery lokal dengan fokus pada rasa elegan & estetika. Kami meracik
    <span class="font-medium text-bcake-wine">brownies truffle</span>, cupcake ceri, dan kue artisanal
    menggunakan bahan premium.
  </p>
  <div class="rounded-xl2 border border-bcake-truffle/10 bg-white p-5 shadow-soft">
    <h2 class="font-medium mb-2">Misi</h2>
    <ul class="list-disc ms-5 text-bcake-truffle/90">
      <li>Menyajikan dessert premium dengan harga ramah.</li>
      <li>Mendukung UMKM pastry lokal.</li>
      <li>Pengiriman cepat & aman.</li>
    </ul>
  </div>
</section>
@endsection
