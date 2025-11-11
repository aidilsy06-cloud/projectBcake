<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StoreController extends Controller
{
    /**
     * Daftar semua toko (publik / buyer).
     * Fitur: pencarian (q), paginasi, products_count (jika relasi ada).
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        $builder = Store::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%")
                        ->orWhere('tagline', 'like', "%{$q}%");
                });
            })
            ->latest('id');

        // Tambahkan withCount('products') jika relasi ada supaya tidak error
        try {
            if (method_exists(Store::class, 'products') || method_exists((new Store), 'products')) {
                $builder->withCount('products');
            }
        } catch (\Throwable $e) {
            // biarkan tanpa withCount
        }

        $stores = $builder->paginate(12)->withQueryString();

        return view('buyer.stores.index', compact('stores', 'q'));
    }

    /**
     * Detail satu toko (slug binding) + produk toko (paginasi & sorting).
     */
    public function show(Store $store, Request $request)
    {
        $sort = $request->input('sort', 'latest'); // latest|price_asc|price_desc

        // --- Query produk yang paling aman ---
        // 1) Jika ada relasi products() di model Store, pakai itu.
        // 2) Jika tidak, deteksi kolom di tabel products: store_id | seller_id | user_id.
        $query = null;

        try {
            if (method_exists($store, 'products')) {
                $query = $store->products(); // sudah otomatis ter-filter oleh relasi
            }
        } catch (\Throwable $e) {
            $query = null;
        }

        if (! $query) {
            // Fallback manual berdasarkan kolom yang tersedia di tabel products
            $fk = null;
            if (Schema::hasColumn('products', 'store_id')) {
                $fk = ['column' => 'store_id', 'value' => $store->id];
            } elseif (Schema::hasColumn('products', 'seller_id')) {
                $fk = ['column' => 'seller_id', 'value' => $store->user_id]; // asumsi owner di stores.user_id
            } elseif (Schema::hasColumn('products', 'user_id')) {
                $fk = ['column' => 'user_id', 'value' => $store->user_id];
            }

            $query = Product::query();
            if ($fk) {
                $query->where($fk['column'], $fk['value']);
            } else {
                // kalau tidak ada kolom yang cocok, biarkan kosong (tidak filter)
                $query->whereRaw('1=0'); // jaga-jaga biar tidak menampilkan semua produk
            }
        }

        // Sorting + paginate
        $products = $query
            ->when($sort === 'price_asc',  fn($q) => $q->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
            ->when($sort === 'latest',     fn($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        // SEO meta sederhana (opsional)
        $meta = [
            'title'       => ($store->name ?? 'Toko') . ' — B’cake',
            'description' => $store->tagline ?? 'Toko manis & elegan di B’cake.',
        ];

        return view('buyer.stores.show', compact('store', 'products', 'meta', 'sort'));
    }
}
