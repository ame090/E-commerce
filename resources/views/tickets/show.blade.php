@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:underline">← Back to Tickets</a>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $ticket->subject }}</h1>
                    <p class="text-sm text-gray-600">Ticket #{{ $ticket->ticket_number }}</p>
                    <p class="text-sm text-gray-600">Created {{ $ticket->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-3 py-1 rounded text-sm font-semibold mb-2
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

            <div class="border-t pt-4 mb-6">
                <h2 class="font-semibold text-gray-900 mb-2">Your Message:</h2>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $ticket->message }}</p>
            </div>

            @if($ticket->reply)
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="font-semibold text-blue-900 mb-2">Admin Reply:</h3>
                            <p class="text-blue-800 whitespace-pre-wrap">{{ $ticket->reply }}</p>
                            <p class="text-sm text-blue-600 mt-2">Replied {{ $ticket->replied_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded">
                    <p class="text-sm text-yellow-800">⏳ Waiting for admin response...</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

