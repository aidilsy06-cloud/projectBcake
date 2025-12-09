<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Daftar produk milik seller yang login.
     */
    public function index(Request $request)
    {
        $user  = Auth::user();
        $store = $user->store;

        $query = Product::with('category')
            ->where('user_id', $user->id);

        if ($store) {
            $query->where('store_id', $store->id);
        }

        // optional: filter status di query string ?status=pending|approved|rejected
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(15);

        return view('Seller.products.index', compact('products'));
    }

    /**
     * Form tambah produk.
     */
    public function create()
    {
        $user = Auth::user();

        // Kategori untuk dropdown
        $categories = Category::orderBy('name')->get();

        return view('Seller.products.create', [
            'categories' => $categories,
            'user'       => $user,
        ]);
    }

    /**
     * Simpan produk baru (status = pending → nunggu verifikasi admin).
     */
    public function store(Request $request)
    {
        $user  = Auth::user();
        $store = $user->store; // atau cara lain kamu ambil store seller

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        // upload gambar (kalau ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'private');
        }

        $slug = Str::slug($data['name']) . '-' . uniqid();

        $product = Product::create([
            'user_id'     => $user->id,
            'store_id'    => $store?->id,
            'category_id' => $data['category_id'] ?? null,
            'name'        => $data['name'],
            'slug'        => $slug,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'description' => $data['description'] ?? null,
            'image_url'   => $imagePath,
            'status'      => 'pending',   // menunggu verifikasi admin
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dikirim. Tunggu admin memverifikasi ya ✨');
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $user = Auth::user();

        // cuma cek role aja, gak cek user_id/store_id lagi
        abort_unless(in_array($user->role ?? null, ['seller', 'admin']), 403);

        $categories = Category::orderBy('name')->get();

        return view('Seller.products.edit', [
            'product'    => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update produk.
     */
    public function update(Request $request, Product $product)
    {
        $user = Auth::user();

        abort_unless(in_array($user->role ?? null, ['seller', 'admin']), 403);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $product->image_url;

        if ($request->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        // kalau sebelumnya approved dan di-edit, kita kembalikan ke pending
        $status = $product->status;
        if ($status === 'approved') {
            $status = 'pending';
        }

        $product->update([
            'category_id' => $data['category_id'] ?? null,
            'name'        => $data['name'],
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'description' => $data['description'] ?? null,
            'image_url'   => $imagePath,
            'status'      => $status,
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui. Menunggu verifikasi admin lagi ya ✨');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Product $product)
    {
        $user = Auth::user();

        abort_unless(in_array($user->role ?? null, ['seller', 'admin']), 403);

        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
