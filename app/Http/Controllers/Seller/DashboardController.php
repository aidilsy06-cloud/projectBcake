<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = auth()->user();
        $store = $user->store; // relasi user -> store (pastikan ada user_id di tabel stores)

        // --- TOTAL PRODUK TOKO INI ---
        $totalProducts = 0;

        if ($store) {
            // hitung produk berdasarkan store_id, bukan count semua product
            $totalProducts = Product::where('store_id', $store->id)->count();
        }

        // --- PESANAN TERBARU TOKO INI ---
        $recentOrders = collect();

        if ($store) {
            $recentOrders = Order::where('store_id', $store->id)
                ->latest()
                ->take(5)
                ->get();
        }

        // --- DATA CHART (boleh kosong dulu) ---
        $salesLabels = [];
        $salesValues = [];

        return view('seller.dashboard', [
            'user'          => $user,
            'totalProducts' => $totalProducts,
            'recentOrders'  => $recentOrders,
            'salesLabels'   => $salesLabels,
            'salesValues'   => $salesValues,
        ]);
    }
}
