@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">My Dashboard</h1>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-lg text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium opacity-90">Total Orders</h3>
                        <p class="text-3xl font-bold mt-2">{{ $stats['totalOrders'] }}</p>
                    </div>
                    <svg class="h-12 w-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-sm mt-2 text-blue-100">{{ $stats['pendingOrders'] }} pending</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-lg text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium opacity-90">Total Spent</h3>
                        <p class="text-3xl font-bold mt-2">RM {{ number_format($stats['totalSpent'], 2) }}</p>
                    </div>
                    <svg class="h-12 w-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm mt-2 text-green-100">From {{ $stats['completedOrders'] }} completed orders</p>
            </div>

            <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-6 rounded-lg text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium opacity-90">Wishlist Items</h3>
                        <p class="text-3xl font-bold mt-2">{{ $stats['wishlistCount'] }}</p>
                    </div>
                    <svg class="h-12 w-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <a href="{{ route('wishlist.index') }}" class="text-sm mt-2 text-pink-100 hover:underline block">View Wishlist →</a>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-lg text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium opacity-90">Messages</h3>
                        <p class="text-3xl font-bold mt-2">{{ $stats['unreadMessages'] }}</p>
                    </div>
                    <svg class="h-12 w-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <a href="{{ route('chat.index') }}" class="text-sm mt-2 text-purple-100 hover:underline block">Check Messages →</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Recent Orders</h2>
                    <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline text-sm">View All →</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                        <div class="bg-gray-50 p-4 rounded border">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->seller->shop_name }}</p>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 
                                       ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-600">{{ $order->items->count() }} items</p>
                                <p class="font-bold text-blue-600">RM {{ number_format($order->total, 2) }}</p>
                            </div>
                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 text-sm hover:underline mt-2 block">View Details →</a>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No orders yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">My Reviews</h2>
                    <span class="text-sm text-gray-600">{{ $stats['reviewsWritten'] }} total</span>
                </div>
                <div class="space-y-4">
                    @forelse($recentReviews as $review)
                        <div class="bg-gray-50 p-4 rounded border">
                            <div class="flex items-start space-x-3">
                                @if($review->product->images && count($review->product->images) > 0)
                                    <img src="{{ asset('storage/' . $review->product->images[0]) }}" alt="{{ $review->product->name }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded"></div>
                                @endif
                                <div class="flex-1">
                                    <p class="font-semibold text-sm text-gray-900">{{ $review->product->name }}</p>
                                    <div class="text-yellow-400 text-sm my-1">
                                        {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                    </div>
                                    <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($review->comment, 60) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No reviews yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('products.index') }}" class="bg-blue-600 text-white p-6 rounded-lg hover:bg-blue-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="font-semibold">Browse Products</h3>
            </a>
            <a href="{{ route('orders.index') }}" class="bg-green-600 text-white p-6 rounded-lg hover:bg-green-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="font-semibold">My Orders</h3>
            </a>
            <a href="{{ route('chat.index') }}" class="bg-purple-600 text-white p-6 rounded-lg hover:bg-purple-700 text-center transition relative">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="font-semibold">Messages</h3>
                @if($stats['unreadMessages'] > 0)
                    <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full">{{ $stats['unreadMessages'] }}</span>
                @endif
            </a>
            <a href="{{ route('tickets.create') }}" class="bg-yellow-600 text-white p-6 rounded-lg hover:bg-yellow-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h3 class="font-semibold">Get Support</h3>
            </a>
        </div>
    </div>
</div>
@endsection
