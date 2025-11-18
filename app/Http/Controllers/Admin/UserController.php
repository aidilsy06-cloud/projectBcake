<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Form tambah user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'role'     => ['required', Rule::in(['admin','seller','buyer'])],
            'password' => ['required', 'min:6'],
        ]);

        // Hash password
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('ok', 'User berhasil dibuat.');
    }

    /**
     * Form edit user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'role'  => ['required', Rule::in(['admin','seller','buyer'])],
            'password' => ['nullable', 'min:6'],
        ]);

        // Jika password diisi → hash ulang
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // tidak update password
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('ok', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        // Cegah admin hapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Kamu tidak bisa menghapus akun kamu sendiri.');
        }

        $user->delete();

        return back()->with('ok', 'User berhasil dihapus.');
    }
}
