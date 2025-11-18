<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Simpan pesanan + redirect ke WhatsApp penjual.
     */
    public function store(Request $request, Store $store)
    {
        // 1. Validasi input dari form
        $data = $request->validate([
            'customer_name'    => ['required', 'string', 'max:100'],
            'customer_phone'   => ['required', 'string', 'max:30'],
            'customer_address' => ['nullable', 'string', 'max:255'],
            'order_summary'    => ['required', 'string'], // ringkasan pesanan (bisa dari keranjang)
            'note'             => ['nullable', 'string'],
        ]);

        // 2. Simpan ke database (riwayat order)
        $order = Order::create([
            'user_id'          => auth()->id(),
            'store_id'         => $store->id,
            'customer_name'    => $data['customer_name'],
            'customer_phone'   => $data['customer_phone'],
            'customer_address' => $data['customer_address'] ?? null,
            'order_summary'    => $data['order_summary'],
            'note'             => $data['note'] ?? null,
            'status'           => 'draft',
            'wa_sent_at'       => now(),
        ]);

        // 3. Siapkan nomor WhatsApp penjual
        //    Asumsi: ada kolom $store->whatsapp_number di tabel stores
        $rawNumber = $store->whatsapp_number ?? '';

        // bersihkan biar cuma angka
        $waNumber = preg_replace('/\D+/', '', $rawNumber);

        // kalau pakai 08xxx → ubah ke 62xxx
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }

        // fallback kalau kosong: arahkan ke landing B’cake saja
        if (empty($waNumber)) {
            return redirect()
                ->route('stores.show', $store->slug)
                ->with('error', 'Nomor WhatsApp toko belum diatur. Hubungi penjual secara manual ya ✨');
        }

        // 4. Susun pesan WhatsApp
        $messageLines = [
            "Halo kak {$store->name}, saya mau pesan lewat B’cake 🍰",
            "",
            "Nama: {$data['customer_name']}",
            "No. HP: {$data['customer_phone']}",
        ];

        if (!empty($data['customer_address'])) {
            $messageLines[] = "Alamat: {$data['customer_address']}";
        }

        $messageLines[] = "";
        $messageLines[] = "Pesanan:";
        $messageLines[] = $data['order_summary'];

        if (!empty($data['note'])) {
            $messageLines[] = "";
            $messageLines[] = "Catatan tambahan: {$data['note']}";
        }

        $messageLines[] = "";
        $messageLines[] = "Kode pesanan di B’cake: #ORD{$order->id}";

        $message = implode("\n", $messageLines);

        // 5. Redirect ke WA
        $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($message);

        // pakai redirect()->away biar Laravel nggak ngira ini route lokal
        return redirect()->away($waUrl);
    }
}
