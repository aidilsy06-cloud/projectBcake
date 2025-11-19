<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // HANYA role seller yang boleh membuka dashboard seller
        abort_unless(($user->role ?? null) === 'seller', 403);

        // Hitung total produk (sementara semua produk)
        // Jika nanti ada kolom seller_id, baru difilter
        // $myProducts = Product::where('seller_id', $user->id)->count();
        $myProducts = Product::count();

        // PENTING: gunakan view 'seller.dashboard'
        return view('seller.dashboard', [
            'user'        => $user,
            'my_products' => $myProducts,
        ]);
    }
}
