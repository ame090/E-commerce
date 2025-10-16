@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">← Back to Orders</a>
        </div>

        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold">Order #{{ $order->order_number }}</h1>
                <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
            <span class="px-4 py-2 rounded text-sm font-semibold
                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 
                   ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer & Seller Information -->
                <div class="bg-gray-50 p-6 rounded-lg grid grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-bold mb-4">Customer</h2>
                        <div class="space-y-2">
                            <p class="text-sm"><span class="font-semibold">Name:</span> {{ $order->user->name }}</p>
                            <p class="text-sm"><span class="font-semibold">Email:</span> {{ $order->user->email }}</p>
                            <p class="text-sm"><span class="font-semibold">Phone:</span> {{ $order->user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-4">Seller</h2>
                        <div class="space-y-2">
                            <p class="text-sm"><span class="font-semibold">Shop:</span> {{ $order->seller->shop_name }}</p>
                            <p class="text-sm"><span class="font-semibold">Owner:</span> {{ $order->seller->user->name }}</p>
                            <p class="text-sm"><span class="font-semibold">Email:</span> {{ $order->seller->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-bold mb-4">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-4 pb-4 border-b last:border-0">
                                @if($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded"></div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} x RM {{ number_format($item->price, 2) }}</p>
                                </div>

                                <div class="text-right">
                                    <p class="font-bold">RM {{ number_format($item->total, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
                    <div class="space-y-2">
                        <p class="text-sm"><span class="font-semibold">Address:</span> {{ $order->shipping_address }}</p>
                        <p class="text-sm"><span class="font-semibold">Phone:</span> {{ $order->shipping_phone }}</p>
                        @if($order->tracking_number)
                            <p class="text-sm"><span class="font-semibold">Tracking:</span> {{ $order->tracking_number }}</p>
                        @endif
                        @if($order->notes)
                            <p class="text-sm"><span class="font-semibold">Notes:</span> {{ $order->notes }}</p>
                        @endif
                    </div>
                </div>

                <!-- Update Status -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-bold mb-4">Update Order Status</h2>
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                            <select id="status" name="status" required class="w-full rounded-md border-gray-300">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 font-semibold">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1">
                <!-- Order Summary -->
                <div class="bg-gray-50 p-6 rounded-lg sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>RM {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Shipping</span>
                            <span>RM {{ number_format($order->shipping, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Tax</span>
                            <span>RM {{ number_format($order->tax, 2) }}</span>
                        </div>
                        @if($order->discount > 0)
                            <div class="flex justify-between text-sm text-green-600">
                                <span>Discount</span>
                                <span>- RM {{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="border-t pt-4 mb-4">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span class="text-blue-600">RM {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="mb-4">
                        <p class="text-sm font-semibold mb-2">Payment Status:</p>
                        <span class="px-3 py-1 rounded text-sm font-semibold
                            {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>

                    @if($order->payment)
                        <div class="text-xs text-gray-500">
                            <p>Transaction: {{ $order->payment->transaction_id }}</p>
                            @if($order->payment->paid_at)
                                <p>Paid: {{ $order->payment->paid_at->format('M d, Y H:i') }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

