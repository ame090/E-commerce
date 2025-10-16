@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Seller Dashboard</h1>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-blue-800">Total Products</h3>
                <p class="text-3xl font-bold text-blue-900 mt-2">{{ $stats['totalProducts'] }}</p>
                <p class="text-sm text-blue-700 mt-1">{{ $stats['activeProducts'] }} active</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-green-800">Total Orders</h3>
                <p class="text-3xl font-bold text-green-900 mt-2">{{ $stats['totalOrders'] }}</p>
                <p class="text-sm text-green-700 mt-1">{{ $stats['pendingOrders'] }} pending</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-yellow-800">Total Revenue</h3>
                <p class="text-3xl font-bold text-yellow-900 mt-2">RM {{ number_format($stats['totalRevenue'], 2) }}</p>
            </div>
            <div class="bg-purple-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-purple-800">Current Balance</h3>
                <p class="text-3xl font-bold text-purple-900 mt-2">RM {{ number_format($stats['balance'], 2) }}</p>
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
                            <a href="{{ route('seller.orders.show', $order) }}" class="text-blue-600 text-sm hover:underline mt-2 block">View Details →</a>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('seller.orders.index') }}" class="block mt-4 text-blue-600 hover:underline">View all orders →</a>
            </div>

            <!-- Top Products -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-xl font-bold mb-4">Top Products</h2>
                <div class="space-y-4">
                    @foreach($topProducts as $product)
                        <div class="bg-white p-4 rounded border">
                            <p class="font-semibold">{{ $product->name }}</p>
                            <div class="flex justify-between text-sm text-gray-600 mt-2">
                                <span>RM {{ number_format($product->price, 2) }}</span>
                                <span>{{ $product->order_items_count }} sold</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('seller.products.create') }}" class="bg-blue-600 text-white p-6 rounded-lg hover:bg-blue-700 text-center">
                <h3 class="font-semibold">Add New Product</h3>
            </a>
            <a href="{{ route('seller.products.index') }}" class="bg-green-600 text-white p-6 rounded-lg hover:bg-green-700 text-center">
                <h3 class="font-semibold">Manage Products</h3>
            </a>
            <a href="{{ route('seller.orders.index') }}" class="bg-purple-600 text-white p-6 rounded-lg hover:bg-purple-700 text-center">
                <h3 class="font-semibold">Manage Orders</h3>
            </a>
        </div>
    </div>
</div>
@endsection

