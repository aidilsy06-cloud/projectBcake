<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Tampilkan keranjang
    public function index()
    {
        $userId = auth()->id();

        if (! $userId) {
            return redirect()->route('login');
        }

        $items = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        $total = $items->sum(function ($item) {
            return $item->product->price * $item->qty;
        });

        return view('cart.index', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    // Tambah ke keranjang
    public function add(Request $request, Product $product)
    {
        $userId = auth()->id();
        if (! $userId) {
            return redirect()->route('login');
        }

        $qty = max(1, (int) $request->input('qty', 1));

        // cek kalau item sudah ada → tambahkan qty
        $item = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->qty += $qty;
            $item->save();
        } else {
            CartItem::create([
                'user_id'    => $userId,
                'product_id' => $product->id,
                'qty'        => $qty,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk ditambahkan ke keranjang.');
    }

    // Update beberapa item (opsional, kalau nanti pakai form update)
    public function update(Request $request)
    {
        $userId = auth()->id();
        if (! $userId) {
            return redirect()->route('login');
        }

        $items = $request->input('items', []); // ['cart_item_id' => qty]

        foreach ($items as $itemId => $qty) {
            $qty = max(0, (int) $qty);

            $item = CartItem::where('user_id', $userId)
                ->where('id', $itemId)
                ->first();

            if (! $item) {
                continue;
            }

            if ($qty === 0) {
                $item->delete();
            } else {
                $item->qty = $qty;
                $item->save();
            }
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Keranjang diperbarui.');
    }

    // Hapus satu produk dari keranjang
    public function remove(Product $product)
    {
        $userId = auth()->id();
        if (! $userId) {
            return redirect()->route('login');
        }

        CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->delete();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk dihapus dari keranjang.');
    }
}
