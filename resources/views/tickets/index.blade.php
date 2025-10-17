@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Support Tickets</h1>
            <a href="{{ route('tickets.create') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700 font-semibold">
                + Create Ticket
            </a>
        </div>

        @if($tickets->count() > 0)
            <div class="space-y-4">
                @foreach($tickets as $ticket)
                    <div class="bg-gray-50 p-6 rounded-lg hover:shadow-lg transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-semibold">{{ $ticket->subject }}</h3>
                                    <span class="px-2 py-1 text-xs font-semibold rounded
                                        {{ $ticket->status == 'closed' ? 'bg-gray-100 text-gray-800' : 
                                           ($ticket->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded
                                        {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-800' : 
                                           ($ticket->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($ticket->priority) }} Priority
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Ticket #{{ $ticket->ticket_number }}</p>
                                <p class="text-gray-700">{{ \Illuminate\Support\Str::limit($ticket->message, 100) }}</p>
                                @if($ticket->reply)
                                    <div class="mt-3 bg-blue-50 p-3 rounded border-l-4 border-blue-400">
                                        <p class="text-sm font-semibold text-blue-900">Admin Reply:</p>
                                        <p class="text-sm text-blue-800">{{ \Illuminate\Support\Str::limit($ticket->reply, 100) }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="text-right ml-4">
                                <p class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</p>
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-teal-600 hover:underline text-sm mt-2 block">View Details →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-600 mt-4">No tickets yet</h2>
                <p class="text-gray-500 mt-2">Need help? Create a support ticket</p>
                <a href="{{ route('tickets.create') }}" class="inline-block mt-6 bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700">Create Ticket</a>
            </div>
        @endif
    </div>
</div>
@endsection

