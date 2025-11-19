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
     */
    protected function myStore(): Store
    {
        $user = auth()->user();
        abort_unless(($user->role ?? null) === 'seller', 403);

        $baseSlug = Str::slug($user->name) ?: ('store-'.$user->id);

        if (Schema::hasColumn('stores', 'user_id')) {

            // 1) sudah punya toko?
            $existing = Store::where('user_id', $user->id)->first();
            if ($existing) {
                return $existing;
            }

            // 2) klaim toko seeder dengan slug sama & user_id NULL
            $claimable = Store::whereNull('user_id')
                ->where('slug', $baseSlug)
                ->first();

            if ($claimable) {
                $claimable->update([
                    'user_id' => $user->id,
                ]);

                return $claimable;
            }

            // 3) buat baru
            return Store::create([
                'user_id'     => $user->id,
                'name'        => $user->name.' Store',
                'slug'        => $baseSlug,
                'tagline'     => 'Sweet & Elegant',
                'whatsapp'    => null,
                'description' => null,
            ]);
        }

        // fallback kalau ga ada kolom user_id
        return Store::firstOrCreate(
            ['slug' => $baseSlug],
            [
                'name'    => $user->name.' Store',
                'tagline' => 'Sweet & Elegant',
            ]
        );
    }

    /**
     * Halaman "Toko Saya" di sisi seller.
     */
    public function show(Request $request)
    {
        $store = $this->myStore();
        $sort  = $request->input('sort', 'latest'); // latest|price_asc|price_desc

        $query = Product::query();

        if (Schema::hasColumn('products', 'store_id')) {
            $query->where('store_id', $store->id);
        } elseif (Schema::hasColumn('products', 'seller_id')) {
            $query->where('seller_id', $store->user_id);
        } elseif (Schema::hasColumn('products', 'user_id')) {
            $query->where('user_id', $store->user_id);
        } else {
            $query->whereRaw('1=0'); // aman kalau belum ada kolom owner
        }

        $products = $query
            ->when($sort === 'price_asc',  fn ($q) => $q->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn ($q) => $q->orderBy('price', 'desc'))
            ->when($sort === 'latest',     fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        $meta = [
            'title'       => ($store->name ?? 'Toko').' — B’cake',
            'description' => $store->tagline ?? 'Toko manis & elegan di B’cake.',
        ];

        return view('seller.store.show', compact('store', 'products', 'meta', 'sort'));
    }

    /**
     * FORM edit toko saya.
     * Route: GET /seller/store/edit  →  seller.store.edit
     */
    public function edit()
    {
        $store = $this->myStore();
        return view('seller.store.edit', compact('store'));
    }

    /**
     * PROSES update profil toko saya.
     * Route: PUT /seller/store  →  seller.store.update
     */
    public function update(Request $request)
    {
        $store = $this->myStore();

        // 1. Validasi input
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'slug'        => ['required', 'alpha_dash', 'max:120', 'unique:stores,slug,'.$store->id],
            'tagline'     => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:2000'],
            'whatsapp'    => ['nullable', 'string', 'max:20'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'banner'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        // 2. Normalisasi slug
        $slug = Str::slug($validated['slug']);

        // 3. Normalisasi nomor WhatsApp → 62xxxxxxxxxx
        $wa = $validated['whatsapp'] ?? null;

        if ($wa !== null && $wa !== '') {
            $wa = preg_replace('/\D+/', '', $wa); // hanya angka

            if (Str::startsWith($wa, '0')) {
                $wa = '62'.substr($wa, 1);   // 08xxx → 628xxx
            } elseif (!Str::startsWith($wa, '62')) {
                $wa = '62'.$wa;              // kalau belum ada 62 di depan
            }
        } else {
            $wa = null;
        }

        // 4. Isi field satu-satu
        $store->name        = $validated['name'];
        $store->slug        = $slug;
        $store->tagline     = $validated['tagline'] ?? null;
        $store->description = $validated['description'] ?? null;
        $store->whatsapp    = $wa;

        // 5. Upload logo (kalau ada)
        if ($request->hasFile('logo')) {
            if ($store->logo && Storage::disk('public')->exists($store->logo)) {
                Storage::disk('public')->delete($store->logo);
            }

            $store->logo = $request->file('logo')->store('stores/logo', 'public');
        }

        // 6. Upload banner (kalau ada)
        if ($request->hasFile('banner')) {
            if ($store->banner && Storage::disk('public')->exists($store->banner)) {
                Storage::disk('public')->delete($store->banner);
            }

            $store->banner = $request->file('banner')->store('stores/banner', 'public');
        }

        // 7. Simpan perubahan
        $store->save();

        return redirect()
            ->route('seller.store.show')
            ->with('success', 'Profil toko berhasil diperbarui.');
    }
}
