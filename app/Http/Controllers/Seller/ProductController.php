<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Helper upload gambar produk ke public/storage/products.
     * Mengembalikan path relatif: "products/namafile.jpg"
     */
    protected function uploadProductImage(?\Illuminate\Http\UploadedFile $file, ?string $oldPath = null): ?string
    {
        if (! $file) {
            // tidak ada file baru → pakai path lama saja
            return $oldPath;
        }

        // hapus file lama kalau ada
        if ($oldPath) {
            $oldFull = public_path('storage/' . ltrim($oldPath, '/'));
            if (is_file($oldFull)) {
                @unlink($oldFull);
            }
        }

        // pastikan folder public/storage/products ada
        $uploadDir = public_path('storage/products');
        if (! is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext          = $file->getClientOriginalExtension();
        $safeName     = Str::slug($originalName);
        $filename     = time() . '_' . $safeName . '.' . $ext;

        // simpan langsung ke public/storage/products
        $file->move($uploadDir, $filename);

        // yang disimpan ke DB: "products/namafile.jpg"
        return 'products/' . $filename;
    }

    /**
     * Daftar produk milik seller yang login.
     */
    public function index(Request $request)
    {
        $user  = Auth::user();
        $store = $user->store;
        $role  = strtolower((string) ($user->role ?? ''));

        $query = Product::with('category');

        if ($role === 'admin') {
            // admin boleh lihat semua produk
        } else {
            // seller / role lain → hanya produk milik user
            $query->where('user_id', $user->id);

            if ($store) {
                $query->where('store_id', $store->id);
            }
        }

        // optional: filter status di query string ?status=pending|approved|rejected
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(15);

        // Folder view: resources/views/Seller/products/index.blade.php
        return view('Seller.products.index', compact('products'));
    }

    /**
     * Form tambah produk.
     */
    public function create()
    {
        $user = Auth::user();

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
        $store = $user->store; // relasi user->store

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        // upload gambar ke public/storage/products
        $imagePath = $this->uploadProductImage($request->file('image'));

        $slug = Str::slug($data['name']) . '-' . uniqid();

        Product::create([
            'user_id'     => $user->id,
            'store_id'    => $store?->id,
            'category_id' => $data['category_id'] ?? null,
            'name'        => $data['name'],
            'slug'        => $slug,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'description' => $data['description'] ?? null,
            'image_url'   => $imagePath,   // contoh: "products/goguma.png"
            'status'      => 'pending',    // menunggu verifikasi admin
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dikirim. Tunggu admin memverifikasi ya ✨');
    }

    /**
     * Pastikan user boleh mengakses produk ini.
     * - Admin: boleh semua
     * - Selain admin: hanya jika user_id sama
     */
    protected function authorizeProduct(Product $product): void
    {
        $user = Auth::user();
        $role = strtolower((string) ($user->role ?? ''));

        if ($role === 'admin') {
            return;
        }

        if ($product->user_id !== $user->id) {
            abort(403);
        }
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);

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
        $this->authorizeProduct($product);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        // upload baru (kalau ada), kalau tidak ada → pakai lama
        $imagePath = $this->uploadProductImage($request->file('image'), $product->image_url);

        // kalau sebelumnya approved dan di-edit, kembalikan ke pending
        $status = $product->status === 'approved' ? 'pending' : $product->status;

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
        $this->authorizeProduct($product);

        if ($product->image_url) {
            $full = public_path('storage/' . ltrim($product->image_url, '/'));
            if (is_file($full)) {
                @unlink($full);
            }
        }

        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
