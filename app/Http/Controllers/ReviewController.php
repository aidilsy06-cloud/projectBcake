<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Simpan / update ulasan untuk sebuah produk.
     * Route: POST /products/{product}/reviews
     */
    public function store(Request $request, Product $product)
    {
        // Pastikan user sudah login (kalau pakai middleware auth di route, ini aman)
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk menulis ulasan.');
        }

        // Validasi input
        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // OPTIONAL: kalau mau 1 user cuma boleh 1 ulasan per produk,
        // kita pakai updateOrCreate
        Review::updateOrCreate(
            [
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
            ],
            [
                'rating'  => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ]
        );

        return back()->with('success', 'Terima kasih, ulasanmu sudah tersimpan! 💕');
    }
}
