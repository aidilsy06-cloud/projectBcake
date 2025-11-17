<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // produk lain di home (kalau kamu pakai)
        $products = Product::latest()->take(3)->get();

        // coba ambil sampai 6 produk
        $bestSellers = Product::latest()->take(6)->get();

        // kalau bestSellers kosong, pakai products sebagai fallback
        if ($bestSellers->isEmpty()) {
            $bestSellers = Product::take(3)->get();
        }

        return view('home', compact('products', 'bestSellers'));
    }
}
