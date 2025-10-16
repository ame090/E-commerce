@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Support Tickets</h1>

        <!-- Filter Tabs -->
        <div class="mb-6 flex space-x-4 border-b">
            <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 border-b-2 {{ !request('status') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                All Tickets
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="px-4 py-2 border-b-2 {{ request('status') == 'open' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                Open
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'in_progress']) }}" class="px-4 py-2 border-b-2 {{ request('status') == 'in_progress' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                In Progress
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="px-4 py-2 border-b-2 {{ request('status') == 'closed' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                Closed
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
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">
                                    Ticket #{{ $ticket->ticket_number }} - 
                                    From: <span class="font-semibold">{{ $ticket->user->name }}</span> ({{ $ticket->user->email }})
                                </p>
                                <p class="text-gray-700 mb-2">{{ \Illuminate\Support\Str::limit($ticket->message, 150) }}</p>
                                @if($ticket->reply)
                                    <div class="mt-3 bg-green-50 p-3 rounded border-l-4 border-green-400">
                                        <p class="text-sm font-semibold text-green-900">Your Reply:</p>
                                        <p class="text-sm text-green-800">{{ \Illuminate\Support\Str::limit($ticket->reply, 100) }}</p>
                                        <p class="text-xs text-green-600 mt-1">Replied {{ $ticket->replied_at->diffForHumans() }}</p>
                                    </div>
                                @else
                                    <p class="text-sm text-yellow-600 font-semibold">⏳ No reply yet</p>
                                @endif
                            </div>
                            <div class="text-right ml-4">
                                <p class="text-sm text-gray-500 mb-2">{{ $ticket->created_at->diffForHumans() }}</p>
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm inline-block">
                                    View & Reply
                                </a>
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
                <h2 class="text-2xl font-semibold text-gray-600 mt-4">No tickets found</h2>
                <p class="text-gray-500 mt-2">Support tickets will appear here</p>
            </div>
        @endif
    </div>
</div>
@endsection

