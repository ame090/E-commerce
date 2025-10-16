@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline">← Back to Categories</a>
        </div>

        <h1 class="text-3xl font-bold mb-8">Add New Category</h1>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter category name">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter category description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Parent Category (Optional)</label>
                <select id="parent_id" name="parent_id" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">None (Top Level Category)</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

