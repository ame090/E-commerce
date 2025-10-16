<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalSellers' => Seller::where('status', 'approved')->count(),
            'pendingSellers' => Seller::where('status', 'pending')->count(),
            'totalProducts' => Product::where('status', 'approved')->count(),
            'pendingProducts' => Product::where('status', 'pending')->count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('payment_status', 'paid')->sum('total'),
        ];

        $recentOrders = Order::with(['user', 'seller.user'])
            ->latest()
            ->take(10)
            ->get();

        $topSellers = Seller::withCount(['products', 'orders'])
            ->having('orders_count', '>', 0)
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topSellers'));
    }
}
