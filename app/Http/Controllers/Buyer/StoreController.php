<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    // Daftar semua toko publik
    public function index()
    {
        $stores = Store::withCount(['products' => function ($q) {
            // Hitung hanya produk yang tampil (approved / null)
            $q->where(function ($w) {
                $w->whereNull('status')
                  ->orWhere('status', 'approved');
            });
        }])
        ->latest()
        ->paginate(12);

        return view('stores.index', compact('stores'));
    }

    // Halaman detail toko publik
    public function show(Store $store)
    {
        // ambil produk aktif saja
        $products = $store->products()
            ->where(function ($q) {
                $q->whereNull('status')          // produk lama
                  ->orWhere('status', 'approved'); // setelah di-approve admin
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('stores.show', [
            'store'    => $store,
            'products' => $products,
        ]);
    }
}
