@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Reports & Analytics</h1>

        <!-- Overall Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-lg text-white shadow-lg">
                <h3 class="text-sm font-medium opacity-90">Total Revenue</h3>
                <p class="text-3xl font-bold mt-2">RM {{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-lg text-white shadow-lg">
                <h3 class="text-sm font-medium opacity-90">Total Orders</h3>
                <p class="text-3xl font-bold mt-2">{{ number_format($totalOrders) }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-lg text-white shadow-lg">
                <h3 class="text-sm font-medium opacity-90">Total Products</h3>
                <p class="text-3xl font-bold mt-2">{{ number_format($totalProducts) }}</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-6 rounded-lg text-white shadow-lg">
                <h3 class="text-sm font-medium opacity-90">Total Customers</h3>
                <p class="text-3xl font-bold mt-2">{{ number_format($totalCustomers) }}</p>
            </div>
            <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-6 rounded-lg text-white shadow-lg">
                <h3 class="text-sm font-medium opacity-90">Active Sellers</h3>
                <p class="text-3xl font-bold mt-2">{{ number_format($totalSellers) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Revenue by Month -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Revenue Trend (Last 12 Months)</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Orders</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($revenueByMonth as $data)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ \Carbon\Carbon::parse($data->month . '-01')->format('M Y') }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $data->orders }}</td>
                                    <td class="px-4 py-2 text-sm font-semibold text-green-600">RM {{ number_format($data->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-sm text-gray-500 text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Orders by Status -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Orders by Status</h2>
                <div class="space-y-4">
                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'] as $status)
                        @php
                            $count = $ordersByStatus[$status] ?? 0;
                            $percentage = $totalOrders > 0 ? ($count / $totalOrders) * 100 : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium">{{ ucfirst($status) }}</span>
                                <span class="text-sm font-bold">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $status == 'delivered' ? 'bg-green-500' : ($status == 'cancelled' ? 'bg-red-500' : 'bg-blue-500') }}" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Top Sellers -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Top Sellers by Revenue</h2>
                <div class="space-y-3">
                    @forelse($topSellers as $index => $seller)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-gray-400 mr-3">#{{ $index + 1 }}</span>
                                <div>
                                    <p class="font-semibold">{{ $seller->shop_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $seller->user->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600">RM {{ number_format($seller->total_revenue, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No sales data available</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Top Products by Sales</h2>
                <div class="space-y-3">
                    @forelse($topProducts as $index => $product)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-gray-400 mr-3">#{{ $index + 1 }}</span>
                                <div>
                                    <p class="font-semibold">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $product->seller->shop_name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-600">{{ $product->total_sold }} sold</p>
                                <p class="text-sm text-gray-600">RM {{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No sales data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Seller</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-4 py-2 text-sm font-medium">{{ $order->order_number }}</td>
                                <td class="px-4 py-2 text-sm">{{ $order->user->name }}</td>
                                <td class="px-4 py-2 text-sm">{{ $order->seller->shop_name }}</td>
                                <td class="px-4 py-2 text-sm font-semibold">RM {{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 
                                           ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-sm text-gray-500 text-center">No orders yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

