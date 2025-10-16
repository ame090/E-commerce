@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Contact Seller</h1>

        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <div class="flex items-center space-x-4 mb-4">
                @if($product->images && count($product->images) > 0)
                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded">
                @else
                    <div class="w-20 h-20 bg-gray-200 rounded"></div>
                @endif
                <div>
                    <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600">RM {{ number_format($product->price, 2) }}</p>
                </div>
            </div>
            <div class="border-t pt-4">
                <p class="text-sm text-gray-600">Seller: <span class="font-semibold">{{ $seller->name }}</span></p>
                <p class="text-sm text-gray-600">Shop: <span class="font-semibold">{{ $product->seller->shop_name }}</span></p>
            </div>
        </div>

        <div class="bg-white shadow p-6 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Send Message</h2>
            <form action="{{ route('chat.send', $seller) }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message *</label>
                    <textarea id="message" name="message" required rows="6" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Ask about the product, shipping, or any questions...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">
                        Send Message
                    </button>
                    <a href="{{ route('products.show', $product->slug) }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

