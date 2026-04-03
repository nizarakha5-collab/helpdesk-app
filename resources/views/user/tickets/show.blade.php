@extends('user.layouts.tickets')

@section('title', 'Détails du ticket')
@section('topbar_title', 'Détails du ticket')
@section('top_button_text', 'Retour à mes tickets')
@section('top_button_link', route('user.tickets.index'))

@section('content')
    @php
        $statusClass = match($ticket->status) {
            'open' => 'status-open',
            'pending' => 'status-pending',
            'in_progress' => 'status-progress',
            'resolved' => 'status-resolved',
            'closed' => 'status-closed',
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
            'open' => 'Ouvert',
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'resolved' => 'Résolu',
            'closed' => 'Fermé',
            default => ucfirst($ticket->status),
        };

        $priorityLabel = match($ticket->priority) {
            'low' => 'Faible',
            'medium' => 'Moyenne',
            'high' => 'Élevée',
            'urgent' => 'Urgente',
            default => ucfirst($ticket->priority),
        };

        $messagesCount = $messages->count();
    @endphp

    <style>
        .welcome-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            padding: 24px;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
            margin-bottom: 22px;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 800;
            color: #23345d;
            margin-bottom: 10px;
        }

        .welcome-text {
            font-size: 1rem;
            color: #6f7d99;
            line-height: 1.7;
        }

        .welcome-text strong {
            color: #23345d;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 22px;
            margin-bottom: 22px;
        }

        .info-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
            overflow: hidden;
        }

        .card-header {
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f8;
            font-size: 1rem;
            font-weight: 800;
            color: #2a3756;
        }

        .card-body {
            padding: 20px;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 18px;
        }

        .meta-box {
            background: #f8fbff;
            border: 1px solid #e4ebf7;
            border-radius: 14px;
            padding: 14px 16px;
        }

        .meta-label {
            font-size: 0.82rem;
            color: #7b88a5;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .meta-value {
            font-size: 0.95rem;
            color: #23345d;
            font-weight: 700;
            word-break: break-word;
        }

        .ticket-description {
            background: #fbfdff;
            border: 1px solid #e9eff8;
            border-radius: 14px;
            padding: 18px;
            color: #42526e;
            line-height: 1.8;
            white-space: pre-line;
        }

        .side-stack {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 800;
        }

        .status-open {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .status-pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .status-progress {
            background: #f5f3ff;
            color: #6d28d9;
        }

        .status-resolved {
            background: #ecfdf3;
            color: #15803d;
        }

        .status-closed {
            background: #f3f4f6;
            color: #374151;
        }

        .priority-low {
            background: #eff6ff;
            color: #2563eb;
        }

        .priority-medium {
            background: #fefce8;
            color: #a16207;
        }

        .priority-high {
            background: #fff7ed;
            color: #c2410c;
        }

        .priority-urgent {
            background: #fef2f2;
            color: #b91c1c;
        }

        .ticket-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .chat-launch-btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 14px;
            background: #2f89d9;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .chat-launch-count {
            min-width: 28px;
            height: 28px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 8px;
            font-size: 0.82rem;
            font-weight: 800;
        }

        .chat-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.18);
            opacity: 0;
            pointer-events: none;
            transition: 0.25s ease;
            z-index: 80;
        }

        .chat-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .ticket-chat-widget {
            position: fixed;
            top: 96px;
            right: 24px;
            width: 390px;
            height: calc(100vh - 120px);
            background: #ffffff;
            border: 1px solid #dfe7f3;
            border-radius: 22px;
            box-shadow: 0 20px 60px rgba(31, 42, 68, 0.18);
            overflow: hidden;
            z-index: 90;
            transform: translateX(110%);
            opacity: 0;
            pointer-events: none;
            transition: 0.28s ease;
            display: flex;
            flex-direction: column;
        }

        .ticket-chat-widget.open {
            transform: translateX(0);
            opacity: 1;
            pointer-events: auto;
        }

        .ticket-chat-header {
            min-height: 72px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: linear-gradient(135deg, #eef5ff 0%, #f7fbff 100%);
            border-bottom: 1px solid #e6edf8;
        }

        .ticket-chat-title {
            font-size: 1rem;
            font-weight: 800;
            color: #23345d;
        }

        .ticket-chat-subtitle {
            margin-top: 4px;
            font-size: 0.84rem;
            color: #6f7d99;
            font-weight: 600;
        }

        .ticket-chat-close {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            border: 1px solid #d7dfec;
            background: #ffffff;
            color: #23345d;
            font-size: 1.3rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ticket-chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 18px;
            background: #f9fbff;
        }

        .chat-row {
            display: flex;
            margin-bottom: 14px;
        }

        .chat-row.mine {
            justify-content: flex-end;
        }

        .chat-row.other {
            justify-content: flex-start;
        }

        .chat-bubble {
            max-width: 82%;
            border-radius: 18px;
            padding: 14px 16px;
            box-shadow: 0 6px 18px rgba(31, 42, 68, 0.05);
        }

        .chat-bubble.mine {
            background: #2f89d9;
            color: #ffffff;
            border-bottom-right-radius: 6px;
        }

        .chat-bubble.other {
            background: #ffffff;
            color: #23345d;
            border: 1px solid #e4ebf7;
            border-bottom-left-radius: 6px;
        }

        .chat-meta {
            font-size: 0.78rem;
            font-weight: 700;
            margin-bottom: 6px;
            opacity: 0.88;
        }

        .chat-text {
            line-height: 1.7;
            white-space: pre-line;
            word-break: break-word;
        }

        .chat-empty {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7b88a5;
            text-align: center;
            padding: 20px;
        }

        .ticket-chat-footer {
            padding: 16px;
            border-top: 1px solid #e6edf8;
            background: #ffffff;
        }

        .ticket-chat-note {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 12px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .ticket-chat-textarea {
            width: 100%;
            min-height: 110px;
            border: 1px solid #dbe4f0;
            background: #f8fbff;
            border-radius: 14px;
            padding: 14px;
            outline: none;
            color: #23345d;
            font-size: 0.95rem;
            resize: vertical;
            margin-bottom: 12px;
        }

        .ticket-chat-textarea:focus {
            border-color: #2f89d9;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(47, 137, 217, 0.10);
        }

        .ticket-chat-submit {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 14px;
            background: #2f89d9;
            color: #ffffff;
            font-size: 0.94rem;
            font-weight: 800;
            cursor: pointer;
        }

        @media (max-width: 1100px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            .meta-grid {
                grid-template-columns: 1fr;
            }

            .ticket-chat-widget {
                top: 90px;
                right: 12px;
                left: 12px;
                width: auto;
                height: calc(100vh - 108px);
            }

            .chat-bubble {
                max-width: 92%;
            }
        }
    </style>

    <div class="welcome-card">
        <h1 class="welcome-title">Ticket {{ $ticket->code }}</h1>

        <p class="welcome-text">
            <strong>Sujet :</strong> {{ $ticket->subject }}
        </p>

        <p class="welcome-text" style="margin-top:8px;">
            <strong>Utilisateur :</strong> {{ $ticket->user?->username ?? '---' }}
        </p>

        <p class="welcome-text" style="margin-top:8px;">
            <strong>Agent assigné :</strong> {{ $ticket->agent?->username ?? 'Non attribué' }}
        </p>
    </div>

    <div class="details-grid">
        <div class="info-card">
            <div class="card-header">Informations du ticket</div>

            <div class="card-body">
                <div class="meta-grid">
                    <div class="meta-box">
                        <div class="meta-label">Code</div>
                        <div class="meta-value">{{ $ticket->code }}</div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Sujet</div>
                        <div class="meta-value">{{ $ticket->subject }}</div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Catégorie</div>
                        <div class="meta-value">{{ $ticket->category }}</div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Priorité</div>
                        <div class="meta-value">
                            <span class="badge-pill {{ $priorityClass }}">{{ $priorityLabel }}</span>
                        </div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Statut</div>
                        <div class="meta-value">
                            <span class="badge-pill {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Agent assigné</div>
                        <div class="meta-value">{{ $ticket->agent?->username ?? 'Non attribué' }}</div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Créé le</div>
                        <div class="meta-value">{{ $ticket->created_at?->format('Y-m-d H:i') }}</div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Dernière mise à jour</div>
                        <div class="meta-value">{{ $ticket->updated_at?->format('Y-m-d H:i') }}</div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Résolu le</div>
                        <div class="meta-value">{{ $ticket->resolved_at ? $ticket->resolved_at->format('Y-m-d H:i') : '---' }}</div>
                    </div>

                    <div class="meta-box">
                        <div class="meta-label">Fermé le</div>
                        <div class="meta-value">{{ $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i') : '---' }}</div>
                    </div>
                </div>

                <div class="meta-label" style="margin-bottom:10px;">Description</div>
                <div class="ticket-description">{{ $ticket->description }}</div>
            </div>
        </div>

        <div class="side-stack">
            <div class="info-card">
                <div class="card-header">Suivi</div>

                <div class="card-body">
                    <div class="meta-box" style="margin-bottom:14px;">
                        <div class="meta-label">Utilisateur</div>
                        <div class="meta-value">{{ $ticket->user?->username ?? '---' }}</div>
                    </div>

                    <div class="meta-box" style="margin-bottom:14px;">
                        <div class="meta-label">E-mail</div>
                        <div class="meta-value">{{ $ticket->user?->email ?? '---' }}</div>
                    </div>

                    <div class="meta-box" style="margin-bottom:14px;">
                        <div class="meta-label">Interlocuteur actuel</div>
                        <div class="meta-value">
                            {{ $ticket->agent?->username ?? 'Votre ticket attend encore une prise en charge.' }}
                        </div>
                    </div>

                    <div class="ticket-actions">
                        <button type="button" class="chat-launch-btn" id="openTicketChat">
                            <span>Conversation du ticket</span>
                        </button>

                        <a href="{{ route('user.tickets.index') }}" class="btn secondary">Mes tickets</a>
                        <a href="{{ route('user.tickets.history') }}" class="btn secondary">Historique</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="chat-overlay" id="ticketChatOverlay"></div>

    <div class="ticket-chat-widget" id="ticketChatWidget">
        <div class="ticket-chat-header">
            <div>
                <div class="ticket-chat-title">Conversation du ticket</div>
                <div class="ticket-chat-subtitle">
                    {{ $ticket->code }} · {{ $ticket->agent?->username ?? 'Aucun agent assigné' }}
                </div>
            </div>

            <button type="button" class="ticket-chat-close" id="closeTicketChat">&times;</button>
        </div>

        <div class="ticket-chat-body" id="conversation">
            @forelse($messages as $message)
                @php
                    $isMine = (int) $message->sender_id === (int) $user->id;
                @endphp

                <div class="chat-row {{ $isMine ? 'mine' : 'other' }}">
                    <div class="chat-bubble {{ $isMine ? 'mine' : 'other' }}">
                        <div class="chat-meta">
                            {{ $isMine ? 'Vous' : ($message->sender?->username ?? 'Agent') }}
                            ·
                            {{ $message->created_at?->format('Y-m-d H:i') }}
                        </div>

                        <div class="chat-text">{{ $message->message }}</div>
                    </div>
                </div>
            @empty
                <div class="chat-empty">
                    Aucun message pour le moment.
                </div>
            @endforelse
        </div>

        <div class="ticket-chat-footer">
            @if(!$ticket->agent)
                <div class="ticket-chat-note">
                    Aucun agent n’est encore assigné à ce ticket. Vous pouvez quand même envoyer un message.
                </div>
            @endif

            <form action="{{ route('user.tickets.messages.store', $ticket->id) }}" method="POST">
                @csrf

                <textarea
                    name="message"
                    class="ticket-chat-textarea"
                    placeholder="Écrivez votre message ici..."
                >{{ old('message') }}</textarea>

                @error('message')
                    <div class="error-text" style="margin-bottom:12px;">{{ $message }}</div>
                @enderror

                <button type="submit" class="ticket-chat-submit">Envoyer le message</button>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const openBtn = document.getElementById('openTicketChat');
            const closeBtn = document.getElementById('closeTicketChat');
            const overlay = document.getElementById('ticketChatOverlay');
            const widget = document.getElementById('ticketChatWidget');

            function openChat() {
                overlay.classList.add('open');
                widget.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeChat() {
                overlay.classList.remove('open');
                widget.classList.remove('open');
                document.body.style.overflow = '';
            }

            openBtn?.addEventListener('click', openChat);
            closeBtn?.addEventListener('click', closeChat);
            overlay?.addEventListener('click', closeChat);

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeChat();
                }
            });

            if (window.location.hash === '#conversation') {
                openChat();
            }
        })();
    </script>
@endsection