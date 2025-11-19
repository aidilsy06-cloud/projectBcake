<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\Order; // pastikan ada model Order
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard utama seller.
     */
    public function index()
    {
        $user = auth()->user();

        // Cari toko milik seller ini (1 seller = 1 toko)
        $store = Store::where('user_id', $user->id)->first();

        // Total produk milik seller
        $totalProducts = Product::where('user_id', $user->id)->count();

        // ================== DATA CHART PENJUALAN ==================
        // Ambil data 6 bulan terakhir (kalau belum ada data ya 0 saja)
        $startDate = now()->subMonths(5)->startOfMonth();

        $rawSales = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, SUM(total_price) as total")
            ->when($store, function ($q) use ($store) {
                $q->where('store_id', $store->id);   // filter per toko
            })
            ->where('created_at', '>=', $startDate)
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym'); // biar gampang mapping

        // Susun label bulan & nilai total
        $salesLabels = [];
        $salesValues = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $ymKey = $month->format('Y-m');

            $salesLabels[] = $month->translatedFormat('M Y'); // contoh: Nov 2025
            $salesValues[] = (float) ($rawSales[$ymKey]->total ?? 0);
        }
        // ==========================================================

        // Produk terbaru milik seller (opsional)
        $recentProducts = Product::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('Seller.dashboard', [
            'user'           => $user,
            'store'          => $store,
            'totalProducts'  => $totalProducts,
            'recentProducts' => $recentProducts,
            'salesLabels'    => $salesLabels,
            'salesValues'    => $salesValues,
        ]);
    }
}
