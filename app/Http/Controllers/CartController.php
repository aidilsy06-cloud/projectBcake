<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    private function getCart(): array { return session('cart', []); }
    private function saveCart(array $cart): void {
        session(['cart' => $cart]);
        session(['cart_count' => array_sum(array_map(fn($r)=>$r['qty'],$cart))]);
    }

    public function index() {
        $cart  = $this->getCart();
        $total = collect($cart)->sum(fn($r)=> $r['product']->price * $r['qty']);
        return view('cart.index', compact('cart','total'));
    }

    public function add(Request $request, Product $product) {
        $qty  = max(1, (int) $request->input('qty', 1));
        $cart = $this->getCart();
        $key  = $product->slug;

        if (!isset($cart[$key])) $cart[$key] = ['product'=>$product, 'qty'=>0];
        $cart[$key]['qty'] += $qty;

        $this->saveCart($cart);
        return back()->with('ok', 'Ditambahkan ke keranjang');
    }

    public function remove(Product $product) {
        $cart = $this->getCart();
        unset($cart[$product->slug]);
        $this->saveCart($cart);
        return back()->with('ok', 'Item dihapus');
    }

    public function update(Request $request) {
        $cart = $this->getCart();
        foreach ((array) $request->input('qty', []) as $slug => $qty) {
            if (isset($cart[$slug])) $cart[$slug]['qty'] = max(1, (int)$qty);
        }
        $this->saveCart($cart);
        return back()->with('ok', 'Keranjang diperbarui!');
    }
}
