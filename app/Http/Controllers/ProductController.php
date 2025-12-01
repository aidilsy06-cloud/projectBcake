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
        // ambil produk + relasi toko & kategori
        $query = Product::with(['store', 'category']);
        // ->where('status', 'approved');  // ❌ DIHAPUS karena di tabel tidak ada kolom status

        // ==========================
        //  🔍 PENCARIAN ?q=
        // ==========================
        if ($request->filled('q')) {
            $q = trim($request->q);

            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhereHas('store', function ($s) use ($q) {
                        $s->where('name', 'like', "%{$q}%");
                    });
            });
        }

        // ==========================
        //  FILTER KATEGORI ?category_id=
        // ==========================
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(12);

        // flag untuk tampilan "pencarian tidak ditemukan"
        $notFound = $request->filled('q') && $products->isEmpty();

        // Kategori untuk sidebar/filter
        $categories = Category::orderBy('name')->get();

        return view('products.index', [
            'products'          => $products,
            'categories'        => $categories,
            'currentCategoryId' => $request->category_id,
            'q'                 => $request->q,
            'notFound'          => $notFound,   // ⬅️ kirim ke blade
        ]);
    }

    /**
     * Halaman produk per kategori:
     * route: /kategori/{category:slug}
     */
    public function byCategory(Category $category, Request $request)
    {
        $products = Product::with(['store', 'category'])
            // ->where('status', 'approved')   // ❌ DIHAPUS juga
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('products.by-category', [
            'category'          => $category,
            'products'          => $products,
            'categories'        => $categories,
            'currentCategoryId' => $category->id,
        ]);
    }

    /**
     * Detail produk:
     * route: /product/{product:slug}
     */
    public function show(Product $product)
    {
        // Kalau nanti kamu bikin kolom status di tabel products,
        // bagian ini boleh dipakai lagi dengan penyesuaian.
        // Untuk sekarang, cek ini aman-aman aja (status akan null).
        /*
        if ($product->status !== 'approved') {
            if (!auth()->check() || ! in_array(auth()->user()->role, ['admin', 'seller'])) {
                abort(404);
            }
        }
        */

        $product->load(['store', 'category']);

        return view('products.show', compact('product'));
    }
}
