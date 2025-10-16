<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Message;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalOrders' => Order::where('user_id', auth()->id())->count(),
            'pendingOrders' => Order::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'completedOrders' => Order::where('user_id', auth()->id())->where('status', 'delivered')->count(),
            'totalSpent' => Order::where('user_id', auth()->id())->where('payment_status', 'paid')->sum('total'),
            'wishlistCount' => Wishlist::where('user_id', auth()->id())->count(),
            'reviewsWritten' => Review::where('user_id', auth()->id())->count(),
            'unreadMessages' => Message::where('receiver_id', auth()->id())->whereNull('read_at')->count(),
        ];

        $recentOrders = Order::where('user_id', auth()->id())
            ->with(['seller', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = Review::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentOrders', 'recentReviews'));
    }
}
