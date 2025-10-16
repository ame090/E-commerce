<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully');
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        return view('tickets.show', compact('ticket'));
    }
}
