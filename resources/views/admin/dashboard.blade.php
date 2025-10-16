@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-blue-800">Total Users</h3>
                <p class="text-3xl font-bold text-blue-900 mt-2">{{ $stats['totalUsers'] }}</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-green-800">Total Products</h3>
                <p class="text-3xl font-bold text-green-900 mt-2">{{ $stats['totalProducts'] }}</p>
                <p class="text-sm text-green-700 mt-1">{{ $stats['pendingProducts'] }} pending approval</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-yellow-800">Total Orders</h3>
                <p class="text-3xl font-bold text-yellow-900 mt-2">{{ $stats['totalOrders'] }}</p>
            </div>
            <div class="bg-purple-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-purple-800">Total Revenue</h3>
                <p class="text-3xl font-bold text-purple-900 mt-2">RM {{ number_format($stats['totalRevenue'], 2) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="bg-white p-4 rounded border">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold">{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">RM {{ number_format($order->total, 2) }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.orders.index') }}" class="block mt-4 text-blue-600 hover:underline">View all orders →</a>
            </div>

            <!-- Top Sellers -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-xl font-bold mb-4">Top Sellers</h2>
                <div class="space-y-4">
                    @foreach($topSellers as $seller)
                        <div class="bg-white p-4 rounded border">
                            <p class="font-semibold">{{ $seller->shop_name }}</p>
                            <div class="flex justify-between text-sm text-gray-600 mt-2">
                                <span>{{ $seller->products_count }} products</span>
                                <span>{{ $seller->orders_count }} orders</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.customers.index') }}" class="bg-indigo-600 text-white p-6 rounded-lg hover:bg-indigo-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="font-semibold">Manage Customers</h3>
            </a>
            <a href="{{ route('admin.sellers.index') }}" class="bg-blue-600 text-white p-6 rounded-lg hover:bg-blue-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="font-semibold">Manage Sellers</h3>
                <p class="text-sm mt-2">{{ $stats['pendingSellers'] }} pending</p>
            </a>
            <a href="{{ route('admin.products.index') }}" class="bg-green-600 text-white p-6 rounded-lg hover:bg-green-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <h3 class="font-semibold">Manage Products</h3>
                <p class="text-sm mt-2">{{ $stats['pendingProducts'] }} pending</p>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="bg-purple-600 text-white p-6 rounded-lg hover:bg-purple-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <h3 class="font-semibold">Categories</h3>
            </a>
            <a href="{{ route('admin.tickets.index') }}" class="bg-yellow-600 text-white p-6 rounded-lg hover:bg-yellow-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <h3 class="font-semibold">Support Tickets</h3>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="bg-pink-600 text-white p-6 rounded-lg hover:bg-pink-700 text-center transition">
                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="font-semibold">Reports</h3>
            </a>
        </div>
    </div>
</div>
@endsection

