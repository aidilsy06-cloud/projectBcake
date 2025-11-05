<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;

class SellerDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.seller', [
            'my_products' => Product::count(), // nanti diganti where('seller_id', auth()->id())
        ]);
    }
}
