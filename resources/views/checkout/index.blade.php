@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Shipping Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700">Shipping Address</label>
                                <textarea id="shipping_address" name="shipping_address" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" id="shipping_phone" name="shipping_phone" required value="{{ old('shipping_phone', auth()->user()->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('shipping_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-bold mb-4">Order Items</h2>
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center space-x-4 pb-4 border-b">
                                    @if($item->product->images && count($item->product->images) > 0)
                                        <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">No Image</div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                    </div>

                                    <div class="text-right">
                                        <p class="font-bold">RM {{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 p-6 rounded-lg sticky top-4">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>RM {{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Shipping</span>
                                <span>RM 10.00</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Tax (6%)</span>
                                <span>RM {{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }) * 0.06, 2) }}</span>
                            </div>
                        </div>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span class="text-blue-600">RM {{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }) * 1.06 + 10, 2) }}</span>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">Place Order</button>
                        <a href="{{ route('cart.index') }}" class="block w-full text-center mt-4 text-blue-600 hover:underline">Back to Cart</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

