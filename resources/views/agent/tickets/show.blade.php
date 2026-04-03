<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du ticket</title>

    <style>
        *{box-sizing:border-box;margin:0;padding:0;font-family:"Montserrat",Arial,sans-serif}
        body{background:#f4f7fb;color:#1f2a44}
        .dashboard{display:flex;min-height:100vh}

        .sidebar{
            width:280px;
            background:linear-gradient(180deg,#1b2434 0%,#243247 100%);
            color:#fff;
            display:flex;
            flex-direction:column;
            box-shadow:4px 0 20px rgba(0,0,0,.08)
        }
        .sidebar-header{
            height:78px;
            display:flex;
            align-items:center;
            gap:14px;
            padding:0 22px;
            border-bottom:1px solid rgba(255,255,255,.08)
        }
        .logo-box{
            width:34px;height:34px;border-radius:8px;
            background:linear-gradient(135deg,#4a90e2,#7b97f3);
            display:flex;align-items:center;justify-content:center;
            font-size:18px;font-weight:800
        }
        .brand{font-size:1.05rem;font-weight:800;letter-spacing:.4px}
        .sidebar-section-title{
            padding:18px 22px 10px;
            font-size:.78rem;
            color:rgba(255,255,255,.65);
            text-transform:uppercase;
            letter-spacing:.7px
        }
        .menu{display:flex;flex-direction:column;gap:4px;padding:0 10px 18px}
        .menu-item{
            display:flex;align-items:center;gap:12px;
            min-height:50px;padding:0 14px;border-radius:12px;
            text-decoration:none;color:#dce6f8;font-size:.98rem;font-weight:600;
            transition:.2s ease
        }
        .menu-item:hover{background:rgba(255,255,255,.06)}
        .menu-item.active{background:rgba(0,0,0,.22);color:#fff}
        .menu-icon{
            width:22px;height:22px;
            display:inline-flex;align-items:center;justify-content:center;
            font-size:1.05rem;
            filter:grayscale(100%) brightness(300%);
            opacity:.95;flex-shrink:0
        }
        .menu-item.active .menu-icon{opacity:1;filter:grayscale(100%) brightness(360%)}
        .badge{
            margin-left:auto;
            min-width:28px;height:22px;border-radius:999px;
            background:rgba(255,255,255,.14);
            color:#fff;display:inline-flex;align-items:center;justify-content:center;
            font-size:.78rem;font-weight:800;padding:0 8px
        }

        .main{flex:1;display:flex;flex-direction:column;min-width:0}
        .topbar{
            height:78px;background:#fff;border-bottom:1px solid #e6ebf3;
            display:flex;align-items:center;justify-content:space-between;padding:0 26px
        }
        .topbar-title{font-size:1.1rem;font-weight:700;color:#2a3756}
        .topbar-right{display:flex;align-items:center;gap:14px}
        .top-btn{
            height:42px;padding:0 18px;border:1px solid #d7dfec;background:#fff;border-radius:10px;
            color:#344563;font-size:.94rem;font-weight:600;cursor:pointer;
            text-decoration:none;display:inline-flex;align-items:center;justify-content:center;
        }
        .top-btn.primary{background:#2f89d9;border-color:#2f89d9;color:#fff}
        .avatar{
            width:38px;height:38px;border-radius:50%;
            background:linear-gradient(135deg,#233a70,#f0b16d);
            display:flex;align-items:center;justify-content:center;color:#fff;
            font-size:.9rem;font-weight:700
        }

        .content{padding:28px 24px}

        .welcome-card,
        .card{
            background:#fff;border-radius:18px;border:1px solid #e8edf5;
            box-shadow:0 8px 26px rgba(31,42,68,.04)
        }

        .welcome-card{
            padding:24px;
            margin-bottom:22px;
        }
        .welcome-title{font-size:2rem;font-weight:800;color:#23345d;margin-bottom:10px}
        .welcome-text{font-size:1rem;color:#6f7d99;line-height:1.7}
        .welcome-text strong{color:#23345d}

        .grid{
            display:grid;
            grid-template-columns:2fr 1fr;
            gap:22px;
            margin-bottom:22px;
        }

        .card{
            overflow:hidden;
        }
        .card-head{
            padding:18px 20px;
            border-bottom:1px solid #edf2f8;
            font-size:1rem;
            font-weight:700;
            color:#2a3756;
        }
        .card-body{padding:20px}

        .meta-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:16px;
            margin-bottom:18px;
        }
        .meta-box{
            background:#f8fbff;
            border:1px solid #e4ebf7;
            border-radius:14px;
            padding:14px 16px;
        }
        .meta-label{
            font-size:.85rem;
            color:#7b88a5;
            font-weight:700;
            margin-bottom:6px;
        }
        .meta-value{
            font-size:.98rem;
            color:#23345d;
            font-weight:700;
            word-break:break-word;
        }

        .description{
            background:#fbfdff;
            border:1px solid #e9eff8;
            border-radius:14px;
            padding:18px;
            color:#42526e;
            line-height:1.8;
            white-space:pre-line;
        }

        .status-badge,
        .priority-badge{
            display:inline-flex;align-items:center;justify-content:center;
            padding:6px 14px;border-radius:999px;font-size:.82rem;font-weight:800
        }
        .status-open{background:#e8f2ff;color:#2563eb}
        .status-pending{background:#fff4db;color:#b7791f}
        .status-progress{background:#ede9fe;color:#6d28d9}
        .status-resolved{background:#e8fff2;color:#15803d}
        .status-closed{background:#f1f5f9;color:#475569}

        .priority-low{background:#eef2ff;color:#4338ca}
        .priority-medium{background:#ecfeff;color:#0f766e}
        .priority-high{background:#fff7ed;color:#c2410c}
        .priority-urgent{background:#fef2f2;color:#b91c1c}

        .field{margin-bottom:16px}
        .field label{
            display:block;
            margin-bottom:8px;
            font-size:.9rem;
            color:#60708f;
            font-weight:700;
        }
        .field select{
            width:100%;
            height:54px;
            border:1px solid #d8e1ef;
            border-radius:14px;
            padding:0 16px;
            background:#fff;
            color:#23345d;
            outline:none;
            font-size:.95rem;
        }

        .btn{
            height:50px;
            border:none;
            border-radius:14px;
            padding:0 18px;
            cursor:pointer;
            font-weight:700;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:100%;
            font-size:.95rem;
        }
        .btn-primary{background:#2f89d9;color:#fff}
        .btn-dark{background:#243247;color:#fff}
        .btn-light{background:#eef3ff;color:#2f6fd9}

        .alert-success{
            background:#ecfdf5;
            border:1px solid #a7f3d0;
            color:#065f46;
            padding:14px 16px;
            border-radius:12px;
            margin-bottom:18px;
            font-weight:600;
        }
        .error-box{
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#991b1b;
            padding:14px 16px;
            border-radius:12px;
            margin-bottom:18px;
            font-weight:600;
        }

        .chat-launch-btn{
            width:100%;
            height:48px;
            border:none;
            border-radius:14px;
            background:#2f89d9;
            color:#fff;
            font-size:.95rem;
            font-weight:800;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
        }

        .chat-launch-count{
            min-width:28px;
            height:28px;
            border-radius:999px;
            background:rgba(255,255,255,.18);
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:0 8px;
            font-size:.82rem;
            font-weight:800;
        }

        .chat-overlay{
            position:fixed;
            inset:0;
            background:rgba(15,23,42,.18);
            opacity:0;
            pointer-events:none;
            transition:.25s ease;
            z-index:80;
        }
        .chat-overlay.open{
            opacity:1;
            pointer-events:auto;
        }

        .ticket-chat-widget{
            position:fixed;
            top:96px;
            right:24px;
            width:390px;
            height:calc(100vh - 120px);
            background:#fff;
            border:1px solid #dfe7f3;
            border-radius:22px;
            box-shadow:0 20px 60px rgba(31,42,68,.18);
            overflow:hidden;
            z-index:90;
            transform:translateX(110%);
            opacity:0;
            pointer-events:none;
            transition:.28s ease;
            display:flex;
            flex-direction:column;
        }
        .ticket-chat-widget.open{
            transform:translateX(0);
            opacity:1;
            pointer-events:auto;
        }

        .ticket-chat-header{
            min-height:72px;
            padding:16px 18px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            background:linear-gradient(135deg,#eef5ff 0%,#f7fbff 100%);
            border-bottom:1px solid #e6edf8;
        }
        .ticket-chat-title{
            font-size:1rem;
            font-weight:800;
            color:#23345d;
        }
        .ticket-chat-subtitle{
            margin-top:4px;
            font-size:.84rem;
            color:#6f7d99;
            font-weight:600;
        }
        .ticket-chat-close{
            width:40px;
            height:40px;
            border-radius:999px;
            border:1px solid #d7dfec;
            background:#fff;
            color:#23345d;
            font-size:1.3rem;
            font-weight:700;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
        }

        .ticket-chat-body{
            flex:1;
            overflow-y:auto;
            padding:18px;
            background:#f9fbff;
        }

        .chat-row{
            display:flex;
            margin-bottom:14px;
        }
        .chat-row.mine{
            justify-content:flex-end;
        }
        .chat-row.other{
            justify-content:flex-start;
        }
        .chat-bubble{
            max-width:82%;
            border-radius:18px;
            padding:14px 16px;
            box-shadow:0 6px 18px rgba(31,42,68,.05);
        }
        .chat-bubble.mine{
            background:#2f89d9;
            color:#fff;
            border-bottom-right-radius:6px;
        }
        .chat-bubble.other{
            background:#fff;
            color:#23345d;
            border:1px solid #e4ebf7;
            border-bottom-left-radius:6px;
        }
        .chat-meta{
            font-size:.78rem;
            font-weight:700;
            margin-bottom:6px;
            opacity:.88;
        }
        .chat-text{
            line-height:1.7;
            white-space:pre-line;
            word-break:break-word;
        }
        .chat-empty{
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#7b88a5;
            text-align:center;
            padding:20px;
        }

        .ticket-chat-footer{
            padding:16px;
            border-top:1px solid #e6edf8;
            background:#fff;
        }
        .ticket-chat-textarea{
            width:100%;
            min-height:110px;
            border:1px solid #dbe4f0;
            background:#f8fbff;
            border-radius:14px;
            padding:14px;
            outline:none;
            color:#23345d;
            font-size:.95rem;
            resize:vertical;
            margin-bottom:12px;
        }
        .ticket-chat-textarea:focus{
            border-color:#2f89d9;
            background:#fff;
            box-shadow:0 0 0 3px rgba(47,137,217,.10);
        }
        .ticket-chat-submit{
            width:100%;
            height:46px;
            border:none;
            border-radius:14px;
            background:#2f89d9;
            color:#fff;
            font-size:.94rem;
            font-weight:800;
            cursor:pointer;
        }

        @media(max-width:1100px){
            .sidebar{width:230px}
        }
        @media(max-width:900px){
            .dashboard{flex-direction:column}
            .sidebar{width:100%}
            .content{padding:18px}
            .topbar{padding:0 18px}
            .grid{grid-template-columns:1fr}
            .meta-grid{grid-template-columns:1fr}
            .ticket-chat-widget{
                top:90px;
                right:12px;
                left:12px;
                width:auto;
                height:calc(100vh - 108px);
            }
            .chat-bubble{max-width:92%}
        }
    </style>
</head>
<body>
@php
    $statusClasses = [
        'open' => 'status-open',
        'pending' => 'status-pending',
        'in_progress' => 'status-progress',
        'resolved' => 'status-resolved',
        'closed' => 'status-closed',
    ];

    $priorityClasses = [
        'low' => 'priority-low',
        'medium' => 'priority-medium',
        'high' => 'priority-high',
        'urgent' => 'priority-urgent',
    ];

    $messagesCount = $messages->count();
@endphp

<div class="dashboard">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">H</div>
            <div class="brand">HELPDESK</div>
        </div>

        <div class="sidebar-section-title">Agent</div>
        <nav class="menu">
            <a href="{{ route('agent.dashboard') }}" class="menu-item">
                <span class="menu-icon">◔</span>
                <span>Tableau de bord</span>
            </a>

            <a href="{{ route('agent.tickets.index') }}" class="menu-item active">
                <span class="menu-icon">☰</span>
                <span>Tickets</span>
                <span class="badge">{{ $activeTicketsCount }}</span>
            </a>

            <a href="#" class="menu-item">
                <span class="menu-icon">💬</span>
                <span>Chat admin</span>
                <span class="badge">0</span>
            </a>

            <a href="#" class="menu-item">
                <span class="menu-icon">🕘</span>
                <span>Historique</span>
            </a>

            <a href="#" class="menu-item">
                <span class="menu-icon">📊</span>
                <span>Rapports</span>
            </a>
        </nav>

        <div class="sidebar-section-title">Compte</div>
        <nav class="menu">
            <a href="#" class="menu-item">
                <span class="menu-icon">🔔</span>
                <span>Notifications</span>
                <span class="badge">0</span>
            </a>

            <a href="#" class="menu-item">
                <span class="menu-icon">👤</span>
                <span>Profil</span>
            </a>

            <a href="#" class="menu-item">
                <span class="menu-icon">⚙</span>
                <span>Paramètres</span>
            </a>

            <a href="{{ route('logout') }}" class="menu-item">
                <span class="menu-icon">⇦</span>
                <span>Déconnexion</span>
            </a>
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-title">Détails du ticket</div>

            <div class="topbar-right">
                
                <a href="{{ route('agent.tickets.index') }}" class="top-btn">Retour aux tickets</a>
                <div class="avatar">{{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}</div>
            </div>
        </header>

        <section class="content">
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="error-box">{{ $errors->first() }}</div>
            @endif

            <div class="welcome-card">
                <h1 class="welcome-title">Ticket {{ $ticket->code }}</h1>

                <p class="welcome-text">
                    <strong>Sujet :</strong> {{ $ticket->subject }}
                </p>

                <p class="welcome-text" style="margin-top:8px;">
                    <strong>Utilisateur :</strong> {{ $ticket->user?->username ?? '---' }}
                </p>

                <p class="welcome-text" style="margin-top:8px;">
                    <strong>Attribué à :</strong> {{ $ticket->agent?->username ?? 'Non attribué' }}
                </p>
            </div>

            <div class="grid">
                <div class="card">
                    <div class="card-head">Informations du ticket</div>

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
                                <div class="meta-label">Utilisateur</div>
                                <div class="meta-value">{{ $ticket->user?->username ?? '---' }}</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">E-mail</div>
                                <div class="meta-value">{{ $ticket->user?->email ?? '---' }}</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Catégorie</div>
                                <div class="meta-value">{{ $ticket->category }}</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Priorité</div>
                                <div class="meta-value">
                                    <span class="priority-badge {{ $priorityClasses[$ticket->priority] ?? 'priority-medium' }}">
                                        @if($ticket->priority === 'low')
                                            Faible
                                        @elseif($ticket->priority === 'medium')
                                            Moyenne
                                        @elseif($ticket->priority === 'high')
                                            Élevée
                                        @else
                                            Urgente
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Statut</div>
                                <div class="meta-value">
                                    <span class="status-badge {{ $statusClasses[$ticket->status] ?? 'status-open' }}">
                                        @if($ticket->status === 'open')
                                            Ouvert
                                        @elseif($ticket->status === 'pending')
                                            En attente
                                        @elseif($ticket->status === 'in_progress')
                                            En cours
                                        @elseif($ticket->status === 'resolved')
                                            Résolu
                                        @else
                                            Fermé
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Attribué à</div>
                                <div class="meta-value">{{ $ticket->agent?->username ?? 'Non attribué' }}</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Créé le</div>
                                <div class="meta-value">{{ $ticket->created_at?->format('Y-m-d H:i') }}</div>
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
                        <div class="description">{{ $ticket->description }}</div>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:22px;">
                    <div class="card">
                        <div class="card-head">Attribution</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('agent.tickets.assign', $ticket->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-dark">
                                    M’attribuer ce ticket
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">Mise à jour du statut</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('agent.tickets.status', $ticket->id) }}">
                                @csrf

                                <div class="field">
                                    <label>Nouveau statut</label>
                                    <select name="status">
                                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Ouvert</option>
                                        <option value="pending" {{ $ticket->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                        <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Résolu</option>
                                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Fermé</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Enregistrer le statut
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">Conversation</div>

                        <div class="card-body">
                            <button type="button" class="chat-launch-btn" id="openTicketChatSide">
                                <span>Conversation du ticket</span>
                            </button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">Navigation rapide</div>

                        <div class="card-body" style="display:flex;flex-direction:column;gap:12px;">
                            <a href="{{ route('agent.tickets.index') }}" class="btn btn-light">Retour à la liste</a>
                            <a href="{{ route('agent.dashboard') }}" class="btn btn-light">Tableau de bord</a>
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
                            {{ $ticket->code }} · {{ $ticket->user?->username ?? 'Utilisateur' }}
                        </div>
                    </div>

                    <button type="button" class="ticket-chat-close" id="closeTicketChat">&times;</button>
                </div>

                <div class="ticket-chat-body" id="conversation">
                    @forelse($messages as $message)
                        @php
                            $isMine = (int) $message->sender_id === (int) $agent->id;
                        @endphp

                        <div class="chat-row {{ $isMine ? 'mine' : 'other' }}">
                            <div class="chat-bubble {{ $isMine ? 'mine' : 'other' }}">
                                <div class="chat-meta">
                                    {{ $isMine ? 'Vous' : ($message->sender?->username ?? 'Utilisateur') }}
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
                    <form action="{{ route('agent.tickets.messages.store', $ticket->id) }}" method="POST">
                        @csrf

                        <textarea
                            name="message"
                            class="ticket-chat-textarea"
                            placeholder="Écrivez votre réponse ici..."
                        >{{ old('message') }}</textarea>

                        @error('message')
                            <div class="error-box" style="margin-bottom:12px;">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="ticket-chat-submit">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    (function () {
        const topBtn = document.getElementById('openTicketChat');
        const sideBtn = document.getElementById('openTicketChatSide');
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

        topBtn?.addEventListener('click', openChat);
        sideBtn?.addEventListener('click', openChat);
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
</body>
</html>