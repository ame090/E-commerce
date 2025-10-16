<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->seller;
        
        $orders = $seller->orders()
            ->with(['user', 'items.product', 'payment'])
            ->latest()
            ->paginate(20);

        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->seller_id !== auth()->user()->seller->id) {
            abort(403);
        }

        $order->load(['user', 'items.product', 'payment']);
        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->seller_id !== auth()->user()->seller->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:processing,shipped,delivered',
            'tracking_number' => 'nullable|string',
        ]);

        $order->status = $request->status;
        if ($request->tracking_number) {
            $order->tracking_number = $request->tracking_number;
        }
        $order->save();

        return back()->with('success', 'Order status updated');
    }
}
