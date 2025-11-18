@extends('layouts.app')
@section('title','Dashboard Admin — B’cake')

@section('content')
<div class="space-y-8">

  {{-- === Judul Utama === --}}
  <div>
    <h1 class="text-3xl font-bold text-bcake-bitter">Dashboard Admin</h1>
    <p class="text-gray-500 text-sm mt-1">Pantau aktivitas dan data sistem B’cake dengan cepat 🍰</p>
  </div>

  {{-- === Statistik Card === --}}
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <div class="bg-white rounded-2xl border border-bcake-truffle/10 shadow-sm p-6">
      <div class="text-sm text-gray-500">Total Produk</div>
      <div class="text-3xl font-bold mt-1 text-bcake-wine">{{ $stats['total_products'] ?? 0 }}</div>
      <p class="text-xs text-gray-400 mt-2">Jumlah seluruh produk aktif di sistem</p>
    </div>

    <div class="bg-white rounded-2xl border border-bcake-truffle/10 shadow-sm p-6">
      <div class="text-sm text-gray-500">Total Pengguna</div>
      <div class="text-3xl font-bold mt-1 text-bcake-wine">{{ $stats['users'] ?? 0 }}</div>
      <p class="text-xs text-gray-400 mt-2">Total akun terdaftar di B’cake</p>
    </div>

    <div class="bg-white rounded-2xl border border-bcake-truffle/10 shadow-sm p-6">
      <div class="text-sm text-gray-500">Pesanan (Coming Soon)</div>
      <div class="text-3xl font-bold mt-1 text-bcake-wine">0</div>
      <p class="text-xs text-gray-400 mt-2">Fitur order tracking segera hadir</p>
    </div>
  </div>

  {{-- === Aksi Cepat === --}}
  <div class="bg-white rounded-2xl border border-bcake-truffle/10 shadow-sm p-6">
    <h2 class="text-lg font-semibold mb-4 text-bcake-bitter">Aksi Cepat</h2>
    <div class="flex flex-wrap gap-3">
      {{-- primary: produk --}}
      <a href="{{ route('admin.products.index') }}"
         class="px-4 py-2 rounded-xl bg-bcake-wine text-white hover:opacity-90">
        Kelola Produk
      </a>

      {{-- baru: toko --}}
      <a href="{{ route('admin.stores.index') }}"
         class="px-4 py-2 rounded-xl border border-bcake-wine text-bcake-wine hover:bg-rose-50">
        Kelola Toko
      </a>

      {{-- user --}}
      <a href="{{ route('admin.users.index') }}"
         class="px-4 py-2 rounded-xl border border-bcake-wine text-bcake-wine hover:bg-rose-50">
        Kelola User
      </a>

      {{-- landing --}}
      <a href="{{ route('home') }}"
         class="px-4 py-2 rounded-xl border hover:bg-rose-50">
        Lihat Landing
      </a>
    </div>
  </div>

  {{-- === Data Ringkasan === --}}
  <div class="grid lg:grid-cols-2 gap-6">
    {{-- Tabel User --}}
    <div class="bg-white rounded-2xl border border-bcake-truffle/10 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b border-bcake-truffle/10">
        <h3 class="font-semibold text-bcake-bitter">Pengguna Terbaru</h3>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-bcake-wine hover:underline">Lihat Semua</a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-rose-50 text-gray-700">
            <tr>
              <th class="px-4 py-2 text-left">Nama</th>
              <th class="px-4 py-2 text-left">Email</th>
              <th class="px-4 py-2 text-left">Role</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users ?? [] as $user)
              <tr class="border-t">
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 rounded text-xs bg-rose-100 text-bcake-wine">
                    {{ $user->role ?? 'buyer' }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada data pengguna</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Tabel Produk --}}
    <div class="bg-white rounded-2xl border border-bcake-truffle/10 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b border-bcake-truffle/10">
        <h3 class="font-semibold text-bcake-bitter">Produk Terbaru</h3>
        <a href="{{ route('admin.products.index') }}" class="text-sm text-bcake-wine hover:underline">Lihat Semua</a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-rose-50 text-gray-700">
            <tr>
              <th class="px-4 py-2 text-left">Nama</th>
              <th class="px-4 py-2 text-left">Harga</th>
              <th class="px-4 py-2 text-left">Gambar</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products ?? [] as $product)
              <tr class="border-t">
                <td class="px-4 py-2">{{ $product->name }}</td>
                <td class="px-4 py-2">Rp {{ number_format($product->price,0,',','.') }}</td>
                <td class="px-4 py-2">
                  @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="gambar" class="h-8 w-8 rounded object-cover">
                  @else
                    <span class="text-xs text-gray-400">-</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada produk</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
