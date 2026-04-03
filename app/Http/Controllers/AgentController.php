<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketMessage;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    protected function currentAgent()
    {
        if (!session('is_logged_in') || session('role') !== 'agent') {
            abort(403);
        }

        return User::findOrFail(session('user_id'));
    }

    public function dashboard()
    {
        $agent = $this->currentAgent();

        $openTickets = Ticket::where('status', 'open')->count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        $inProgressTickets = Ticket::where('status', 'in_progress')->count();
        $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])->count();
        $myTickets = Ticket::where('assigned_to', $agent->id)->count();

        $latestTickets = Ticket::with(['user', 'agent'])
            ->latest()
            ->take(5)
            ->get();

        return view('agent.dashboard', compact(
            'agent',
            'openTickets',
            'pendingTickets',
            'inProgressTickets',
            'resolvedTickets',
            'myTickets',
            'latestTickets'
        ));
    }

    public function tickets(Request $request)
    {
        $agent = $this->currentAgent();

        $query = Ticket::with(['user', 'agent'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $tickets = $query->get();

        $availableCategories = Ticket::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::whereIn('status', ['resolved', 'closed'])->count(),
        ];

        $filters = [
            'status' => $request->status,
            'priority' => $request->priority,
            'category' => $request->category,
        ];

        return view('agent.tickets.index', compact(
            'agent',
            'tickets',
            'availableCategories',
            'stats',
            'filters'
        ));
    }

    public function show(Ticket $ticket)
    {
        $agent = $this->currentAgent();

        $ticket->load(['user', 'agent']);

        $messages = $ticket->messages()
            ->with('sender')
            ->get();

        $activeTicketsCount = Ticket::whereIn('status', ['open', 'pending', 'in_progress'])->count();

        return view('agent.tickets.show', compact(
            'agent',
            'ticket',
            'messages',
            'activeTicketsCount'
        ));
    }

    public function storeMessage(Request $request, Ticket $ticket)
    {
        $agent = $this->currentAgent();

        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'message.required' => 'Le message est obligatoire.',
            'message.max' => 'Le message ne doit pas dépasser 2000 caractères.',
        ]);

        if (!$ticket->assigned_to) {
            $ticket->assigned_to = $agent->id;

            if ($ticket->status === 'open') {
                $ticket->status = 'in_progress';
            }

            $ticket->save();
        }

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_id' => $agent->id,
            'message' => $request->message,
        ]);

        return redirect()->to(route('agent.tickets.show', $ticket->id) . '#conversation')
            ->with('success', 'Le message a été envoyé avec succès.');
    }

    public function assignToMe(Ticket $ticket)
    {
        $agent = $this->currentAgent();

        $ticket->assigned_to = $agent->id;

        if ($ticket->status === 'open') {
            $ticket->status = 'in_progress';
        }

        $ticket->save();

        return back()->with('success', 'Le ticket vous a été attribué avec succès.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $agent = $this->currentAgent();

        $request->validate([
            'status' => ['required', 'in:open,pending,in_progress,resolved,closed'],
        ], [
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut sélectionné est invalide.',
        ]);

        $newStatus = $request->status;

        $ticket->status = $newStatus;

        if (!$ticket->assigned_to) {
            $ticket->assigned_to = $agent->id;
        }

        if ($newStatus === 'resolved') {
            $ticket->resolved_at = now();
            $ticket->closed_at = null;
        } elseif ($newStatus === 'closed') {
            if (!$ticket->resolved_at) {
                $ticket->resolved_at = now();
            }

            $ticket->closed_at = now();
        } else {
            $ticket->resolved_at = null;
            $ticket->closed_at = null;
        }

        $ticket->save();

        return redirect()
            ->route('agent.tickets.show', $ticket->id)
            ->with('success', 'Le statut du ticket a été mis à jour avec succès.');
    }
}