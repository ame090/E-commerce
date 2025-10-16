@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('seller.products.index') }}" class="text-blue-600 hover:underline">← Back to Products</a>
        </div>

        <h1 class="text-3xl font-bold mb-8">Edit Product</h1>

        <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $product->name) }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter product name">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select id="category_id" name="category_id" required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Compare Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (RM) *</label>
                    <input type="number" id="price" name="price" required step="0.01" min="0" value="{{ old('price', $product->price) }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="0.00">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-2">Compare Price (RM)</label>
                    <input type="number" id="compare_price" name="compare_price" step="0.01" min="0" value="{{ old('compare_price', $product->compare_price) }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
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
                    <input type="number" id="stock" name="stock" required min="0" value="{{ old('stock', $product->stock) }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="0">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Product SKU">
                    <p class="mt-1 text-xs text-gray-500">Stock Keeping Unit (optional)</p>
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Current Images -->
            @if($product->images && count($product->images) > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded border">
                                <form action="{{ route('seller.products.image.delete', $product) }}" method="POST" class="absolute top-2 right-2">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="image" value="{{ $image }}">
                                    <button type="submit" 
                                        class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 shadow-lg opacity-0 group-hover:opacity-100 transition"
                                        onclick="return confirm('Delete this image?')">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Hover over images to delete them</p>
                </div>
            @endif

            <!-- Product Images -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Add New Images (Optional)</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">Upload new images to add to existing ones (JPEG, PNG, GIF, max 2MB each)</p>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Status -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-700">
                    <span class="font-semibold">Current Status:</span> 
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $product->status == 'approved' ? 'bg-green-100 text-green-800' : 
                           ($product->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </p>
                @if($product->status == 'pending')
                    <p class="text-xs text-gray-600 mt-2">Your product is awaiting admin approval.</p>
                @elseif($product->status == 'rejected')
                    <p class="text-xs text-red-600 mt-2">Your product was rejected. Please review and resubmit.</p>
                @endif
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('seller.products.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

