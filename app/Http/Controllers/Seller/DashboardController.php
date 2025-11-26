<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // pastikan ini seller
        abort_unless(($user->role ?? null) === 'seller', 403);

        // toko milik seller ini (kalau ada)
        $store = $user->store;

        // ===============================
        // TOTAL PRODUK
        // ===============================
        // Hitung semua produk milik seller ini berdasarkan user_id
        // (nggak pakai store_id lagi supaya produk lama juga ikut)
        $totalProducts = Product::where('user_id', $user->id)->count();
        // kalau kamu mau cuma yang sudah di-approve:
        // $totalProducts = Product::where('user_id', $user->id)
        //     ->where('status', 'approved')
        //     ->count();

        // ===============================
        // DATA CHART PENJUALAN 6 BULAN
        // ===============================
        $salesLabels = [];
        $salesValues = [];

        $now = now();

        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $salesLabels[] = $month->format('M');

            $sales = Order::when($store, function ($q) use ($store) {
                    $q->where('store_id', $store->id);
                })
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_price');

            $salesValues[] = (int) $sales;
        }

        // ===============================
        // PESANAN TERBARU UNTUK TOKO INI
        // ===============================
        $recentOrders = Order::when($store, function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', [
            'user'          => $user,
            'store'         => $store,
            'totalProducts' => $totalProducts,
            'salesLabels'   => $salesLabels,
            'salesValues'   => $salesValues,
            'recentOrders'  => $recentOrders,
        ]);
    }
}
