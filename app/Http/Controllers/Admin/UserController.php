<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:100'],
            'email' => ['required','email','max:150','unique:users,email'],
            'role'  => ['required', Rule::in(['admin','seller','buyer'])],
            'password' => ['required','min:6'],
        ]);

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect()->route('admin.users.index')->with('ok','User dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:100'],
            'email' => ['required','email','max:150', Rule::unique('users','email')->ignore($user->id)],
            'role'  => ['required', Rule::in(['admin','seller','buyer'])],
            'password' => ['nullable','min:6'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('ok','User diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('ok','User dihapus.');
    }
}
