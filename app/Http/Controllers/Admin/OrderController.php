<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Daftar semua pesanan untuk admin.
     * Route: GET /admin/orders
     */
    public function index(Request $request)
    {
        // status dari query string (?status=pending)
        $status = $request->query('status', 'all');

        // base query untuk tabel
        $ordersQuery = Order::with('store')->latest();

        // kalau filter status bukan "all", tambahkan where
        if ($status !== 'all') {
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery->paginate(15);

        // STATISTIK (SELALU DARI SEMUA DATA, BUKAN YANG DIFILTER)
        $stats = [
            'total'    => Order::count(),
            'pending'  => Order::where('status', 'pending')->count(),
            'diproses' => Order::where('status', 'diproses')->count(),
            'dikirim'  => Order::where('status', 'dikirim')->count(),
            'selesai'  => Order::where('status', 'selesai')->count(),
            'batal'    => Order::where('status', 'dibatalkan')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'status'));
    }

    /**
     * Detail pesanan admin.
     * Route: GET /admin/orders/{order}
     */
    public function show(Order $order)
    {
        // pastikan relasi items & store sudah siap
        $order->load(['items', 'store']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan (admin).
     * Route: POST /admin/orders/{order}/status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,diproses,dikirim,selesai,dibatalkan'],
            'note'   => ['nullable', 'string', 'max:255'],
        ]);

        $order->status = $data['status'];
        if (!empty($data['note'])) {
            // kalau kamu punya kolom khusus, ganti ke nama yang sesuai
            $order->admin_note = $data['note'] ?? null;
        }
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui ✅');
    }
}
