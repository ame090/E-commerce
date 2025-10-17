@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">My Wishlist</h1>

        @if($wishlists->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($wishlists as $wishlist)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <a href="{{ route('products.show', $wishlist->product->slug) }}">
                            @if($wishlist->product->images && count($wishlist->product->images) > 0)
                                <img src="{{ asset('storage/' . $wishlist->product->images[0]) }}" alt="{{ $wishlist->product->name }}" class="w-full h-48 object-cover rounded-t-lg">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">{{ $wishlist->product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">by {{ $wishlist->product->seller->shop_name }}</p>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xl font-bold text-teal-600">RM {{ number_format($wishlist->product->price, 2) }}</span>
                                    @if($wishlist->product->inStock())
                                        <span class="text-sm text-green-600">In Stock</span>
                                    @else
                                        <span class="text-sm text-red-600">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        
                        <div class="px-4 pb-4 flex space-x-2">
                            @if($wishlist->product->inStock())
                                <form action="{{ route('cart.add', $wishlist->product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 text-sm">Add to Cart</button>
                                </form>
                            @endif
                            
                            <form action="{{ route('wishlist.toggle', $wishlist->product) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-100 text-red-600 px-4 py-2 rounded hover:bg-red-200" title="Remove from wishlist">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-600 mt-4">Your wishlist is empty</h2>
                <p class="text-gray-500 mt-2">Save products you love for later</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700">Browse Products</a>
            </div>
        @endif
    </div>
</div>
@endsection

