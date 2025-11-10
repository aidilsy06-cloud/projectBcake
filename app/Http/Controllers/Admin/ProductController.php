<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:150'],
            'price' => ['required','numeric','min:0'],
            'image_url' => ['nullable','url'],
            'description' => ['nullable','string'],
        ]);

        $data['slug'] = Str::slug($data['name']).'-'.Str::random(5);

        Product::create($data);
        return redirect()->route('admin.products.index')->with('ok','Produk dibuat.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:150'],
            'price' => ['required','numeric','min:0'],
            'image_url' => ['nullable','url'],
            'description' => ['nullable','string'],
        ]);

        if ($data['name'] !== $product->name) {
            $data['slug'] = Str::slug($data['name']).'-'.Str::random(5);
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('ok','Produk diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('ok','Produk dihapus.');
    }
}
