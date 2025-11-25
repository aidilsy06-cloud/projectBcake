<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // pastikan memang seller
        if (($user->role ?? null) !== 'seller') {
            abort(403);
        }

        // ambil toko milik seller
        $store = $user->store ?? Store::where('user_id', $user->id)->first();

        // ===============================
        // TOTAL PRODUK (aktif di katalog)
        // ===============================
        $totalProducts = 0;

        if ($store) {
            $totalProducts = Product::where('store_id', $store->id)
                ->where(function ($q) {
                    $q->whereNull('status')          // data lama
                      ->orWhere('status', 'approved'); // sudah disetujui admin
                })
                ->count();
        }

        // ===============================
        // PESANAN TERBARU UNTUK TOKO INI
        // ===============================
        $recentOrders = collect();
        if ($store) {
            $recentOrders = Order::where('store_id', $store->id)
                ->latest()
                ->take(5)
                ->get();
        }

        // Dummy data chart penjualan (biar nggak error dulu)
        $salesLabels = ['Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'];
        $salesValues = [0, 0, 0, 0, 0, 0];

        return view('seller.dashboard', [
            'user'         => $user,
            'store'        => $store,
            'totalProducts'=> $totalProducts,
            'recentOrders' => $recentOrders,
            'salesLabels'  => $salesLabels,
            'salesValues'  => $salesValues,
        ]);
    }
}
