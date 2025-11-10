@extends('layouts.app')
@section('title','Admin • Users')

@section('content')
<div class="flex items-center justify-between mb-6">
  <h1 class="text-2xl font-semibold">Users</h1>
  <a href="{{ route('admin.users.create') }}" class="px-4 py-2 rounded-xl bg-bcake-wine text-white">Tambah User</a>
</div>

<div class="bg-white border rounded-xl overflow-hidden">
  <table class="min-w-full text-sm">
    <thead class="bg-rose-50">
      <tr>
        <th class="px-4 py-2 text-left">#</th>
        <th class="px-4 py-2 text-left">Nama</th>
        <th class="px-4 py-2 text-left">Email</th>
        <th class="px-4 py-2 text-left">Role</th>
        <th class="px-4 py-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $u)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $loop->iteration }}</td>
        <td class="px-4 py-2">{{ $u->name }}</td>
        <td class="px-4 py-2">{{ $u->email }}</td>
        <td class="px-4 py-2">{{ $u->role ?? 'buyer' }}</td>
        <td class="px-4 py-2 text-center">
          <a href="{{ route('admin.users.edit',$u) }}" class="underline mr-2">Edit</a>
          <form action="{{ route('admin.users.destroy',$u) }}" method="POST" class="inline">
            @csrf @method('DELETE')
            <button class="text-rose-600 underline" onclick="return confirm('Hapus user ini?')">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
