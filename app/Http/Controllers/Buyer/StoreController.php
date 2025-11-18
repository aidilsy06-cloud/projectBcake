<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    // daftar semua toko
    public function index()
    {
        $stores = Store::withCount('products')->latest()->paginate(12);

        return view('stores.index', [
            'stores' => $stores,
        ]);
    }

    // halaman detail toko publik: /store/{store:slug}
    public function show(Store $store)
    {
        // ambil produk-produk toko ini
        $products = $store->products()
            ->latest()
            ->get();

        // PENTING: gunakan view publik "stores.show"
        return view('stores.show', [
            'store'    => $store,
            'products' => $products,
        ]);
    }
}
