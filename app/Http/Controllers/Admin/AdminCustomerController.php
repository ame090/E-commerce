<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount(['orders', 'reviews', 'wishlists'])
            ->latest()
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->load(['orders.seller', 'reviews.product', 'wishlists.product']);

        $stats = [
            'totalOrders' => $customer->orders()->count(),
            'totalSpent' => $customer->orders()->where('payment_status', 'paid')->sum('total'),
            'totalReviews' => $customer->reviews()->count(),
            'wishlistCount' => $customer->wishlists()->count(),
        ];

        return view('admin.customers.show', compact('customer', 'stats'));
    }

    public function toggleStatus(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->is_active = !$customer->is_active;
        $customer->save();

        return back()->with('success', 'Customer status updated');
    }
}
