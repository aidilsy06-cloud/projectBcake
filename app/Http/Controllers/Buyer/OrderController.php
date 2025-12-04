<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $orders = Order::with(['items.product', 'store'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // pastikan buyer cuma bisa lihat order miliknya sendiri
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load(['items.product', 'store']);

        return view('buyer.orders.show', compact('order'));
    }
}
