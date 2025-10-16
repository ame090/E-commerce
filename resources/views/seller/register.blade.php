@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold mb-4">Register as a Seller</h1>
            <p class="text-gray-600">Start selling your products on our marketplace</p>
        </div>

        <div class="bg-gray-50 p-8 rounded-lg">
            <form action="{{ route('seller.register.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-2">Shop Name *</label>
                    <input type="text" id="shop_name" name="shop_name" required value="{{ old('shop_name') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter your shop name">
                    @error('shop_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Shop Description</label>
                    <textarea id="description" name="description" rows="4" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Tell customers about your shop">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6">
                    <h3 class="font-semibold text-blue-900 mb-2">📋 Before you submit:</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Your seller account will be reviewed by our admin team</li>
                        <li>• You will be notified once your account is approved</li>
                        <li>• Approval usually takes 1-2 business days</li>
                        <li>• Make sure your shop name is unique and professional</li>
                    </ul>
                </div>

                <div class="flex items-center mb-6">
                    <input type="checkbox" id="terms" name="terms" required
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a> for sellers
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">
                    Submit Application
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-blue-600 hover:underline">← Back to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection

