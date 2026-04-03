@extends('user.layouts.tickets')

@section('title', 'Historique des tickets')
@section('topbar_title', 'Historique des tickets')
@section('top_button_text', 'Créer un ticket')
@section('top_button_link', route('user.tickets.create'))

@section('content')
    <div class="page-card">
        <h1 class="page-title">Historique des tickets</h1>
        <p class="page-text">
            Consultez ici les tickets résolus et fermés.
        </p>
    </div>

    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-label">Total</div>
            <div class="stats-value">{{ $stats['total'] ?? 0 }}</div>
        </div>

        <div class="stats-card">
            <div class="stats-label">Résolus</div>
            <div class="stats-value">{{ $stats['resolved'] ?? 0 }}</div>
        </div>

        <div class="stats-card">
            <div class="stats-label">Fermés</div>
            <div class="stats-value">{{ $stats['closed'] ?? 0 }}</div>
        </div>

        <div class="stats-card">
            <div class="stats-label">Archivés</div>
            <div class="stats-value">{{ $stats['total'] ?? 0 }}</div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <div class="table-title">Tickets résolus et fermés</div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Sujet</th>
                        <th>Catégorie</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Attribué à</th>
                        <th>Date de création</th>
                        <th>Dernière mise à jour</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tickets as $ticket)
                        @php
                            $statusClass = match($ticket->status) {
                                'resolved' => 'status-resolved',
                                'closed' => 'status-closed',
                                'open' => 'status-open',
                                'pending' => 'status-pending',
                                'in_progress' => 'status-progress',
                                default => 'status-open',
                            };

                            $priorityClass = match($ticket->priority) {
                                'low' => 'priority-low',
                                'medium' => 'priority-medium',
                                'high' => 'priority-high',
                                'urgent' => 'priority-urgent',
                                default => 'priority-low',
                            };

                            $statusLabel = match($ticket->status) {
                                'resolved' => 'Résolu',
                                'closed' => 'Fermé',
                                'open' => 'Ouvert',
                                'pending' => 'En attente',
                                'in_progress' => 'En cours',
                                default => ucfirst($ticket->status),
                            };

                            $priorityLabel = match($ticket->priority) {
                                'low' => 'Faible',
                                'medium' => 'Moyenne',
                                'high' => 'Élevée',
                                'urgent' => 'Urgente',
                                default => ucfirst($ticket->priority),
                            };
                        @endphp

                        <tr>
                            <td>
                                <div class="ticket-code">{{ $ticket->code }}</div>
                            </td>
                            <td>
                                <div>{{ $ticket->subject }}</div>
                                <div class="muted">Ticket archivé</div>
                            </td>
                            <td>{{ $ticket->category }}</td>
                            <td>
                                <span class="badge-pill {{ $priorityClass }}">
                                    {{ $priorityLabel }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-pill {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td>{{ $ticket->agent?->username ?? 'Non attribué' }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->updated_at)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('user.tickets.show', $ticket->id) }}" class="btn secondary">
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    Aucun ticket dans l’historique.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection