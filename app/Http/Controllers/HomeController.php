<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;

class HomeController extends Controller
{
    public function index()
    {
        // Produk terbaru
        try {
            $latestProducts = Product::latest()
                ->where('status', 'approved') // optional
                ->take(8)
                ->get();
        } catch (\Throwable $e) {
            $latestProducts = collect();
        }

        // Toko populer berdasarkan jumlah produk
        try {
            $popularStores = Store::withCount('products')
                ->orderByDesc('products_count')
                ->take(6)
                ->get();
        } catch (\Throwable $e) {
            $popularStores = collect();
        }

        // Produk rekomendasi spesial
        try {
            $recommendedProducts = Product::where('is_recommended', 1)
                ->where('status', 'approved') // optional
                ->take(8)
                ->get();
        } catch (\Throwable $e) {
            $recommendedProducts = collect();
        }

        return view('home', [
            'latestProducts'     => $latestProducts,
            'popularStores'      => $popularStores,
            'bestSellers'        => $latestProducts,
            'recommendedProducts'=> $recommendedProducts,
        ]);
    }
}
