<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Daftar produk milik seller ini.
     */
    public function index()
    {
        $user = Auth::user();

        // pastikan role-nya seller
        abort_unless(($user->role ?? null) === 'seller', 403);

        // ambil toko milik seller
        $store = $user->store ?? Store::where('user_id', $user->id)->first();

        // kalau belum punya toko, produk dikosongkan
        $products = collect();

        if ($store) {
            $products = Product::where('store_id', $store->id)
                ->latest()
                ->paginate(10);
        }

        return view('seller.products.index', compact('products', 'store'));
    }

    /**
     * Form tambah produk baru.
     */
    public function create()
    {
        $user = Auth::user();
        abort_unless(($user->role ?? null) === 'seller', 403);

        $store = $user->store ?? Store::where('user_id', $user->id)->first();

        if (! $store) {
            return redirect()
                ->route('seller.dashboard')
                ->with('error', 'Kamu belum punya toko. Lengkapi profil toko dulu ya ✨');
        }

        // ambil semua kategori untuk dropdown
        $categories = Category::orderBy('name')->get();

        return view('seller.products.create', [
            'store'      => $store,
            'categories' => $categories,
        ]);
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        abort_unless(($user->role ?? null) === 'seller', 403);

        $store = $user->store ?? Store::where('user_id', $user->id)->first();

        if (! $store) {
            return redirect()
                ->route('seller.dashboard')
                ->with('error', 'Kamu belum punya toko. Lengkapi profil toko dulu ya ✨');
        }

        // validasi input
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'integer', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // generate slug unik
        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // handle upload gambar (opsional)
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $imageUrl = '/storage/' . $path;   // pastikan sudah `php artisan storage:link`
        }

        // simpan produk
        Product::create([
            'user_id'     => $user->id,
            'store_id'    => $store->id,
            'category_id' => $data['category_id'],
            'name'        => $data['name'],
            'slug'        => $slug,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'image_url'   => $imageUrl,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk baru berhasil ditambahkan 🎂');
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $user = Auth::user();
        abort_unless(($user->role ?? null) === 'seller', 403);

        // pastikan produk ini milik toko seller
        $store = $user->store ?? Store::where('user_id', $user->id)->first();
        abort_unless($store && $product->store_id === $store->id, 403);

        $categories = Category::orderBy('name')->get();

        return view('seller.products.edit', [
            'product'    => $product,
            'store'      => $store,
            'categories' => $categories,
        ]);
    }

    /**
     * Update produk.
     */
    public function update(Request $request, Product $product)
    {
        $user = Auth::user();
        abort_unless(($user->role ?? null) === 'seller', 403);

        $store = $user->store ?? Store::where('user_id', $user->id)->first();
        abort_unless($store && $product->store_id === $store->id, 403);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'integer', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // kalau nama berubah, update slug juga (optional)
        if ($product->name !== $data['name']) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;

            while (
                Product::where('slug', $slug)
                    ->where('id', '!=', $product->id)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $product->slug = $slug;
        }

        // handle gambar baru
        if ($request->hasFile('image')) {
            // hapus gambar lama kalau ada
            if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('products', 'public');
            $product->image_url = '/storage/' . $path;
        }

        $product->name        = $data['name'];
        $product->price       = $data['price'];
        $product->stock       = $data['stock'];
        $product->category_id = $data['category_id'];
        $product->description = $data['description'] ?? null;

        $product->save();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui ✨');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Product $product)
    {
        $user = Auth::user();
        abort_unless(($user->role ?? null) === 'seller', 403);

        $store = $user->store ?? Store::where('user_id', $user->id)->first();
        abort_unless($store && $product->store_id === $store->id, 403);

        // hapus gambar
        if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
