@extends('layouts.app')

@section('title','Tambah Toko — Admin')

@push('head')
<style>
  :root{ --wine:#890524; --cocoa:#362320; }
  .form-label{font-size:.8rem;font-weight:500;color:#4b5563;margin-bottom:.15rem;display:block}
  .form-input, .form-select, .form-textarea{
    width:100%;
    border-radius:.9rem;
    border:1px solid #e5e7eb;
    padding:.55rem .8rem;
    font-size:.875rem;
    outline:none;
    transition:.15s;
    background:#fff;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus{
    border-color:var(--wine);
    box-shadow:0 0 0 1px rgba(137,5,36,.15);
  }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto px-6 py-8">
  <a href="{{ route('admin.stores.index') }}" class="text-sm text-gray-600">&larr; Kembali ke daftar toko</a>

  <h1 class="mt-4 text-2xl font-semibold text-[color:var(--cocoa)]">Tambah Toko</h1>
  <p class="text-sm text-gray-600 mt-1">
    Daftarkan toko baru untuk penjual di B’cake.
  </p>

  @if ($errors->any())
    <div class="mt-4 mb-2 rounded-xl bg-rose-50 border border-rose-100 px-4 py-3 text-sm text-rose-800">
      <strong class="font-semibold">Periksa kembali formulir kamu:</strong>
      <ul class="mt-1 list-disc list-inside space-y-0.5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.stores.store') }}" method="POST" class="mt-6 space-y-4">
    @csrf

    <div>
      <label class="form-label">Pemilik Toko (User)</label>
      <select name="user_id" class="form-select" required>
        <option value="">Pilih akun pemilik toko</option>
        @foreach(\App\Models\User::orderBy('name')->get() as $user)
          <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
            {{ $user->name }} ({{ $user->email }})
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="form-label">Nama Toko</label>
      <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
    </div>

    <div>
      <label class="form-label">Slug (opsional)</label>
      <input type="text" name="slug" class="form-input" value="{{ old('slug') }}"
             placeholder="boleh dikosongkan, akan dibuat otomatis">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="form-label">Kota</label>
        <input type="text" name="city" class="form-input" value="{{ old('city') }}">
      </div>
      <div>
        <label class="form-label">Alamat</label>
        <input type="text" name="address" class="form-input" value="{{ old('address') }}">
      </div>
    </div>

    <div>
      <label class="form-label">Deskripsi</label>
      <textarea name="description" rows="4" class="form-textarea">{{ old('description') }}</textarea>
    </div>

    <div class="pt-3 flex items-center justify-end gap-3">
      <a href="{{ route('admin.stores.index') }}"
         class="px-4 py-2 rounded-xl text-sm text-gray-700 bg-gray-100 hover:bg-gray-200">
        Batal
      </a>
      <button type="submit"
              class="px-5 py-2 rounded-xl text-sm font-medium text-white"
              style="background:var(--wine);box-shadow:0 10px 24px rgba(137,5,36,.25)">
        Simpan Toko
      </button>
    </div>
  </form>
</div>
@endsection
