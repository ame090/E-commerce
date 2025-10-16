@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Products</h1>
        </div>

        <!-- Search and Filters -->
        <div class="mb-8 bg-gray-50 p-4 rounded-lg">
            <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <select name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Search</button>
            </form>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
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
                                <div class="flex items-center mb-2">
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-sm text-gray-600 ml-1">{{ number_format($product->getAverageRating(), 1) }} ({{ $product->getTotalReviews() }})</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-blue-600">RM {{ number_format($product->price, 2) }}</span>
                                    @if($product->inStock())
                                        <span class="text-sm text-green-600">In Stock</span>
                                    @else
                                        <span class="text-sm text-red-600">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">No products found.</p>
            </div>
        @endif
    </div>
</div>
@endsection

