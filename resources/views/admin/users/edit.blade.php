@extends('layouts.app')
@section('title', 'Edit User — B’cake')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-2xl border border-bcake-truffle/10 shadow-sm">
  <h1 class="text-xl font-semibold mb-4">Edit User</h1>
  <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
    @csrf @method('PUT')
    <div>
      <label class="block text-sm font-medium">Nama</label>
      <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-gray-300 mt-1">
    </div>
    <div>
      <label class="block text-sm font-medium">Email</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border-gray-300 mt-1">
    </div>
    <div>
      <label class="block text-sm font-medium">Role</label>
      <select name="role" class="w-full rounded-xl border-gray-300 mt-1">
        <option value="buyer"  @selected($user->role=='buyer')>Buyer</option>
        <option value="seller" @selected($user->role=='seller')>Seller</option>
        <option value="admin"  @selected($user->role=='admin')>Admin</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium">Password (opsional)</label>
      <input type="password" name="password" class="w-full rounded-xl border-gray-300 mt-1" placeholder="Kosongkan jika tidak diubah">
    </div>
    <div class="pt-3 flex justify-end gap-2">
      <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl border">Batal</a>
      <button type="submit" class="px-4 py-2 rounded-xl bg-bcake-wine text-white">Perbarui</button>
    </div>
  </form>
</div>
@endsection
