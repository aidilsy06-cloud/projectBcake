<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Daftar semua toko (halaman /stores)
     */
    public function index()
    {
        $stores = Store::withCount('products')
            ->latest()
            ->paginate(12);

        // view: resources/views/stores/index.blade.php
        return view('stores.index', compact('stores'));
    }

    /**
     * Halaman detail toko publik: /store/{store:slug}
     */
    public function show(Store $store)
    {
        // Hitung jumlah produk approved di toko ini (kalau mau dipakai di view)
        $store->loadCount([
            'products as approved_products_count' => function ($q) {
                $q->where('status', 'approved');
            },
        ]);

        // Ambil hanya produk yang:
        // - milik toko ini (relasi products)
        // - status sudah 'approved' (sudah diverifikasi admin)
        // plus eager-load category biar di view nggak N+1 query
        $products = $store->products()
            ->where('status', 'approved')
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('stores.show', [
            'store'    => $store,
            'products' => $products,
        ]);
    }
}
