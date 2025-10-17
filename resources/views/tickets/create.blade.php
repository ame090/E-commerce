@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('tickets.index') }}" class="text-teal-600 hover:underline">← Back to Tickets</a>
        </div>

        <h1 class="text-3xl font-bold mb-8">Create Support Ticket</h1>

        <form action="{{ route('tickets.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                <input type="text" id="subject" name="subject" required value="{{ old('subject') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500"
                    placeholder="What is your issue about?">
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                <select id="priority" name="priority" required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500">
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>
                @error('priority')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                <textarea id="message" name="message" required rows="6" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-blue-500"
                    placeholder="Describe your issue in detail...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-2">📋 Tips for better support:</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Be as specific as possible about your issue</li>
                    <li>• Include order numbers if applicable</li>
                    <li>• Our team will respond within 24-48 hours</li>
                </ul>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('tickets.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700 font-semibold">
                    Submit Ticket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

