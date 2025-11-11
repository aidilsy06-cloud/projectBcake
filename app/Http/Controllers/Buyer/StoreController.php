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
     * List toko (publik/buyer) dengan pencarian & paginasi.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $hasProductsRelation = method_exists(Store::class, 'products');

        $stores = Store::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%")
                        ->orWhere('tagline', 'like', "%{$q}%");
                });
            })
            ->when($hasProductsRelation, fn ($q) => $q->withCount('products'))
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('buyer.stores.index', compact('stores', 'q'));
    }

    /**
     * Detail toko (slug binding) + produk toko (sorting & paginasi).
     */
    public function show(Store $store, Request $request)
    {
        $sort = $request->input('sort', 'latest'); // latest|price_asc|price_desc
        $hasProductsRelation = method_exists($store, 'products');

        // 1) Pakai relasi jika ada; 2) fallback deteksi kolom owner di tabel products
        $query = $hasProductsRelation ? $store->products() : $this->productsByOwner($store);

        $products = $query
            ->when($sort === 'price_asc',  fn ($q) => $q->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn ($q) => $q->orderBy('price', 'desc'))
            ->when($sort === 'latest',     fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        $meta = [
            'title'       => ($store->name ?? 'Toko') . ' — B’cake',
            'description' => $store->tagline ?? 'Toko manis & elegan di B’cake.',
        ];

        return view('buyer.stores.show', compact('store', 'products', 'meta', 'sort'));
    }

    /**
     * Fallback builder produk jika relasi products() belum ada.
     * Prioritas kolom: store_id → seller_id → user_id.
     */
    protected function productsByOwner(Store $store)
    {
        $q = Product::query();

        if (Schema::hasColumn('products', 'store_id')) {
            return $q->where('store_id', $store->id);
        }
        if (Schema::hasColumn('products', 'seller_id')) {
            return $q->where('seller_id', $store->user_id);
        }
        if (Schema::hasColumn('products', 'user_id')) {
            return $q->where('user_id', $store->user_id);
        }

        // Jika tak ada kolom yang cocok, kembalikan query kosong
        return $q->whereRaw('1=0');
    }
}
