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

        // ==========================================
        // DEFAULT VALUE (kalau seller belum punya toko)
        // ==========================================
        $salesLabels = [];
        $salesValues = [];
        $totalProducts = 0;
        $recentOrders = collect();

        // siapkan 6 label bulan dulu (biar chart tetap rapi)
        $now = now();
        for ($i = 5; $i >= 0; $i--) {
            $monthObj = $now->copy()->subMonths($i);
            $salesLabels[] = $monthObj->format('M');
            $salesValues[] = 0;   // nanti di-override kalau ada store
        }

        // ==========================================
        // KALAU SELLER SUDAH PUNYA TOKO
        // ==========================================
        if ($store) {
            // TOTAL PRODUK PER TOKO
            $totalProducts = Product::where('store_id', $store->id)->count();

            // GRAFIK PENJUALAN 6 BULAN TERAKHIR (HANYA TOKO INI)
            $salesValues = []; // reset
            for ($i = 5; $i >= 0; $i--) {
                $month = $now->copy()->subMonths($i);

                $sales = Order::where('store_id', $store->id)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('total_price');   // pastikan nama kolomnya benar

                $salesValues[] = (int) $sales;
            }

            // PESANAN TERBARU UNTUK TOKO INI SAJA
            $recentOrders = Order::where('store_id', $store->id)
                ->latest()
                ->take(5)
                ->get();
        }

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
