@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline">← Back to Order</a>
        </div>

        <h1 class="text-3xl font-bold mb-8">Write a Review</h1>

        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <div class="flex items-center space-x-4">
                @if($product->images && count($product->images) > 0)
                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded">
                @else
                    <div class="w-20 h-20 bg-gray-200 rounded"></div>
                @endif
                <div>
                    <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600">by {{ $product->seller->shop_name }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('reviews.store', ['order' => $order, 'product' => $product]) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                <div class="flex items-center space-x-2">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} class="sr-only peer" required>
                            <span class="text-4xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-300">★</span>
                        </label>
                    @endfor
                </div>
                <p class="text-xs text-gray-500 mt-1">Click on a star to rate (1 = Poor, 5 = Excellent)</p>
                @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                <textarea id="comment" name="comment" rows="6" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Share your experience with this product...">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-2">📝 Review Guidelines:</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Be honest and helpful to other shoppers</li>
                    <li>• Focus on the product quality and your experience</li>
                    <li>• Avoid offensive language</li>
                    <li>• Your review helps sellers improve their products</li>
                </ul>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('orders.show', $order) }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

