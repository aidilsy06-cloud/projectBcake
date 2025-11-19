<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * List produk milik seller yang sedang login
     */
    public function index()
    {
        $products = Product::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        // folder kamu pakai huruf besar "Seller"
        return view('Seller.products.index', compact('products'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        return view('Seller.products.create');
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:products,slug',
            'price'       => 'required|integer|min:0',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // kalau mau pakai kategori nanti:
            // 'category_slug' => 'nullable|string|max:255',
        ]);

        // slug otomatis kalau kosong
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        }

        // set pemilik produk
        $data['user_id'] = auth()->id();

        // cari store milik user ini (1 seller 1 store)
        $storeId = Store::where('user_id', auth()->id())->value('id');
        $data['store_id'] = $storeId; // boleh NULL kalau belum punya toko

        // simpan gambar kalau ada
        if ($request->hasFile('image')) {
            // kita pakai kolom image_url yang sudah ada di DB
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit produk
     */
    public function edit(Product $product)
    {
        abort_unless($product->user_id === auth()->id(), 403);

        return view('Seller.products.edit', compact('product'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, Product $product)
    {
        abort_unless($product->user_id === auth()->id(), 403);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'price'       => 'required|integer|min:0',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // 'category_slug' => 'nullable|string|max:255',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        }

        // kalau upload gambar baru → hapus lama
        if ($request->hasFile('image')) {
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }

            $data['image_url'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk
     */
    public function destroy(Product $product)
    {
        abort_unless($product->user_id === auth()->id(), 403);

        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
