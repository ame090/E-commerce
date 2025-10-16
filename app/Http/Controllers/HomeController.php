<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->where('status', 'approved')
            ->with(['seller', 'category'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->where('status', 'approved')
            ->with(['seller', 'category'])
            ->latest()
            ->take(12)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}
