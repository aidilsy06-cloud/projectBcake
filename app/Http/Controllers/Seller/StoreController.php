<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Ambil / buat Store milik seller login.
     * Aman walau kolom user_id belum ada di tabel stores.
     */
    protected function myStore(): Store
    {
        $user = auth()->user();
        abort_unless(($user->role ?? null) === 'seller', 403);

        // Jika tabel stores punya kolom user_id → jadikan owner
        if (Schema::hasColumn('stores', 'user_id')) {
            return Store::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name'    => $user->name.' Store',
                    'slug'    => Str::slug($user->name) ?: ('store-'.$user->id),
                    'tagline' => 'Sweet & Elegant',
                ]
            );
        }

        // Fallback tanpa user_id (pakai slug unik)
        return Store::firstOrCreate(
            ['slug' => Str::slug($user->name) ?: ('store-'.$user->id)],
            [
                'name'    => $user->name.' Store',
                'tagline' => 'Sweet & Elegant',
            ]
        );
    }

    /**
     * Tampilkan toko + produk milik toko (pakai store_id / seller_id / user_id yang tersedia)
     */
    public function show(Request $request)
    {
        $store = $this->myStore();
        $sort  = $request->input('sort', 'latest'); // latest|price_asc|price_desc

        // Tentukan kolom relasi yang ada di tabel products
        $query = Product::query();
        if (Schema::hasColumn('products', 'store_id')) {
            $query->where('store_id', $store->id);
        } elseif (Schema::hasColumn('products', 'seller_id')) {
            $query->where('seller_id', $store->user_id);
        } elseif (Schema::hasColumn('products', 'user_id')) {
            $query->where('user_id', $store->user_id);
        } else {
            // Tidak ada kolom owner yang cocok → kosongkan agar aman
            $query->whereRaw('1=0');
        }

        $products = $query
            ->when($sort === 'price_asc',  fn($q) => $q->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
            ->when($sort === 'latest',     fn($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        // Meta sederhana untuk head
        $meta = [
            'title'       => ($store->name ?? 'Toko').' — B’cake',
            'description' => $store->tagline ?? 'Toko manis & elegan di B’cake.',
        ];

        return view('seller.store.show', compact('store', 'products', 'meta', 'sort'));
    }

    /**
     * Form edit toko saya
     */
    public function edit()
    {
        $store = $this->myStore();
        return view('seller.store.edit', compact('store'));
    }

    /**
     * Update profil toko saya
     */
    public function update(Request $request)
    {
        $store = $this->myStore();

        $data = $request->validate([
            'name'        => ['required','string','max:100'],
            'slug'        => ['required','alpha_dash','max:120','unique:stores,slug,'.$store->id],
            'tagline'     => ['nullable','string','max:160'],
            'description' => ['nullable','string','max:2000'],
            'logo'        => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'banner'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        // Normalisasi slug
        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Upload logo
        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('stores/logo', 'public');
        }

        // Upload banner
        if ($request->hasFile('banner')) {
            if ($store->banner) {
                Storage::disk('public')->delete($store->banner);
            }
            $data['banner'] = $request->file('banner')->store('stores/banner', 'public');
        }

        $store->update($data);

        return redirect()
            ->route('seller.store.show')
            ->with('success', 'Profil toko berhasil diperbarui.');
    }
}
