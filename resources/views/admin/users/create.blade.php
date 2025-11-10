@extends('layouts.app')
@section('title', 'Tambah User — B’cake')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-2xl border border-bcake-truffle/10 shadow-sm">
  <h1 class="text-xl font-semibold mb-4">Tambah User</h1>
  <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border-gray-300 mt-1">
    </div>
    <div>
      <label class="block text-sm font-medium">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border-gray-300 mt-1">
    </div>
    <div>
      <label class="block text-sm font-medium">Password</label>
      <input type="password" name="password" required class="w-full rounded-xl border-gray-300 mt-1">
    </div>
    <div>
      <label class="block text-sm font-medium">Role</label>
      <select name="role" class="w-full rounded-xl border-gray-300 mt-1">
        <option value="buyer">Buyer</option>
        <option value="seller">Seller</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <div class="pt-3 flex justify-end gap-2">
      <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl border">Batal</a>
      <button type="submit" class="px-4 py-2 rounded-xl bg-bcake-wine text-white">Simpan</button>
    </div>
  </form>
</div>
@endsection
