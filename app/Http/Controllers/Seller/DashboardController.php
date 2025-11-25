<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard utama seller
     *
     * Route:
     *   GET /seller        -> name: seller.dashboard
     *   (lihat di routes/web.php, prefix seller)
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan yang akses benar-benar seller
        if (($user->role ?? null) !== 'seller') {
            abort(403);
        }

        // Ambil toko milik seller ini
        // (kalau di model User ada relasi store(), pakai itu;
        //  kalau tidak, fallback cari store berdasarkan user_id)
        $store = $user->store ?? Store::where('user_id', $user->id)->first();

        // Kalau belum punya toko, angka jadi 0 semua
        if (! $store) {
            $stats = [
                'total_products' => 0,
                'total_orders'   => 0,
                'total_income'   => 0,
            ];

            $latestOrders = collect();
        } else {
            // Total produk di toko ini
            $totalProducts = Product::where('store_id', $store->id)->count();

            // Total pesanan (semua status) untuk toko ini
            $totalOrders = Order::where('store_id', $store->id)->count();

            // Total omzet (kalau kamu simpan total_price di tabel orders)
            $totalIncome = Order::where('store_id', $store->id)->sum('total_price');

            $stats = [
                'total_products' => $totalProducts,
                'total_orders'   => $totalOrders,
                'total_income'   => $totalIncome,
            ];

            // Pesanan terbaru (misal 5 terakhir) untuk section "Pesanan Terbaru"
            $latestOrders = Order::where('store_id', $store->id)
                ->latest()
                ->take(5)
                ->get();
        }

        // Kirim data ke view dashboard seller
        // View: resources/views/seller/dashboard.blade.php
        return view('seller.dashboard', [
            'user'         => $user,
            'store'        => $store,
            'stats'        => $stats,
            'latestOrders' => $latestOrders,
        ]);
    }
}
