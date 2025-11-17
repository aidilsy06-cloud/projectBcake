<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // =============== KATALOG PRODUK SELLER ===============
    public function index()
    {
        $user  = auth()->user();
        $store = $user->store ?? null;   // relasi user -> store

        $products = $store
            ? $store->products()->latest()->get()
            : collect();

        // tampilan katalog pink yang sudah kamu buat
        return view('seller.placeholders.products', compact('store', 'products'));
    }

    // =============== FORM TAMBAH PRODUK ===============
    public function create()
    {
        $user  = auth()->user();
        $store = $user->store ?? null;

        if (! $store) {
            return redirect()
                ->route('seller.dashboard')
                ->with('error', 'Lengkapi data toko dulu sebelum menambah produk.');
        }

        return view('seller.products.create', compact('store'));
    }

    // =============== SIMPAN PRODUK BARU ===============
    public function store(Request $request)
    {
        $user  = auth()->user();
        $store = $user->store ?? null;

        if (! $store) {
            return redirect()
                ->route('seller.dashboard')
                ->with('error', 'Lengkapi data toko dulu sebelum menambah produk.');
        }

        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'short_description' => 'nullable|string|max:500',
            'image_url'         => 'nullable|string|max:255',
        ]);

        // asumsi tabel products punya kolom: name, slug, price, short_description, image_url, store_id
        $data['slug']     = Str::slug($data['name']).'-'.uniqid();
        $data['store_id'] = $store->id;

        $store->products()->create($data);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // =============== FORM EDIT PRODUK ===============
    public function edit(Product $product)
    {
        $user  = auth()->user();
        $store = $user->store ?? null;

        // pastikan produk ini milik toko seller yang login
        if (! $store || $product->store_id !== $store->id) {
            abort(403, 'Kamu tidak boleh mengedit produk ini.');
        }

        return view('seller.products.edit', compact('store', 'product'));
    }

    // =============== UPDATE PRODUK ===============
    public function update(Request $request, Product $product)
    {
        $user  = auth()->user();
        $store = $user->store ?? null;

        if (! $store || $product->store_id !== $store->id) {
            abort(403, 'Kamu tidak boleh mengedit produk ini.');
        }

        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'short_description' => 'nullable|string|max:500',
            'image_url'         => 'nullable|string|max:255',
        ]);

        $data['slug'] = Str::slug($data['name']).'-'.uniqid();

        $product->update($data);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // =============== HAPUS PRODUK ===============
    public function destroy(Product $product)
    {
        $user  = auth()->user();
        $store = $user->store ?? null;

        if (! $store || $product->store_id !== $store->id) {
            abort(403, 'Kamu tidak boleh menghapus produk ini.');
        }

        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
