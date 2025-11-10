<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        // daftar toko terbaru dulu, bisa ditambah pagination kalau mau
        $stores = Store::orderByDesc('id')->get();

        return view('buyer.stores.index', compact('stores'));
    }

    public function show(string $slug)
    {
        // ambil toko + produk2nya
        $store = Store::where('slug', $slug)
            ->with(['products' => function ($q) {
                $q->latest();
            }])
            ->firstOrFail();

        return view('buyer.stores.show', compact('store'));
    }
}
