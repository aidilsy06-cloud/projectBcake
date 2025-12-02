@extends('layouts.app')

@section('title', 'Kelola Toko — Admin B’cake')

@push('head')
<style>
  .card-soft{
    background: linear-gradient(145deg,#fff,#fff6f7 60%,#ffecef 100%);
  }
  .shadow-soft{box-shadow:0 18px 40px rgba(54,35,32,.10)}
  .ring-soft{box-shadow:inset 0 0 0 1px rgba(244,63,94,.25)}
</style>
@endpush

@section('content')
<div class="page-bg min-h-[calc(100vh-4rem)] px-4 lg:px-10 py-8">

  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-[var(--bcake-wine)]">
      Kelola Toko
    </h1>

    <a href="{{ route('admin.stores.create') }}"
       class="bg-bcake-grad text-white px-5 py-2 rounded-xl hover:brightness-110">
      + Tambah Toko
    </a>
  </div>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($stores as $s)
      <article class="rounded-2xl card-soft p-5 shadow-soft ring-soft">
        <div class="flex items-center gap-3">
          <img
            src="{{ $s->logo_url
              ? asset('storage/'.$s->logo_url)
              : 'https://ui-avatars.com/api/?name='.urlencode($s->name).'&background=ffe9f0&color=890524' }}"
            class="h-12 w-12 rounded-xl object-cover ring-1 ring-rose-200/60">
          <div>
            <div class="font-semibold line-clamp-1">{{ $s->name }}</div>
            <div class="text-xs text-gray-500 line-clamp-1">{{ $s->tagline ?? 'Sweet & Elegant' }}</div>
          </div>
        </div>

        <div class="text-xs mt-3 text-gray-600">
          WA: {{ $s->whatsapp ?? 'Belum diatur' }}
        </div>

        <div class="mt-5 flex items-center justify-between gap-2">
          <a href="{{ route('admin.stores.edit', $s) }}"
             class="px-3 py-1.5 rounded-xl bg-yellow-100 text-yellow-700 text-sm hover:bg-yellow-200">
            ✏ Edit
          </a>

          <form
            method="POST"
            action="{{ route('admin.stores.destroy', $s) }}"
            onsubmit="return confirm('Yakin ingin menghapus toko ini?')"
          >
            @csrf
            @method('DELETE')
            <button
              class="px-3 py-1.5 rounded-xl bg-rose-100 text-rose-700 text-sm hover:bg-rose-200">
              🗑 Hapus
            </button>
          </form>
        </div>
      </article>
    @empty
      <div class="col-span-full text-center text-gray-500 py-10">
        Belum ada toko untuk ditampilkan.
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $stores->links() }}
  </div>

</div>
@endsection
