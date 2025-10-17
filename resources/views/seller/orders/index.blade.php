@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">My Orders</h1>

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">Order #{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
                                <p class="text-sm text-gray-600">Customer: {{ $order->user->name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded text-sm font-semibold mb-2
                                    {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 
                                       ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <p class="text-lg font-bold text-teal-600">RM {{ number_format($order->total, 2) }}</p>
                                <span class="inline-block px-3 py-1 rounded text-sm font-semibold
                                    {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-semibold mb-1">Shipping Address:</p>
                                    <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                                    <p class="text-sm text-gray-600">Phone: {{ $order->shipping_phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold mb-1">Order Items:</p>
                                    @foreach($order->items as $item)
                                        <p class="text-sm text-gray-600">{{ $item->product->name }} x{{ $item->quantity }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('seller.orders.show', $order) }}" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">View Details</a>
                            @if(in_array($order->status, ['pending', 'processing']))
                                <button onclick="document.getElementById('updateStatusForm{{ $order->id }}').classList.toggle('hidden')" 
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                    Update Status
                                </button>
                            @endif
                        </div>

                        <!-- Update Status Form (Hidden by default) -->
                        <form id="updateStatusForm{{ $order->id }}" action="{{ route('seller.orders.update-status', $order) }}" method="POST" class="hidden mt-4 p-4 bg-white rounded border">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="status{{ $order->id }}" class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                                    <select id="status{{ $order->id }}" name="status" required class="w-full rounded-md border-gray-300">
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="tracking_number{{ $order->id }}" class="block text-sm font-medium text-gray-700 mb-2">Tracking Number</label>
                                    <input type="text" id="tracking_number{{ $order->id }}" name="tracking_number" 
                                        value="{{ $order->tracking_number }}"
                                        class="w-full rounded-md border-gray-300" placeholder="Enter tracking number">
                                </div>
                            </div>
                            <div class="mt-4 flex space-x-2">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
                                <button type="button" onclick="document.getElementById('updateStatusForm{{ $order->id }}').classList.add('hidden')" 
                                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-600 mt-4">No orders yet</h2>
                <p class="text-gray-500 mt-2">Orders will appear here once customers purchase your products</p>
            </div>
        @endif
    </div>
</div>
@endsection

