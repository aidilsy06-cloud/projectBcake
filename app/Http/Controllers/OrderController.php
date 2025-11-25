<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * RIWAYAT PESANAN BUYER
     * Route: GET /buyer/orders   -> name: buyer.orders.index
     */
    public function index()
    {
        $userId = Auth::id();

        $orders = Order::with('store')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        // View: resources/views/orders/index.blade.php
        return view('orders.index', compact('orders'));
    }

    /**
     * Simpan pesanan + redirect ke halaman sukses
     * (WhatsApp dibuka dari halaman sukses).
     * Route: POST /store/{store:slug}/order -> name: stores.order
     */
    public function store(Request $request, Store $store)
    {
        // Pastikan user login
        $userId = Auth::id();
        if (!$userId) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk melakukan pemesanan.');
        }

        // 1. Validasi input dari form checkout
        $data = $request->validate([
            'customer_name'    => ['required', 'string', 'max:100'],
            'customer_phone'   => ['required', 'string', 'max:30'],
            'customer_address' => ['nullable', 'string', 'max:255'],
            'order_summary'    => ['required', 'string'], // ringkasan pesanan (dari keranjang)
            'note'             => ['nullable', 'string'],
            // kalau form checkout mengirim total harga:
            // <input type="hidden" name="total_price" value="{{ $total }}">
            'total_price'      => ['nullable', 'numeric', 'min:0'],
        ]);

        // 1.1 Hitung total_price kalau tidak dikirim dari form
        $totalPrice = $data['total_price'] ?? null;

        if ($totalPrice === null) {
            $totalPrice = DB::table('cart_items')
                ->join('products', 'cart_items.product_id', '=', 'products.id')
                ->where('cart_items.user_id', $userId)
                ->sum(DB::raw('cart_items.qty * products.price'));
        }

        // fallback kalau tetap null
        $totalPrice = $totalPrice ?? 0;

        // 1.2 Cek keranjang kosong
        $cartItems = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select(
                'cart_items.product_id',
                'cart_items.qty',
                'products.name as product_name',
                'products.price'
            )
            ->where('cart_items.user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang kamu masih kosong. Tambahkan produk dulu ya 🍰');
        }

        DB::beginTransaction();

        try {
            // 2. Simpan ke database (riwayat order utama)
            $order = Order::create([
                'user_id'          => $userId,
                'store_id'         => $store->id,
                'customer_name'    => $data['customer_name'],
                'customer_phone'   => $data['customer_phone'],
                'customer_address' => $data['customer_address'] ?? null,
                'order_summary'    => $data['order_summary'],
                'note'             => $data['note'] ?? null,
                // status awal untuk tracking
                // nanti bisa diubah jadi: pending → diproses → dikirim → selesai / dibatalkan
                'status'           => 'pending',
                'wa_sent_at'       => now(),
                'total_price'      => $totalPrice,
            ]);

            // 2.1 Simpan item per-produk ke order_items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product_name,
                    'price'        => $item->price,
                    'qty'          => $item->qty,
                    'subtotal'     => $item->price * $item->qty,
                ]);
            }

            // 2.5 Kosongkan keranjang user setelah order dibuat
            DB::table('cart_items')
                ->where('user_id', $userId)
                ->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            // Catat error ke log biar gampang dicek di storage/logs/laravel.log
            \Log::error('Gagal membuat pesanan B’cake', [
                'user_id'  => $userId,
                'store_id' => $store->id ?? null,
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            // Kalau di mode debug (APP_DEBUG=true), biar error asli kelihatan untuk developer
            if (config('app.debug')) {
                throw $e;
            }

            // Kalau di production, kasih pesan general
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }

        // 3. Siapkan nomor WhatsApp penjual (dari kolom stores.whatsapp)
        $rawNumber = $store->whatsapp ?? '';

        // bersihkan biar cuma angka
        $waNumber = preg_replace('/\D+/', '', $rawNumber ?? '');

        // kalau pakai 08xxx → ubah ke 62xxx
        if ($waNumber && str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }

        // fallback kalau kosong: arahkan balik ke halaman toko
        if (empty($waNumber)) {
            return redirect()
                ->route('stores.show', $store)
                ->with('error', 'Nomor WhatsApp toko belum diatur. Hubungi penjual secara manual ya ✨');
        }

        // 4. Susun pesan WhatsApp
        $messageLines = [
            "Bismillah, kak {$store->name} ✨",
            "Aku mau pesan lewat B’cake 🍰",
            "",
            "👤 Nama     : {$data['customer_name']}",
            "📱 WhatsApp : {$data['customer_phone']}",
        ];

        if (!empty($data['customer_address'])) {
            $messageLines[] = "📍 Alamat   : {$data['customer_address']}";
        }

        $messageLines[] = "";
        $messageLines[] = "🧁 Detail Pesanan:";
        $messageLines[] = $data['order_summary'];

        if (!empty($data['note'])) {
            $messageLines[] = "";
            $messageLines[] = "📝 Catatan Tambahan:";
            $messageLines[] = $data['note'];
        }

        if ($totalPrice > 0) {
            $messageLines[] = "";
            $messageLines[] = "💰 Estimasi Total: Rp " . number_format($totalPrice, 0, ',', '.');
        }

        $messageLines[] = "";
        $messageLines[] = "Kode pesanan: #ORD{$order->id}";
        $messageLines[] = "Dibuat otomatis via B’cake Marketplace 💕";

        $message = implode("\n", $messageLines);

        // 5. Siapkan URL WA
        $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($message);

        // Simpan URL WA di session supaya bisa dipakai di halaman sukses
        return redirect()
            ->route('orders.success', $order)
            ->with('wa_url', $waUrl);
    }

    /**
     * Halaman sukses setelah pesanan dibuat.
     * Route: GET /orders/{order}/success -> name: orders.success
     */
    public function success(Order $order)
    {
        // optional: batasi supaya hanya buyer pemilik yang bisa lihat halaman ini
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $store = $order->store;      // relasi store() di model Order
        $waUrl = session('wa_url');  // bisa null kalau tidak ada

        // View: resources/views/orders/success.blade.php
        return view('orders.success', compact('order', 'store', 'waUrl'));
    }
}
