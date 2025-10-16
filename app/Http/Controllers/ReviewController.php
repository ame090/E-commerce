<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Order $order, Product $product)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if product is in the order
        $orderItem = $order->items()->where('product_id', $product->id)->first();
        
        if (!$orderItem) {
            abort(404, 'Product not found in this order');
        }

        // Check if already reviewed
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where('order_id', $order->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product');
        }

        return view('reviews.create', compact('order', 'product'));
    }

    public function store(Request $request, Order $order, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if product is in the order
        $orderItem = $order->items()->where('product_id', $product->id)->first();
        
        if (!$orderItem) {
            abort(404);
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('products.show', $product->slug)->with('success', 'Review submitted successfully');
    }
}
