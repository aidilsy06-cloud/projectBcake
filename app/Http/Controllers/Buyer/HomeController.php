<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Dashboard pembeli
     * Route: GET /buyer/dashboard -> name: buyer.dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // pastikan hanya role buyer yang boleh ke sini
        if (($user->role ?? 'buyer') !== 'buyer') {
            abort(403);
        }

        // 5 pesanan terbaru milik buyer ini
        $orders = Order::withCount('items')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // 8 toko populer berdasarkan jumlah produk
        $stores = Store::withCount('products')
            ->orderByDesc('products_count')
            ->take(8)
            ->get();

        // stats kecil kalau mau dipakai di view
        $stats = [
            'orders_count' => $orders->count(),
        ];

        // view: resources/views/buyer/index.blade.php
        return view('buyer.index', [
            'user'   => $user,
            'orders' => $orders,
            'stores' => $stores,
            'stats'  => $stats,
        ]);
    }
}
