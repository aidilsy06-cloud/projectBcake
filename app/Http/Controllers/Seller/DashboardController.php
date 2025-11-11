<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // contoh data: ambil 8 produk terbaru milik seller login (kalau sudah ada relasi owner)
        $products = Product::latest()->take(8)->get();

        // kategori dummy untuk chip di hero
        $categories = [
            ['name' => 'New Creations', 'icon' => '🎂'],
            ['name' => 'Best Sellers',  'icon' => '⭐'],
            ['name' => 'Seasonal',      'icon' => '🍓'],
            ['name' => 'Discounts',     'icon' => '💝'],
        ];

        return view('seller.dashboard', compact('products','categories'));
    }
}
