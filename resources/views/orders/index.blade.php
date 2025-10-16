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
                                <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600">Seller: {{ $order->seller->shop_name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded text-sm font-semibold
                                    {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 
                                       ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <p class="text-lg font-bold text-blue-600 mt-2">RM {{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex items-center space-x-4">
                                @foreach($order->items->take(3) as $item)
                                    <div class="flex items-center space-x-2">
                                        @if($item->product->images && count($item->product->images) > 0)
                                            <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded"></div>
                                        @endif
                                        <span class="text-sm">{{ $item->product->name }} x{{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                                @if($order->items->count() > 3)
                                    <span class="text-sm text-gray-600">+{{ $order->items->count() - 3 }} more</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('orders.show', $order) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Details</a>
                            @if($order->status == 'pending' || $order->status == 'processing')
                                <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-600 mt-4">No orders yet</h2>
                <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">Start Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection

