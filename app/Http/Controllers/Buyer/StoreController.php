<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    // Daftar semua toko
    public function index()
    {
        $stores = Store::withCount('products')
            ->latest()
            ->paginate(12);

        // PAKAI 1 VIEW PASTI: resources/views/stores/index.blade.php
        return view('stores.index', compact('stores'));
    }

    // Halaman detail toko publik: /store/{store:slug}
    public function show(Store $store)
    {
        // Ambil produk-produk toko ini
        $products = $store->products()
            ->latest()
            ->get();

        return view('stores.show', [
            'store'    => $store,
            'products' => $products,
        ]);
    }
}
