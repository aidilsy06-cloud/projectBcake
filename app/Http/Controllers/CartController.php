<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua item keranjang milik user, include produk + toko
        $items = CartItem::with(['product.store'])
            ->where('user_id', $userId)
            ->get();

        // Hitung total
        $total = 0;
        foreach ($items as $item) {
            $total += $item->product->price * $item->qty;
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Tambah produk ke keranjang.
     * Route: POST /cart/add/{product}
     */
    public function add(Request $request, Product $product)
    {
        $userId = Auth::id();
        $qty    = (int) $request->input('qty', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        // Cek apakah item sudah ada di keranjang (user + product)
        $item = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            // Kalau sudah ada, tambahkan qty
            $item->qty += $qty;
            $item->save();
        } else {
            // Kalau belum ada, buat baru
            CartItem::create([
                'user_id'    => $userId,
                'product_id' => $product->id,
                'qty'        => $qty,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang 💗');
    }

    /**
     * Update banyak qty sekaligus.
     * Expektasi request: items[cart_item_id] = qty
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $items  = $request->input('items', []);

        foreach ($items as $cartItemId => $qty) {
            $qty = (int) $qty;

            $cartItem = CartItem::where('id', $cartItemId)
                ->where('user_id', $userId)
                ->first();

            if (! $cartItem) {
                continue;
            }

            // Jika qty <= 0, hapus; kalau > 0, update
            if ($qty <= 0) {
                $cartItem->delete();
            } else {
                $cartItem->qty = $qty;
                $cartItem->save();
            }
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Keranjang berhasil diperbarui ✨');
    }

    /**
     * Hapus satu item dari keranjang.
     * Route: DELETE /cart/item/{cartItem}
     */
    public function remove(CartItem $cartItem)
    {
        $userId = Auth::id();

        // Pastikan item milik user yang login
        if ($cartItem->user_id !== $userId) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item dihapus dari keranjang 🧺');
    }

    /**
     * Kosongkan seluruh keranjang user.
     */
    public function clear()
    {
        $userId = Auth::id();

        CartItem::where('user_id', $userId)->delete();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Keranjang sudah dikosongkan.');
    }

    /**
     * Halaman checkout: dari keranjang → form pemesanan → WhatsApp penjual.
     * Route: GET /cart/checkout
     */
    public function checkout()
    {
        $userId = Auth::id();

        // Ambil item keranjang
        $items = CartItem::with(['product.store'])
            ->where('user_id', $userId)
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjangmu masih kosong 💗');
        }

        // Asumsi satu keranjang = satu toko (semua produk dari toko yang sama)
        $firstItem = $items->first();
        $store     = $firstItem->product->store;

        // Susun ringkasan pesanan dan total
        $lines = [];
        $total = 0;

        foreach ($items as $item) {
            $product    = $item->product;
            $lineTotal  = $product->price * $item->qty;
            $total     += $lineTotal;

            $lines[] = "- {$item->qty}x {$product->name} (Rp " . number_format($lineTotal, 0, ',', '.') . ")";
        }

        $lines[] = "";
        $lines[] = "Total: Rp " . number_format($total, 0, ',', '.');

        // Text ini nanti dikirim ke field hidden `order_summary` → OrderController
        $orderSummaryText = implode("\n", $lines);

        return view('cart.checkout', [
            'items'            => $items,
            'store'            => $store,
            'total'            => $total,
            'orderSummaryText' => $orderSummaryText,
        ]);
    }
}
