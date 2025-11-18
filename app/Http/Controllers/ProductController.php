<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Halaman semua produk
     */
    public function index()
    {
        $products = Product::latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Halaman detail produk
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Halaman produk berdasarkan kategori
     */
    public function byCategory(string $slug)
    {
        // Daftar kategori (slug → judul kategori)
        $categories = [
            'custom-cake-modern' => 'Custom Cake & Modern Cake',
            'cupcake-brownies'   => 'Cupcake & Brownies',
            'pastry-roti'        => 'Pastry & Roti',
            'dessert-box'        => 'Dessert Box',
            'snack'              => 'Snack',
        ];

        // Kalau slug tidak dikenal → 404
        abort_unless(isset($categories[$slug]), 404);

        // Ambil produk berdasarkan kategori
        $products = Product::where('category_slug', $slug)
            ->latest()
            ->paginate(12);

        // Kirim ke view category
        return view('categories.show', [
            'title'    => $categories[$slug],
            'slug'     => $slug,
            'products' => $products,
        ]);
    }
}
