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
     * - Kalau sudah ada store dengan user_id = seller → pakai itu
     * - Kalau belum ada tapi ada store "kosong" (user_id NULL) dengan slug sama → klaim toko itu
     * - Kalau belum ada sama sekali → buat baru
     */
    protected function myStore(): Store
    {
        $user = auth()->user();
        abort_unless(($user->role ?? null) === 'seller', 403);

        $baseSlug = Str::slug($user->name) ?: ('store-'.$user->id);

        // Kalau tabel stores punya kolom user_id
        if (Schema::hasColumn('stores', 'user_id')) {

            // 1) Sudah punya toko? → pakai
            $existing = Store::where('user_id', $user->id)->first();
            if ($existing) {
                return $existing;
            }

            // 2) Belum punya, tapi ada toko seeder dengan slug sama & user_id NULL? → klaim
            $claimable = Store::whereNull('user_id')
                ->where('slug', $baseSlug)
                ->first();

            if ($claimable) {
                $claimable->update([
                    'user_id' => $user->id,
                ]);

                return $claimable;
            }

            // 3) Sama sekali belum ada → buat baru
            return Store::create([
                'user_id'    => $user->id,
                'name'       => $user->name.' Store',
                'slug'       => $baseSlug,
                'tagline'    => 'Sweet & Elegant',
                'whatsapp'   => null,
                'description'=> null,
            ]);
        }

        // Fallback kalau (aneh banget sih) tidak ada kolom user_id
        return Store::firstOrCreate(
            ['slug' => $baseSlug],
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
            'whatsapp'    => ['nullable','string','max:20'],
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
