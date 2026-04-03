<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketMessage;
use Illuminate\Http\Request;

class UserTicketController extends Controller
{
    protected function currentUser()
    {
        if (auth()->check()) {
            return auth()->user();
        }

        $email = session('user_email');

        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                return $user;
            }
        }

        abort(403, 'Utilisateur non connecté.');
    }

    protected function ensureTicketOwner(Ticket $ticket, User $user): void
    {
        if ((int) $ticket->user_id !== (int) $user->id) {
            abort(403);
        }
    }

    protected function categories(): array
    {
        return [
            'Compte',
            'Profil',
            'Technique',
            'Support',
            'Suivi',
            'Autre',
        ];
    }

    protected function generateTicketCode(): string
    {
        $lastId = Ticket::max('id') ?? 0;
        $nextId = $lastId + 1;

        return 'TCK-' . now()->format('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $user = $this->currentUser();
        $categories = $this->categories();

        return view('user.tickets.create', compact('user', 'categories'));
    }

    public function store(Request $request)
    {
        $user = $this->currentUser();

        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'description' => ['required', 'string', 'min:10'],
        ], [
            'subject.required' => 'Le sujet est obligatoire.',
            'category.required' => 'La catégorie est obligatoire.',
            'priority.required' => 'La priorité est obligatoire.',
            'priority.in' => 'La priorité sélectionnée est invalide.',
            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
        ]);

        Ticket::create([
            'user_id' => $user->id,
            'code' => $this->generateTicketCode(),
            'subject' => $request->subject,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => 'open',
            'description' => $request->description,
        ]);

        return redirect()
            ->route('user.tickets.index')
            ->with('success', 'Le ticket a été créé avec succès.');
    }

    public function index()
    {
        $user = $this->currentUser();

        $tickets = Ticket::with(['agent'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['open', 'pending', 'in_progress'])
            ->latest()
            ->get();

        $stats = [
            'open' => $tickets->where('status', 'open')->count(),
            'pending' => $tickets->where('status', 'pending')->count(),
            'in_progress' => $tickets->where('status', 'in_progress')->count(),
            'total' => $tickets->count(),
        ];

        return view('user.tickets.index', compact('user', 'tickets', 'stats'));
    }

    public function history()
    {
        $user = $this->currentUser();

        $tickets = Ticket::with(['agent'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['resolved', 'closed'])
            ->latest()
            ->get();

        $stats = [
            'resolved' => $tickets->where('status', 'resolved')->count(),
            'closed' => $tickets->where('status', 'closed')->count(),
            'total' => $tickets->count(),
        ];

        return view('user.tickets.history', compact('user', 'tickets', 'stats'));
    }

    public function show(Ticket $ticket)
    {
        $user = $this->currentUser();

        $this->ensureTicketOwner($ticket, $user);

        $ticket->load(['user', 'agent']);

        $messages = $ticket->messages()
            ->with('sender')
            ->get();

        return view('user.tickets.show', compact('user', 'ticket', 'messages'));
    }

    public function storeMessage(Request $request, Ticket $ticket)
    {
        $user = $this->currentUser();

        $this->ensureTicketOwner($ticket, $user);

        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'message.required' => 'Le message est obligatoire.',
            'message.max' => 'Le message ne doit pas dépasser 2000 caractères.',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        return redirect()->to(route('user.tickets.show', $ticket->id) . '#conversation')
            ->with('success', 'Votre message a été envoyé avec succès.');
    }
}