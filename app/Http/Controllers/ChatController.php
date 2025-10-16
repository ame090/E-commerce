<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get all conversations (unique users)
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function ($message) use ($userId) {
                return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
            })
            ->map(function ($messages) {
                return $messages->first();
            });

        return view('chat.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $currentUserId = auth()->id();

        // Get all messages between current user and selected user
        $messages = Message::where(function ($query) use ($currentUserId, $user) {
            $query->where('sender_id', $currentUserId)
                ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($currentUserId, $user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $currentUserId);
        })->with(['sender', 'receiver', 'product'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('chat.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'product_id' => 'nullable|exists:products,id',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'product_id' => $request->product_id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $user)->with('success', 'Message sent');
    }

    public function contactSeller(Product $product)
    {
        $seller = $product->seller->user;
        
        return view('chat.contact', compact('product', 'seller'));
    }
}
