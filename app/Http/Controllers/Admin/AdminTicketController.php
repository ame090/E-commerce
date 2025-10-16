<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'seller']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(20);

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'reply' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket->reply = $request->reply;
        $ticket->status = $request->status;
        $ticket->replied_at = now();
        $ticket->save();

        return back()->with('success', 'Reply sent successfully');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket->status = $request->status;
        $ticket->save();

        return back()->with('success', 'Ticket status updated');
    }
}
