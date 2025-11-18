<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Tampilkan daftar toko.
     */
    public function index()
    {
        // Kalau nanti butuh relasi, bisa ditambah ->with('owner') dsb
        $stores = Store::latest()->paginate(10);

        return view('admin.stores.index', compact('stores'));
    }

    /**
     * Form tambah toko.
     */
    public function create()
    {
        // Pilih pemilik toko dari tabel users (misal seller / admin)
        $users = User::orderBy('name')->get();

        return view('admin.stores.create', compact('users'));
    }

    /**
     * Simpan toko baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'     => ['required', 'exists:users,id'],   // pemilik toko
            'name'        => ['required', 'string', 'max:150'],
            'slug'        => ['nullable', 'string', 'max:160', 'unique:stores,slug'],
            'city'        => ['nullable', 'string', 'max:100'],
            'address'     => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            // kalau di DB ada kolom phone / whatsapp / instagram, bisa ditambah di sini
            // 'phone'    => ['nullable', 'string', 'max:30'],
            // 'status'   => ['nullable', Rule::in(['active','inactive'])],
        ]);

        // Kalau slug kosong → auto-generate dari name
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        }

        Store::create($data);

        return redirect()
            ->route('admin.stores.index')
            ->with('ok', 'Toko berhasil dibuat.');
    }

    /**
     * Form edit toko.
     */
    public function edit(Store $store)
    {
        $users = User::orderBy('name')->get();

        return view('admin.stores.edit', compact('store', 'users'));
    }

    /**
     * Update data toko.
     */
    public function update(Request $request, Store $store)
    {
        $data = $request->validate([
            'user_id'     => ['required', 'exists:users,id'],
            'name'        => ['required', 'string', 'max:150'],
            'slug'        => [
                'nullable',
                'string',
                'max:160',
                Rule::unique('stores', 'slug')->ignore($store->id),
            ],
            'city'        => ['nullable', 'string', 'max:100'],
            'address'     => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            // 'phone'    => ['nullable', 'string', 'max:30'],
            // 'status'   => ['nullable', Rule::in(['active','inactive'])],
        ]);

        // Kalau slug kosong, generate baru dari name
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . $store->id;
        }

        $store->update($data);

        return redirect()
            ->route('admin.stores.index')
            ->with('ok', 'Toko berhasil diperbarui.');
    }

    /**
     * Hapus toko.
     */
    public function destroy(Store $store)
    {
        $store->delete();

        return back()->with('ok', 'Toko berhasil dihapus.');
    }
}
