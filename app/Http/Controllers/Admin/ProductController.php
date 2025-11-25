<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk untuk admin
     * + filter berdasarkan status (optional)
     */
    public function index(Request $request)
    {
        $filter = $request->get('status'); // pending / approved / rejected / null

        $products = Product::with(['category', 'store'])
            ->when($filter, function ($query) use ($filter) {
                $query->where('status', $filter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Statistik status untuk badge di atas tabel
        $stats = [
            'pending'  => Product::where('status', 'pending')->count(),
            'approved' => Product::where('status', 'approved')->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
        ];

        return view('admin.products.index', [
            'products' => $products,
            'stats'    => $stats,
            'filter'   => $filter,
        ]);
    }

    /**
     * (Opsional) Form tambah produk dari sisi admin
     * Boleh kamu pakai atau diabaikan.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * (Opsional) Simpan produk baru yang dibuat admin
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
        ]);

        $slug = \Str::slug($data['name']) . '-' . uniqid();

        Product::create([
            'name'        => $data['name'],
            'slug'        => $slug,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'category_id' => $data['category_id'] ?? null,
            'description' => $data['description'] ?? null,
            'status'      => 'approved', // kalau admin yang buat, langsung aktif
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk baru berhasil dibuat.');
    }

    /**
     * Form edit produk (dari sisi admin)
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update detail produk (nama, harga, stok, kategori, deskripsi)
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
        ]);

        $product->update([
            'name'        => $data['name'],
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'category_id' => $data['category_id'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * 🔥 Verifikasi status produk
     * - pending  → approved / rejected
     * - approved → bisa di-nonaktifkan (rejected) kalau perlu
     */
    public function updateStatus(Request $request, Product $product)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $product->status = $data['status'];
        $product->save();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Status produk berhasil diperbarui.');
    }
}
