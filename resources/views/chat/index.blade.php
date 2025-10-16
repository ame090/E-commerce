@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Messages</h1>

        <!-- WhatsApp-Style Conversations List -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if($conversations->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($conversations as $conversation)
                        @php
                            $otherUser = $conversation->sender_id == auth()->id() ? $conversation->receiver : $conversation->sender;
                            $isUnread = $conversation->receiver_id == auth()->id() && !$conversation->read_at;
                            $isSent = $conversation->sender_id == auth()->id();
                        @endphp
                        <a href="{{ route('chat.show', $otherUser) }}" class="flex items-center p-4 hover:bg-gray-50 transition {{ $isUnread ? 'bg-green-50' : '' }}">
                            <!-- Avatar -->
                            <div class="relative flex-shrink-0">
                                <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md">
                                    {{ substr($otherUser->name, 0, 1) }}
                                </div>
                                @if($isUnread)
                                    <span class="absolute top-0 right-0 w-4 h-4 bg-green-600 rounded-full border-2 border-white"></span>
                                @endif
                            </div>

                            <!-- Message Info -->
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-semibold text-gray-900 truncate {{ $isUnread ? 'font-bold' : '' }}">
                                        {{ $otherUser->name }}
                                    </h3>
                                    <span class="text-xs text-gray-500">
                                        {{ $conversation->created_at->format('M d, H:i') }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-600 truncate {{ $isUnread ? 'font-semibold' : '' }}">
                                        @if($isSent)
                                            <span class="text-green-600">You: </span>
                                        @endif
                                        {{ \Illuminate\Support\Str::limit($conversation->message, 50) }}
                                    </p>
                                    @if($isUnread)
                                        <span class="ml-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full font-bold">
                                            New
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="px-2 py-0.5 rounded {{ $otherUser->role == 'seller' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($otherUser->role) }}
                                    </span>
                                </p>
                            </div>

                            <!-- Chevron -->
                            <svg class="h-5 w-5 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">No conversations yet</h2>
                    <p class="text-gray-500 mb-6">Start a conversation with a seller from product pages</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 font-semibold">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>

        <!-- Helper Text -->
        <div class="mt-4 text-center text-sm text-gray-600">
            <p>💬 Messages update automatically every 5 seconds</p>
        </div>
    </div>
</div>

<script>
// Auto-refresh conversations every 5 seconds
setInterval(function() {
    location.reload();
}, 5000);
</script>
@endsection
