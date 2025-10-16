<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index()
    {
        // Overall Statistics
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalSellers = Seller::where('status', 'approved')->count();

        // Revenue by Month (Last 12 months)
        $revenueByMonth = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Orders by Status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Top Sellers by Revenue
        $topSellers = Seller::select('sellers.*', DB::raw('SUM(orders.total) as total_revenue'))
            ->join('orders', 'sellers.id', '=', 'orders.seller_id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('sellers.id')
            ->orderBy('total_revenue', 'desc')
            ->take(10)
            ->get();

        // Top Products by Sales
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        // Recent Orders
        $recentOrders = Order::with(['user', 'seller'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'totalSellers',
            'revenueByMonth',
            'ordersByStatus',
            'topSellers',
            'topProducts',
            'recentOrders'
        ));
    }
}
