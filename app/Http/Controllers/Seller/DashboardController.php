<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // HANYA role seller yang boleh masuk dashboard seller
        abort_unless(($user->role ?? null) === 'seller', 403);

        // Untuk sementara: hitung semua produk.
        // Nanti kalau sudah ada kolom seller_id / store_id, bisa diganti:
        // $myProducts = Product::where('seller_id', $user->id)->count();
        $myProducts = Product::count();

        return view('dashboard.seller', [
            'my_products' => $myProducts,
        ]);
    }
}
