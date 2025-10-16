<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->seller;

        if (!$seller) {
            return redirect()->route('seller.register');
        }

        if ($seller->status !== 'approved') {
            return view('seller.pending', compact('seller'));
        }

        $stats = [
            'totalProducts' => $seller->products()->count(),
            'activeProducts' => $seller->products()->where('is_active', true)->count(),
            'totalOrders' => $seller->orders()->count(),
            'pendingOrders' => $seller->orders()->where('status', 'pending')->count(),
            'totalRevenue' => $seller->orders()->where('payment_status', 'paid')->sum('total'),
            'balance' => $seller->balance,
        ];

        $recentOrders = $seller->orders()
            ->with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();

        $topProducts = $seller->products()
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }

    public function register()
    {
        if (auth()->user()->seller) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.register');
    }

    public function storeRegistration(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255|unique:sellers',
            'description' => 'nullable|string',
        ]);

        auth()->user()->seller()->create([
            'shop_name' => $request->shop_name,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Seller registration submitted. Waiting for admin approval.');
    }
}
