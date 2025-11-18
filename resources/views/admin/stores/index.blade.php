@extends('layouts.app')

@section('title','Kelola Toko — Admin')

@push('head')
<style>
  :root{
    --wine:#890524;
    --rose:#ffe4e6;
    --cocoa:#362320;
  }
  .badge{
    display:inline-flex;
    align-items:center;
    padding:.15rem .6rem;
    font-size:.75rem;
    border-radius:999px;
  }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-[color:var(--cocoa)]">Kelola Toko</h1>
      <p class="text-sm text-gray-600 mt-1">
        Daftar seluruh toko yang terdaftar di B’cake.
      </p>
    </div>
    <a href="{{ route('admin.stores.create') }}"
       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-white"
       style="background:var(--wine);box-shadow:0 12px 30px rgba(137,5,36,.25)">
      + Tambah Toko
    </a>
  </div>

  @if (session('ok'))
    <div class="mb-4 rounded-lg px-4 py-3 text-sm bg-emerald-50 text-emerald-800 border border-emerald-100">
      {{ session('ok') }}
    </div>
  @endif

  @if (session('error'))
    <div class="mb-4 rounded-lg px-4 py-3 text-sm bg-rose-50 text-rose-800 border border-rose-100">
      {{ session('error') }}
    </div>
  @endif

  @if ($stores->isEmpty())
    <div class="rounded-2xl border border-dashed border-rose-200 bg-white px-6 py-10 text-center">
      <p class="text-gray-600 mb-2">Belum ada toko yang terdaftar.</p>
      <a href="{{ route('admin.stores.create') }}"
         class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-white"
         style="background:var(--wine);">
        + Tambah toko pertama
      </a>
    </div>
  @else
    <div class="overflow-x-auto bg-white rounded-2xl shadow-[0_18px_40px_rgba(54,35,32,.12)]">
      <table class="min-w-full text-sm">
        <thead class="bg-rose-50/70">
          <tr class="text-left text-xs font-semibold text-gray-600">
            <th class="px-5 py-3">#</th>
            <th class="px-5 py-3">Nama Toko</th>
            <th class="px-5 py-3">Pemilik</th>
            <th class="px-5 py-3">Kota</th>
            <th class="px-5 py-3">Dibuat</th>
            <th class="px-5 py-3 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-rose-50">
          @foreach ($stores as $store)
            @php
              // cari nama owner dari user_id (simple aja, karena datanya masih sedikit)
              $owner = \App\Models\User::find($store->user_id);
            @endphp
            <tr class="hover:bg-rose-50/40">
              <td class="px-5 py-3 align-top text-gray-500">
                {{ $loop->iteration + ($stores->currentPage()-1)*$stores->perPage() }}
              </td>
              <td class="px-5 py-3 align-top">
                <div class="font-medium text-[color:var(--cocoa)]">
                  {{ $store->name }}
                </div>
                <div class="text-xs text-gray-500">
                  {{ $store->slug ?? '—' }}
                </div>
              </td>
              <td class="px-5 py-3 align-top text-gray-700">
                {{ $owner->name ?? '—' }}
              </td>
              <td class="px-5 py-3 align-top text-gray-700">
                {{ $store->city ?? '—' }}
              </td>
              <td class="px-5 py-3 align-top text-gray-500">
                {{ $store->created_at?->format('d M Y') ?? '—' }}
              </td>
              <td class="px-5 py-3 align-top text-right space-x-2">
                <a href="{{ route('admin.stores.edit', $store) }}"
                   class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-[color:var(--wine)] bg-rose-50 hover:bg-rose-100">
                  Edit
                </a>

                <form action="{{ route('admin.stores.destroy', $store) }}"
                      method="POST"
                      class="inline-block"
                      onsubmit="return confirm('Yakin ingin menghapus toko ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $stores->links() }}
    </div>
  @endif
</div>
@endsection
