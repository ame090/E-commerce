@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- Admin Preview Notice -->
        @auth
            @if(auth()->user()->isAdmin() && $product->status !== 'approved')
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <span class="font-semibold">Admin Preview Mode:</span> This product is currently 
                                <span class="font-semibold px-2 py-1 rounded {{ $product->status == 'pending' ? 'bg-yellow-200' : 'bg-red-200' }}">
                                    {{ strtoupper($product->status) }}
                                </span> 
                                and not visible to customers.
                                @if($product->status == 'pending')
                                    <a href="{{ route('admin.products.index') }}" class="ml-4 underline font-semibold">Go to Admin Panel to Approve</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Product Images -->
            <div>
                @if($product->images && count($product->images) > 0)
                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">No Image</div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-center mb-4">
                    <span class="text-yellow-400 text-xl">★</span>
                    <span class="text-lg ml-2">{{ number_format($product->getAverageRating(), 1) }}</span>
                    <span class="text-gray-600 ml-2">({{ $product->getTotalReviews() }} reviews)</span>
                </div>

                <div class="mb-6">
                    <div class="flex items-center space-x-4">
                        <span class="text-4xl font-bold text-teal-600">RM {{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price)
                            <span class="text-2xl text-gray-500 line-through">RM {{ number_format($product->compare_price, 2) }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600">Category: <span class="font-semibold">{{ $product->category->name }}</span></p>
                    <p class="text-sm text-gray-600">Sold by: <span class="font-semibold">{{ $product->seller->shop_name }}</span></p>
                    <p class="text-sm text-gray-600">Stock: <span class="font-semibold {{ $product->inStock() ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock }} available</span></p>
                </div>

                @auth
                    @if(auth()->user()->isAdmin())
                        <!-- Admin Actions -->
                        <div class="bg-purple-50 border-2 border-purple-200 p-4 rounded-lg mb-4">
                            <h3 class="font-semibold text-purple-900 mb-3">Admin Actions</h3>
                            @if($product->status == 'pending')
                                <div class="flex space-x-2">
                                    <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 font-semibold">
                                            ✓ Approve Product
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.reject', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-md hover:bg-red-700 font-semibold" onclick="return confirm('Reject this product?')">
                                            ✗ Reject Product
                                        </button>
                                    </form>
                                </div>
                            @else
                                <p class="text-sm text-purple-700">Product Status: <span class="font-semibold">{{ ucfirst($product->status) }}</span></p>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('admin.products.index') }}" class="text-purple-700 hover:text-purple-900 text-sm font-medium">← Back to Admin Product Management</a>
                            </div>
                        </div>
                    @endif

                    @if(!auth()->user()->isAdmin())
                        @if($product->inStock())
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="flex items-center space-x-4 mb-4">
                                    <label for="quantity" class="text-sm font-medium">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-20 rounded-md border-gray-300">
                                </div>
                                <div class="flex space-x-4">
                                    <button type="submit" class="flex-1 bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700 font-semibold">Add to Cart</button>
                                </div>
                            </form>
                            <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="mb-4">
                                @csrf
                                <button type="submit" class="w-full bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300 flex items-center justify-center space-x-2">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span>Add to Wishlist</span>
                                </button>
                            </form>
                        @else
                            <p class="text-red-600 font-semibold mb-4">Out of Stock</p>
                        @endif
                        
                        <!-- Contact Seller -->
                        <a href="{{ route('chat.contact', $product) }}" class="w-full bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 font-semibold flex items-center justify-center space-x-2">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>Contact Seller</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block bg-emerald-600 text-white text-center px-6 py-3 rounded-md hover:bg-emerald-700 font-semibold">Login to Purchase</a>
                @endauth
            </div>
        </div>

        <!-- Reviews -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>
            @if($product->reviews->count() > 0)
                <div class="space-y-4">
                    @foreach($product->reviews as $review)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <span class="font-semibold">{{ $review->user->name }}</span>
                                <span class="ml-4 text-yellow-400">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            </div>
                            <p class="text-gray-700">{{ $review->comment }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
            @endif
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                            <a href="{{ route('products.show', $related->slug) }}">
                                @if($related->images && count($related->images) > 0)
                                    <img src="{{ asset('storage/' . $related->images[0]) }}" alt="{{ $related->name }}" class="w-full h-48 object-cover rounded-t-lg">
                                @else
                                    <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center text-gray-400">No Image</div>
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold mb-2">{{ $related->name }}</h3>
                                    <span class="text-lg font-bold text-teal-600">RM {{ number_format($related->price, 2) }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

