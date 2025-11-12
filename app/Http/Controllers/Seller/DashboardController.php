<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Placeholder 4 produk (pakai LINK gambar yang kamu minta)
        $placeholders = [
            [
                'name'  => 'Cake Pinky',
                'price' => 26000,
                'img'   => 'https://files.oaiusercontent.com/file-8f86fb16-01cb-4c1f-be0b-d40bac1488e4.jpg',
            ],
            [
                'name'  => 'Cake Rainbow',
                'price' => 28000,
                'img'   => 'https://files.oaiusercontent.com/file-76da927e-9cd9-488a-9c54-786f40c65199.jpg',
            ],
            [
                'name'  => 'Cake Pink',
                'price' => 32000,
                'img'   => 'https://files.oaiusercontent.com/file-ca883852-7a08-46d4-bbc0-fa6c619defea.jpg',
            ],
            [
                'name'  => 'Cake Softpink',
                'price' => 22000,
                'img'   => 'https://files.oaiusercontent.com/file-376dbc67-5b80-4620-9431-23ee75f037c0.jpg',
            ],
        ];

        // Produk asli dari DB (kalau ada)
        // NOTE: nanti ganti filter sesuai owner (store_id / user_id) kalau sudah siap
        $products = Product::query()
            ->latest()
            ->take(8)
            ->get();

        // Kategori untuk chip di hero
        $categories = [
            ['name' => 'New Creations', 'icon' => '🎂'],
            ['name' => 'Best Sellers',  'icon' => '⭐'],
            ['name' => 'Seasonal',      'icon' => '🍓'],
            ['name' => 'Discounts',     'icon' => '💝'],
        ];

        // Statistik sederhana
        $stats = [
            'products' => $products->count() ?: 4,
            'orders'   => 12,
            'promos'   => 3,
        ];

        return view('seller.dashboard', compact('products', 'placeholders', 'categories', 'stats'));
    }
}
