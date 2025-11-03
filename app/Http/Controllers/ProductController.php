<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Landing page (home)
    public function home()
    {
        $products = Product::latest()->take(6)->get();
        return view('home', compact('products'));
    }

    // Halaman katalog produk
    public function index()
    {
        $products = Product::paginate(9);
        return view('products.index', compact('products'));
    }

    // Halaman detail produk
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
