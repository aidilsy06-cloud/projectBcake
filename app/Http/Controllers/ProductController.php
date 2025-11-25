<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Halaman semua produk (katalog buyer / publik)
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        // Query dasar produk + relasi kategori & toko
        $productsQuery = Product::with(['category', 'store'])
            ->latest();

        // Search
        if ($q) {
            $productsQuery->where('name', 'like', "%{$q}%");
        }

        // Ambil produk paginasi
        $products = $productsQuery->paginate(12)->withQueryString();

        // Ambil semua kategori untuk strip kategori / filter
        $categories = Category::orderBy('name')->get();

        // Tidak sedang memilih kategori
        $currentCategory = null;

        return view('products.index', [
            'products'        => $products,
            'categories'      => $categories,
            'currentCategory' => $currentCategory,
            'q'               => $q,
        ]);
    }

    /**
     * Produk berdasarkan kategori
     * Route model binding: /kategori/{category:slug}
     */
    public function byCategory(Category $category, Request $request)
    {
        $q = $request->query('q');

        // Query produk by category_id
        $productsQuery = Product::with(['category', 'store'])
            ->where('category_id', $category->id)
            ->latest();

        if ($q) {
            $productsQuery->where('name', 'like', "%{$q}%");
        }

        $products   = $productsQuery->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', [
            'products'        => $products,
            'categories'      => $categories,
            'currentCategory' => $category,
            'q'               => $q,
        ]);
    }

    /**
     * Halaman detail produk
     */
    public function show(Product $product)
    {
        $product->loadMissing(['category', 'store']);

        return view('products.show', compact('product'));
    }
}
