<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * List pesanan yang masuk ke toko seller ini.
     * Route: GET /seller/orders  -> name: seller.orders.index
     */
    public function index()
    {
        $user = Auth::user();

        // pastikan role-nya seller
        if (($user->role ?? null) !== 'seller') {
            abort(403);
        }

        // ambil toko milik seller
        $store = $user->store ?? Store::where('user_id', $user->id)->first();

        if (! $store) {
            // kalau belum punya toko, kasih tampilan kosong
            $orders = collect();

            return view('seller.orders.index', [
                'user'   => $user,
                'store'  => null,
                'orders' => $orders,
            ]);
        }

        // semua order untuk toko ini
        $orders = Order::where('store_id', $store->id)
            ->latest()
            ->paginate(10);

        return view('seller.orders.index', [
            'user'   => $user,
            'store'  => $store,
            'orders' => $orders,
        ]);
    }

    /**
     * Detail satu pesanan.
     * Route: GET /seller/orders/{order} -> name: seller.orders.show
     */
    public function show(Order $order)
    {
        $user = Auth::user();

        if (($user->role ?? null) !== 'seller') {
            abort(403);
        }

        $store = $user->store ?? Store::where('user_id', $user->id)->first();

        // pastikan order ini memang milik toko seller ini
        if (! $store || $order->store_id !== $store->id) {
            abort(403);
        }

        // kalau di model ada relasi items(), kita bisa eager load
        $order->loadMissing('items');

        return view('seller.orders.show', [
            'user'  => $user,
            'store' => $store,
            'order' => $order,
        ]);
    }

    /**
     * Update status pesanan (pending / diproses / dikirim / selesai / dibatalkan).
     * Route: POST /seller/orders/{order}/status -> name: seller.orders.updateStatus
     */
    public function updateStatus(Request $request, Order $order)
    {
        $user = Auth::user();

        if (($user->role ?? null) !== 'seller') {
            abort(403);
        }

        $store = $user->store ?? Store::where('user_id', $user->id)->first();

        if (! $store || $order->store_id !== $store->id) {
            abort(403);
        }

        $data = $request->validate([
            'status' => ['required', 'in:pending,diproses,dikirim,selesai,dibatalkan'],
        ]);

        $order->status = $data['status'];
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
