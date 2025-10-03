<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total'),
            'total_products' => Product::count(),
            'total_users' => User::where('role', 'user')->count(),
            'recent_orders' => Order::with('user', 'items')->latest()->take(5)->get(),
            'low_stock_products' => Product::where('stock', '<=', 5)->orderBy('stock')->take(10)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
