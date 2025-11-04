@extends('layouts.app')
@section('title', 'Bantuan — B’cake')
@section('content')
<section class="space-y-4">
  <h1 class="font-display text-3xl">Bantuan</h1>

  <div class="rounded-xl2 border border-bcake-truffle/10 bg-white p-5 shadow-soft space-y-3">
    <details class="group">
      <summary class="cursor-pointer font-medium text-bcake-bitter group-open:text-bcake-wine">
        Cara memesan
      </summary>
      <div class="mt-2 text-bcake-truffle">
        Buka <a href="{{ route('products.index') }}" class="text-bcake-wine underline">katalog</a>,
        pilih produk, lalu “Tambah ke Keranjang”. Lanjutkan ke checkout.
      </div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium text-bcake-bitter group-open:text-bcake-wine">
        Metode pembayaran
      </summary>
      <div class="mt-2 text-bcake-truffle">Transfer bank & e-wallet (DANA/OVO/Gopay).</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium text-bcake-bitter group-open:text-bcake-wine">
        Pengantaran
      </summary>
      <div class="mt-2 text-bcake-truffle">Kirim instan/local courier, estimasi 30–90 menit (area kota).</div>
    </details>
  </div>
</section>
@endsection
