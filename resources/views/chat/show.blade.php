@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- WhatsApp-Style Chat Container -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden" style="height: 600px; display: flex; flex-direction: column;">
            
            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('chat.index') }}" class="mr-3 hover:bg-green-800 rounded-full p-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-green-600 font-bold text-lg mr-3">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="font-bold text-white">{{ $user->name }}</h2>
                        <p class="text-xs text-green-100">{{ ucfirst($user->role) }}</p>
                    </div>
                </div>
                <div class="text-xs text-green-100">
                    Online
                </div>
            </div>

            <!-- Chat Messages Area -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-4 bg-gray-50" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;100&quot; height=&quot;100&quot; viewBox=&quot;0 0 100 100&quot;><text x=&quot;50&quot; y=&quot;50&quot; font-size=&quot;40&quot; fill=&quot;%23e5e7eb&quot; opacity=&quot;0.3&quot; text-anchor=&quot;middle&quot; dominant-baseline=&quot;middle&quot;>💬</text></svg>');">
                @forelse($messages as $message)
                    <div class="mb-4 flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md">
                            <!-- Product Context (if applicable) -->
                            @if($message->product)
                                <div class="mb-2 p-2 bg-white rounded-lg shadow-sm border border-gray-200">
                                    <div class="flex items-center space-x-2">
                                        @if($message->product->images && count($message->product->images) > 0)
                                            <img src="{{ asset('storage/' . $message->product->images[0]) }}" alt="{{ $message->product->name }}" class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded"></div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-800 truncate">{{ $message->product->name }}</p>
                                            <p class="text-xs text-gray-600">RM {{ number_format($message->product->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Message Bubble -->
                            <div class="rounded-lg p-3 shadow {{ $message->sender_id == auth()->id() ? 'bg-green-500 text-white' : 'bg-white text-gray-900' }}">
                                <p class="whitespace-pre-wrap break-words">{{ $message->message }}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-xs {{ $message->sender_id == auth()->id() ? 'text-green-100' : 'text-gray-500' }}">
                                        {{ $message->created_at->format('H:i') }}
                                    </p>
                                    @if($message->sender_id == auth()->id())
                                        <span class="text-xs text-green-100">
                                            {{ $message->isRead() ? '✓✓' : '✓' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Sender Name -->
                            <p class="text-xs {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }} mt-1 text-gray-500">
                                {{ $message->sender->name }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-400">
                        <svg class="mx-auto h-16 w-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-gray-600">No messages yet. Start the conversation!</p>
                    </div>
                @endforelse
            </div>

            <!-- Message Input -->
            <div class="bg-white border-t p-4">
                <form action="{{ route('chat.send', $user) }}" method="POST" class="flex items-end space-x-2">
                    @csrf
                    <div class="flex-1">
                        <textarea name="message" rows="2" required
                            class="w-full rounded-full px-4 py-2 border-gray-300 focus:border-green-500 focus:ring-green-500 resize-none"
                            placeholder="Type a message..." 
                            onkeypress="if(event.keyCode == 13 && !event.shiftKey) { event.preventDefault(); this.form.submit(); }"></textarea>
                    </div>
                    <button type="submit" class="bg-green-600 text-white p-3 rounded-full hover:bg-green-700 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-2 text-center">Press Enter to send, Shift+Enter for new line</p>
            </div>
        </div>
    </div>
</div>

<script>
// Scroll to bottom of messages
function scrollToBottom() {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

document.addEventListener('DOMContentLoaded', scrollToBottom);

// Auto-refresh every 5 seconds for real-time chat
let lastMessageCount = {{ $messages->count() }};
setInterval(async function() {
    try {
        const response = await fetch(window.location.href);
        const text = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(text, 'text/html');
        const newMessages = doc.getElementById('chatMessages');
        
        if (newMessages) {
            const currentMessages = document.getElementById('chatMessages');
            currentMessages.innerHTML = newMessages.innerHTML;
            scrollToBottom();
        }
    } catch (error) {
        console.log('Failed to refresh messages');
    }
}, 5000);
</script>
@endsection
