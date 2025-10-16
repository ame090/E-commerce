<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->seller;
        $products = $seller->products()->with('category')->latest()->paginate(20);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $seller = auth()->user()->seller;

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        Product::create([
            'seller_id' => $seller->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'stock' => $request->stock,
            'sku' => $request->sku,
            'images' => $images,
            'status' => 'pending',
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully. Waiting for admin approval.');
    }

    public function edit(Product $product)
    {
        if ($product->seller_id !== auth()->user()->seller->id) {
            abort(403);
        }

        $categories = Category::where('is_active', true)->get();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== auth()->user()->seller->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = $product->images ?? [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'stock' => $request->stock,
            'sku' => $request->sku,
            'images' => $images,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->seller_id !== auth()->user()->seller->id) {
            abort(403);
        }

        $product->delete();
        return back()->with('success', 'Product deleted');
    }
}
