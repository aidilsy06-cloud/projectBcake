<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;

class HomeController extends Controller
{
    public function index()
    {
        // Produk terbaru buat di landing
        try {
            $latestProducts = Product::latest()->take(8)->get();
        } catch (\Throwable $e) {
            $latestProducts = collect();
        }

        // Toko populer
        try {
            $popularStores = Store::withCount('products')
                ->orderByDesc('products_count')
                ->take(6)
                ->get();
        } catch (\Throwable $e) {
            $popularStores = collect();
        }

        // BEST SELLERS – sementara pakai produk terbaru juga,
        // atau ganti query ini sesuai fieldmu (misal where('is_best_seller',1))
        $bestSellers = $latestProducts;

        return view('home', [
            'latestProducts' => $latestProducts,
            'popularStores'  => $popularStores,
            'bestSellers'    => $bestSellers,   // <-- tambahin ini
        ]);
    }
}
