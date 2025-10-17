@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('admin.customers.index') }}" class="text-teal-600 hover:underline">← Back to Customers</a>
        </div>

        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $customer->name }}</h1>
                <p class="text-gray-600">Customer ID: {{ $customer->id }}</p>
            </div>
            <span class="px-4 py-2 rounded text-sm font-semibold
                {{ $customer->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $customer->is_active ? 'Active' : 'Suspended' }}
            </span>
        </div>

        <!-- Customer Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-blue-800">Total Orders</h3>
                <p class="text-3xl font-bold text-blue-900 mt-2">{{ $stats['totalOrders'] }}</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-green-800">Total Spent</h3>
                <p class="text-3xl font-bold text-green-900 mt-2">RM {{ number_format($stats['totalSpent'], 2) }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-yellow-800">Reviews Written</h3>
                <p class="text-3xl font-bold text-yellow-900 mt-2">{{ $stats['totalReviews'] }}</p>
            </div>
            <div class="bg-purple-100 p-6 rounded-lg">
                <h3 class="text-sm font-medium text-purple-800">Wishlist Items</h3>
                <p class="text-3xl font-bold text-purple-900 mt-2">{{ $stats['wishlistCount'] }}</p>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Customer Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-base font-semibold text-gray-900">{{ $customer->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Phone</p>
                    <p class="text-base font-semibold text-gray-900">{{ $customer->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Address</p>
                    <p class="text-base font-semibold text-gray-900">{{ $customer->address ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Member Since</p>
                    <p class="text-base font-semibold text-gray-900">{{ $customer->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Order History -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Order History</h2>
                <div class="space-y-4">
                    @forelse($customer->orders->take(10) as $order)
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
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                                <p class="font-bold text-teal-600">RM {{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No orders yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Reviews -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Recent Reviews</h2>
                <div class="space-y-4">
                    @forelse($customer->reviews->take(10) as $review)
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

        <!-- Actions -->
        <div class="mt-8 flex space-x-4">
            <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST">
                @csrf
                @if($customer->is_active)
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-md hover:bg-red-700 font-semibold" onclick="return confirm('Suspend this customer?')">
                        Suspend Customer
                    </button>
                @else
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 font-semibold">
                        Activate Customer
                    </button>
                @endif
            </form>
            <a href="{{ route('admin.customers.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300 font-semibold">
                Back to Customers
            </a>
        </div>
    </div>
</div>
@endsection

