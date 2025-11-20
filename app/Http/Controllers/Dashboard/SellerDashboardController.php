<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $user  = auth()->user();
        $store = $user->store; // relasi user -> store (pastikan sudah ada)

        // TOTAL PRODUK MILIK SELLER
        $totalProducts = $store
            ? $store->products()->count()
            : 0;

        // AMBIL 5 PESANAN TERBARU UNTUK TOKO INI
        $recentOrders = Order::where('store_id', $store->id ?? null)
            ->latest()
            ->take(5)
            ->get();

        // (Opsional) Data kosong dulu untuk Chart.js
        $salesLabels = [];
        $salesValues = [];

        return view('dashboard.seller', [
            'user'          => $user,
            'totalProducts' => $totalProducts,
            'recentOrders'  => $recentOrders,
            'salesLabels'   => $salesLabels,
            'salesValues'   => $salesValues,
        ]);
    }
}
