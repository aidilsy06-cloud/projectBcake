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

        // pastikan role seller
        abort_unless(($user->role ?? null) === 'seller', 403);

        // relasi: User hasOne Store
        $store = $user->store;

        // ===============================
        // TOTAL PRODUK — pakai store_id
        // ===============================
        $totalProducts = 0;
        if ($store) {
            $totalProducts = Product::where('store_id', $store->id)->count();
        }

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
        // PESANAN TERBARU
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
