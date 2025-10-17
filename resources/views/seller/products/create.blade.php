@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('seller.products.index') }}" class="text-teal-600 hover:underline">← Back to Products</a>
        </div>

        <h1 class="text-3xl font-bold mb-8">Add New Product</h1>

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500"
                    placeholder="Enter product name">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select id="category_id" name="category_id" required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500"
                    placeholder="Enter product description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Compare Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (RM) *</label>
                    <input type="number" id="price" name="price" required step="0.01" min="0" value="{{ old('price') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500"
                        placeholder="0.00">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-2">Compare Price (RM)</label>
                    <input type="number" id="compare_price" name="compare_price" step="0.01" min="0" value="{{ old('compare_price') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500"
                        placeholder="0.00">
                    <p class="mt-1 text-xs text-gray-500">Original price (for showing discount)</p>
                    @error('compare_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Stock & SKU -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                    <input type="number" id="stock" name="stock" required min="0" value="{{ old('stock', 0) }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500"
                        placeholder="0">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500"
                        placeholder="Product SKU">
                    <p class="mt-1 text-xs text-gray-500">Stock Keeping Unit (optional)</p>
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Product Images -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Product Images</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">You can select multiple images (JPEG, PNG, GIF, max 2MB each)</p>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-2">📋 Before you submit:</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Your product will be reviewed by admin before appearing on the marketplace</li>
                    <li>• Make sure all information is accurate and complete</li>
                    <li>• Use high-quality images for better sales</li>
                    <li>• Set competitive prices</li>
                </ul>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('seller.products.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700 font-semibold">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

