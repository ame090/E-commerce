@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('admin.tickets.index') }}" class="text-blue-600 hover:underline">← Back to Tickets</a>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $ticket->subject }}</h1>
                    <p class="text-sm text-gray-600">Ticket #{{ $ticket->ticket_number }}</p>
                    <p class="text-sm text-gray-600">Created {{ $ticket->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="text-right space-y-2">
                    <span class="inline-block px-3 py-1 rounded text-sm font-semibold
                        {{ $ticket->status == 'closed' ? 'bg-gray-100 text-gray-800' : 
                           ($ticket->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                    <br>
                    <span class="inline-block px-3 py-1 rounded text-sm font-semibold
                        {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-800' : 
                           ($ticket->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($ticket->priority) }} Priority
                    </span>
                </div>
            </div>

            <div class="border-t pt-4 mb-4">
                <h2 class="font-semibold text-gray-900 mb-2">Customer Information:</h2>
                <p class="text-sm text-gray-600">Name: <span class="font-semibold">{{ $ticket->user->name }}</span></p>
                <p class="text-sm text-gray-600">Email: <span class="font-semibold">{{ $ticket->user->email }}</span></p>
                <p class="text-sm text-gray-600">Phone: <span class="font-semibold">{{ $ticket->user->phone ?? 'N/A' }}</span></p>
            </div>

            <div class="border-t pt-4">
                <h2 class="font-semibold text-gray-900 mb-2">Message:</h2>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $ticket->message }}</p>
            </div>

            @if($ticket->reply)
                <div class="mt-4 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <h3 class="font-semibold text-green-900 mb-2">Your Reply:</h3>
                    <p class="text-green-800 whitespace-pre-wrap">{{ $ticket->reply }}</p>
                    <p class="text-sm text-green-600 mt-2">Replied {{ $ticket->replied_at->diffForHumans() }}</p>
                </div>
            @endif
        </div>

        <!-- Reply Form -->
        @if($ticket->status !== 'closed')
            <div class="bg-white shadow p-6 rounded-lg">
                <h2 class="text-xl font-bold mb-4">{{ $ticket->reply ? 'Update Reply' : 'Send Reply' }}</h2>
                <form action="{{ route('admin.tickets.reply', $ticket) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="reply" class="block text-sm font-medium text-gray-700 mb-2">Your Reply *</label>
                        <textarea id="reply" name="reply" required rows="6" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Type your response...">{{ old('reply', $ticket->reply) }}</textarea>
                        @error('reply')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status *</label>
                        <select id="status" name="status" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="open" {{ old('status', $ticket->status) == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ old('status', $ticket->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="closed" {{ old('status', $ticket->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">
                        Send Reply & Update Status
                    </button>
                </form>
            </div>
        @else
            <div class="bg-gray-100 p-6 rounded-lg text-center">
                <p class="text-gray-600">This ticket is closed.</p>
            </div>
        @endif
    </div>
</div>
@endsection

