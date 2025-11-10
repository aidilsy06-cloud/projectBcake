@extends('layouts.app')
@section('title', 'Kelola User — B’cake')

@section('content')
<div class="space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold text-bcake-bitter">Kelola User</h1>
    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 rounded-xl bg-bcake-wine text-white hover:opacity-90">
      + Tambah User
    </a>
  </div>

  <div class="bg-white rounded-2xl border border-bcake-truffle/10 shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
      <thead class="bg-rose-50">
        <tr>
          <th class="px-4 py-2 text-left">Nama</th>
          <th class="px-4 py-2 text-left">Email</th>
          <th class="px-4 py-2 text-left">Role</th>
          <th class="px-4 py-2 text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $u->name }}</td>
          <td class="px-4 py-2">{{ $u->email }}</td>
          <td class="px-4 py-2">
            <span class="px-2 py-1 rounded text-xs bg-rose-100 text-bcake-wine">{{ $u->role ?? 'buyer' }}</span>
          </td>
          <td class="px-4 py-2 text-right">
            <a href="{{ route('admin.users.edit', $u) }}" class="text-sm text-bcake-wine hover:underline">Edit</a>
            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Hapus user ini?')" class="text-sm text-rose-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data user.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
