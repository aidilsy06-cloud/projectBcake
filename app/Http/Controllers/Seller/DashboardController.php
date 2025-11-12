<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Model yang digunakan
use App\Models\Store;
use App\Models\Product;
// use App\Models\Order; // <- dinonaktifkan dulu karena model/tabel orders belum ada
use App\Models\Category;
// use App\Models\Promo; // tetap dikomen kalau belum ada

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1️⃣ Ambil toko milik seller ini
        $store = Store::firstWhere('user_id', $user->id);

        // 2️⃣ Statistik dasar toko
        $productsCount = $store ? Product::where('store_id', $store->id)->count() : 0;

        // sementara 0 karena belum ada tabel orders
        $ordersMonth  = 0;
        $revenueMonth = 0;

        // 3️⃣ Kategori & produk terbaru
        // (AMAN: tidak pakai store_id dan tidak pakai orderBy 'name' biar gak error)
        $categories = Category::take(6)->get();

        $latestProducts = $store
            ? Product::where('store_id', $store->id)->latest()->take(8)->get()
            : collect();

        // 4️⃣ Placeholder fallback (kalau DB kosong)
        $placeholders = [
            ['name'=>'Cake Pinky','price'=>26000,'img'=>'https://files.oaiusercontent.com/file-8f86fb16-01cb-4c1f-be0b-d40bac1488e4.jpg'],
            ['name'=>'Cake Rainbow','price'=>28000,'img'=>'https://files.oaiusercontent.com/file-76da927e-9cd9-488a-9c54-786f40c65199.jpg'],
            ['name'=>'Cake Pink','price'=>32000,'img'=>'https://files.oaiusercontent.com/file-ca883852-7a08-46d4-bbc0-fa6c619defea.jpg'],
            ['name'=>'Cake Softpink','price'=>22000,'img'=>'https://files.oaiusercontent.com/file-376dbc67-5b80-4620-9431-23ee75f037c0.jpg'],
        ];

        $defaultCategories = [
            ['name' => 'New Creations', 'icon' => '🎂'],
            ['name' => 'Best Sellers',  'icon' => '⭐'],
            ['name' => 'Seasonal',      'icon' => '🍓'],
            ['name' => 'Discounts',     'icon' => '💝'],
        ];

        // 5️⃣ Kirim ke tampilan
        return view('seller.dashboard', [
            'store'   => $store,
            'seller'  => $user,
            'stats'   => [
                'products'      => $productsCount ?: count($placeholders),
                'orders_month'  => $ordersMonth,
                'promos'        => 0,
                'revenue_month' => $revenueMonth,
            ],
            'categories'     => $categories->isNotEmpty() ? $categories : collect($defaultCategories),
            'latestProducts' => $latestProducts->isNotEmpty() ? $latestProducts : collect($placeholders),
        ]);
    }
}
