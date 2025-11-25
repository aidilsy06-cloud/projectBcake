<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Halaman katalog utama: /products
     */
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category'])
            ->where('status', 'approved');  // 🔒 hanya produk yang sudah diverifikasi admin

        // Search ?q=
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhereHas('store', fn ($s) => $s->where('name', 'like', "%{$q}%"));
            });
        }

        // Filter kategori lewat ?category_id=xx (kalau kamu pakai)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(12);

        // Kategori untuk sidebar/filter (tampilan yang di home / katalog jangan diubah layout-nya)
        $categories = Category::orderBy('name')->get();

        return view('products.index', [
            'products'          => $products,
            'categories'        => $categories,
            'currentCategoryId' => $request->category_id,
            'q'                 => $request->q,
        ]);
    }

    /**
     * Halaman produk per kategori:
     * route: /kategori/{category:slug}
     */
    public function byCategory(Category $category, Request $request)
    {
        $products = Product::with(['store', 'category'])
            ->where('status', 'approved')          // 🔒 hanya produk disetujui
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        // kalau view kamu butuh list kategori di samping, tetap kirim
        $categories = Category::orderBy('name')->get();

        return view('products.by-category', [
            'category'         => $category,
            'products'         => $products,
            'categories'       => $categories,
            'currentCategoryId'=> $category->id,
        ]);
    }

    /**
     * Detail produk:
     * route: /product/{product:slug}
     */
    public function show(Product $product)
    {
        // Extra keamanan: pembeli cuma boleh lihat produk approved
        if ($product->status !== 'approved') {
            // kalau mau, bisa izinkan admin/seller untuk lihat detail walau pending
            if (!auth()->check() || ! in_array(auth()->user()->role, ['admin', 'seller'])) {
                abort(404);
            }
        }

        $product->load(['store', 'category']);

        return view('products.show', compact('product'));
    }
}
