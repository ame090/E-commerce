@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('orders.index') }}" class="text-teal-600 hover:underline">← Back to Orders</a>
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
                                    <a href="{{ route('products.show', $item->product->slug) }}" class="font-semibold hover:text-teal-600">{{ $item->product->name }}</a>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} x RM {{ number_format($item->price, 2) }}</p>
                                </div>

                                <div class="text-right">
                                    <p class="font-bold">RM {{ number_format($item->total, 2) }}</p>
                                    @if($order->status == 'delivered')
                                        <a href="{{ route('reviews.create', ['order' => $order, 'product' => $item->product]) }}" class="text-sm text-teal-600 hover:underline">Write Review</a>
                                    @endif
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
                            <p class="text-sm"><span class="font-semibold">Tracking Number:</span> {{ $order->tracking_number }}</p>
                        @endif
                        @if($order->notes)
                            <p class="text-sm"><span class="font-semibold">Notes:</span> {{ $order->notes }}</p>
                        @endif
                    </div>
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
                            <span class="text-teal-600">RM {{ number_format($order->total, 2) }}</span>
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

                    @if($order->payment_status == 'pending')
                        <a href="{{ route('payment.index', $order) }}" class="block w-full bg-emerald-600 text-white text-center px-6 py-3 rounded-md hover:bg-emerald-700 font-semibold">Pay Now</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

