<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.buyer');
    }
}
