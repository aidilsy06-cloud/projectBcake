<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin', [
            'total_products' => Product::count(),
            'total_users'    => User::count(),
        ]);
    }
}
