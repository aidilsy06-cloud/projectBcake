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
        $query = Product::with(['store', 'category']);

        // 🔍 PENCARIAN ?q=
        $q = trim((string) $request->input('q', ''));
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhereHas('store', function ($s) use ($q) {
                        $s->where('name', 'like', "%{$q}%");
                    });
            });
        }

        // 🏷 FILTER KATEGORI ?category_id=
        $currentCategoryId = $request->input('category_id');
        if ($currentCategoryId) {
            $query->where('category_id', $currentCategoryId);
        }

        // 💰 FILTER HARGA ?price_range=
        $priceRange = $request->input('price_range'); // contoh: lt_10k, 10_25, 25_50, 50_100, gt_100
        if ($priceRange) {
            switch ($priceRange) {
                case 'lt_10k':
                    $query->where('price', '<', 10000);
                    break;
                case '10_25':
                    $query->whereBetween('price', [10000, 25000]);
                    break;
                case '25_50':
                    $query->whereBetween('price', [25001, 50000]);
                    break;
                case '50_100':
                    $query->whereBetween('price', [50001, 100000]);
                    break;
                case 'gt_100':
                    $query->where('price', '>', 100000);
                    break;
            }
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        // flag untuk tampilan "pencarian / filter tidak ditemukan"
        $notFound = (
            ($q !== '') ||
            !empty($currentCategoryId) ||
            !empty($priceRange)
        ) && $products->isEmpty();

        $categories = Category::orderBy('name')->get();

        return view('products.index', [
            'products'          => $products,
            'categories'        => $categories,
            'currentCategoryId' => $currentCategoryId,
            'q'                 => $q,
            'priceRange'        => $priceRange,
            'notFound'          => $notFound,
        ]);
    }

    /**
     * Halaman produk per kategori.
     */
    public function byCategory(Category $category, Request $request)
    {
        $products = Product::with(['store', 'category'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.by-category', [
            'category'          => $category,
            'products'          => $products,
            'categories'        => $categories,
            'currentCategoryId' => $category->id,
        ]);
    }

    /**
     * Detail produk.
     */
    public function show(Product $product)
    {
        $product->load(['store', 'category']);

        return view('products.show', compact('product'));
    }
}
