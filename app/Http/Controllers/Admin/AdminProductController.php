<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['seller.user', 'category'])
            ->latest()
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function approve(Product $product)
    {
        $product->status = 'approved';
        $product->save();

        return back()->with('success', 'Product approved');
    }

    public function reject(Product $product)
    {
        $product->status = 'rejected';
        $product->save();

        return back()->with('success', 'Product rejected');
    }

    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();

        return back()->with('success', 'Product featured status updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted');
    }
}
