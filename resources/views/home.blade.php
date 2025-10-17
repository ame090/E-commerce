@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Our Multi-Vendor Marketplace</h1>
            <p class="text-xl mb-8">Discover thousands of products from verified sellers</p>
            <a href="{{ route('products.index') }}" class="bg-white text-teal-600 px-6 py-3 rounded-lg font-semibold hover:bg-teal-50">Browse Products</a>
        </div>
    </div>

    <!-- Categories -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold mb-8">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="bg-gray-100 hover:bg-gray-200 rounded-lg p-4 text-center">
                    <div class="text-4xl mb-2">📦</div>
                    <h3 class="font-semibold">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $category->products_count }} products</p>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
        <div class="bg-gray-50 py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold mb-8">Featured Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($featuredProducts as $product)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                            <a href="{{ route('products.show', $product->slug) }}">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-lg">
                                @else
                                    <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center text-gray-400">No Image</div>
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">by {{ $product->seller->shop_name }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xl font-bold text-teal-600">RM {{ number_format($product->price, 2) }}</span>
                                        @if($product->compare_price)
                                            <span class="text-sm text-gray-500 line-through">RM {{ number_format($product->compare_price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Latest Products -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold mb-8">Latest Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($latestProducts as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                    <a href="{{ route('products.show', $product->slug) }}">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-lg">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">by {{ $product->seller->shop_name }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-teal-600">RM {{ number_format($product->price, 2) }}</span>
                                @if($product->inStock())
                                    <span class="text-sm text-emerald-600">In Stock</span>
                                @else
                                    <span class="text-sm text-red-600">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

