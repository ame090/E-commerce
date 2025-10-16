@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="bg-gray-50 p-4 rounded-lg flex items-center space-x-4">
                                @if($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded">
                                @else
                                    <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">No Image</div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">by {{ $item->product->seller->shop_name }}</p>
                                    <p class="text-blue-600 font-bold mt-2">RM {{ number_format($item->price, 2) }}</p>
                                </div>

                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-20 rounded-md border-gray-300">
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Update</button>
                                </form>

                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-gray-50 p-6 rounded-lg sticky top-4">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>RM {{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Items</span>
                                <span>{{ $cartItems->sum('quantity') }}</span>
                            </div>
                        </div>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span class="text-blue-600">RM {{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-600 text-white text-center px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">Proceed to Checkout</a>
                        <a href="{{ route('products.index') }}" class="block w-full text-center mt-4 text-blue-600 hover:underline">Continue Shopping</a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-600 mt-4">Your cart is empty</h2>
                <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">Start Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection

