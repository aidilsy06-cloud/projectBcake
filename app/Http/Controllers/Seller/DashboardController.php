<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Kalau seller buka /seller → langsung diarahkan ke katalog produk pink
        return redirect()->route('seller.products.index');
    }
}
