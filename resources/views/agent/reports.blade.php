<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports agent</title>

    <style>
        *{box-sizing:border-box;margin:0;padding:0;font-family:"Montserrat",Arial,sans-serif}
        body{background:#f4f7fb;color:#1f2a44}
        .dashboard{display:flex;min-height:100vh}

        .sidebar{width:280px;background:linear-gradient(180deg,#1b2434 0%,#243247 100%);color:#fff;display:flex;flex-direction:column;box-shadow:4px 0 20px rgba(0,0,0,.08)}
        .sidebar-header{height:78px;display:flex;align-items:center;gap:14px;padding:0 22px;border-bottom:1px solid rgba(255,255,255,.08)}
        .logo-box{width:34px;height:34px;border-radius:8px;background:linear-gradient(135deg,#4a90e2,#7b97f3);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800}
        .brand{font-size:1.05rem;font-weight:800;letter-spacing:.4px}
        .sidebar-section-title{padding:18px 22px 10px;font-size:.78rem;color:rgba(255,255,255,.65);text-transform:uppercase;letter-spacing:.7px}
        .menu{display:flex;flex-direction:column;gap:4px;padding:0 10px 18px}
        .menu-item{display:flex;align-items:center;gap:12px;min-height:50px;padding:0 14px;border-radius:12px;text-decoration:none;color:#dce6f8;font-size:.98rem;font-weight:600;transition:.2s ease}
        .menu-item:hover{background:rgba(255,255,255,.06)}
        .menu-item.active{background:rgba(0,0,0,.22);color:#fff}
        .menu-icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:1.05rem;filter:grayscale(100%) brightness(300%);opacity:.95;flex-shrink:0}
        .menu-item.active .menu-icon{opacity:1;filter:grayscale(100%) brightness(360%)}
        .badge{margin-left:auto;min-width:28px;height:22px;border-radius:999px;background:rgba(255,255,255,.14);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:800;padding:0 8px}

        .main{flex:1;display:flex;flex-direction:column;min-width:0}
        .topbar{height:78px;background:#fff;border-bottom:1px solid #e6ebf3;display:flex;align-items:center;justify-content:space-between;padding:0 26px}
        .topbar-title{font-size:1.1rem;font-weight:700;color:#2a3756}
        .topbar-right{display:flex;align-items:center;gap:14px}
        .top-btn{height:42px;padding:0 18px;border:1px solid #d7dfec;background:#fff;border-radius:10px;color:#344563;font-size:.94rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}
        .top-btn.primary{background:#2f89d9;border-color:#2f89d9;color:#fff}
        .avatar{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#233a70,#f0b16d);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;font-weight:700}

        .content{padding:28px 24px}

        .page-card,.stat-card,.table-card{
            background:#fff;border-radius:18px;border:1px solid #e8edf5;box-shadow:0 8px 26px rgba(31,42,68,.04)
        }

        .page-card{padding:24px;margin-bottom:22px}
        .page-title{font-size:2rem;font-weight:800;color:#23345d;margin-bottom:10px}
        .page-text{font-size:1rem;color:#6f7d99;line-height:1.7}

        .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-bottom:22px}
        .stat-card{padding:22px}
        .stat-label{font-size:.9rem;color:#7b88a5;margin-bottom:10px;font-weight:600}
        .stat-value{font-size:2rem;font-weight:800;color:#23345d}

        .report-grid{display:grid;grid-template-columns:1fr 1fr;gap:22px;margin-bottom:22px}

        .table-card{overflow:hidden}
        .section-header{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid #edf2f8}
        .section-title{font-size:1rem;font-weight:700;color:#2a3756}
        .table-wrap{overflow:auto}
        table{width:100%;border-collapse:collapse}
        th,td{padding:16px 18px;text-align:left;border-bottom:1px solid #edf2f8;font-size:.95rem}
        th{background:#f8fbff;color:#60708f;font-weight:700}
        td{color:#23345d}

        .status-badge{
            display:inline-flex;align-items:center;justify-content:center;
            padding:6px 14px;border-radius:999px;font-size:.82rem;font-weight:800
        }
        .status-resolved{background:#e8fff2;color:#15803d}
        .status-closed{background:#f1f5f9;color:#475569}

        .ticket-link{color:#2f6fd9;font-weight:700;text-decoration:none}

        @media(max-width:1200px){
            .report-grid{grid-template-columns:1fr}
            .stats-grid{grid-template-columns:1fr 1fr}
        }
        @media(max-width:1100px){
            .sidebar{width:230px}
        }
        @media(max-width:900px){
            .dashboard{flex-direction:column}
            .sidebar{width:100%}
            .content{padding:18px}
            .topbar{padding:0 18px}
            .stats-grid{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
@php
    $activeTicketsCount = \App\Models\Ticket::whereIn('status', ['open', 'pending', 'in_progress'])->count();
    $unreadNotificationsCount = \App\Models\UserNotification::where('user_id', session('user_id'))->where('is_read', false)->count();

    $priorityLabels = [
        'low' => 'Faible',
        'medium' => 'Moyenne',
        'high' => 'Élevée',
        'urgent' => 'Urgente',
    ];
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

            <a href="{{ route('agent.tickets.index') }}" class="menu-item">
                <span class="menu-icon">☰</span>
                <span>Tickets</span>
                <span class="badge">{{ $activeTicketsCount }}</span>
            </a>

           @php
    $adminChatUnreadCount = \App\Models\AdminAgentMessage::where('receiver_id', session('user_id'))
        ->where('is_read', false)
        ->whereHas('sender', function ($query) {
            $query->where('role', 'admin');
        })
        ->count();
@endphp

<a href="{{ route('agent.chat.index') }}" class="menu-item {{ request()->routeIs('agent.chat.*') ? 'active' : '' }}">
    <span class="menu-icon">💬</span>
    <span>Chat admin</span>
    <span class="badge">{{ $adminChatUnreadCount }}</span>
</a>

            <a href="{{ route('agent.history') }}" class="menu-item {{ request()->routeIs('agent.history') ? 'active' : '' }}">
    <span class="menu-icon">🕘</span>
    <span>Historique</span>
</a>



            <a href="{{ route('agent.reports') }}" class="menu-item active">
                <span class="menu-icon">📊</span>
                <span>Rapports</span>
            </a>
        </nav>

        <div class="sidebar-section-title">Compte</div>
        <nav class="menu">
            <a href="{{ route('agent.notifications') }}" class="menu-item">
                <span class="menu-icon">🔔</span>
                <span>Notifications</span>
                <span class="badge">{{ $unreadNotificationsCount }}</span>
            </a>

            <a href="{{ route('agent.profile') }}" class="menu-item">
                <span class="menu-icon">👤</span>
                <span>Profil</span>
            </a>

            <a href="{{ route('agent.settings') }}" class="menu-item">
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
            <div class="topbar-title">Rapports agent</div>

            <div class="topbar-right">
                <a href="{{ route('agent.history') }}" class="top-btn primary">Voir historique</a>
                <div class="avatar">{{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}</div>
            </div>
        </header>

        <section class="content">
            <div class="page-card">
                <h1 class="page-title">Rapports & performances</h1>
                <p class="page-text">
                    Consultez ici vos statistiques globales sur les tickets qui vous ont été attribués.
                </p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total tickets attribués</div>
                    <div class="stat-value">{{ $myTotalTickets }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Tickets actifs</div>
                    <div class="stat-value">{{ $myOpenTickets + $myPendingTickets + $myInProgressTickets }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Tickets urgents</div>
                    <div class="stat-value">{{ $myUrgentTickets }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Tickets résolus</div>
                    <div class="stat-value">{{ $myResolvedTickets }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Tickets fermés</div>
                    <div class="stat-value">{{ $myClosedTickets }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Taux de traitement</div>
                    <div class="stat-value">{{ $completionRate }}%</div>
                </div>
            </div>

            <div class="report-grid">
                <div class="table-card">
                    <div class="section-header">
                        <div class="section-title">Répartition par priorité</div>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Priorité</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($priorityStats as $row)
                                    <tr>
                                        <td>{{ $priorityLabels[$row->priority] ?? ucfirst($row->priority) }}</td>
                                        <td>{{ $row->total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">Aucune donnée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-card">
                    <div class="section-header">
                        <div class="section-title">Répartition par catégorie</div>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Catégorie</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categoryStats as $row)
                                    <tr>
                                        <td>{{ $row->category }}</td>
                                        <td>{{ $row->total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">Aucune donnée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="section-header">
                    <div class="section-title">Derniers tickets traités</div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Sujet</th>
                                <th>Utilisateur</th>
                                <th>Statut final</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentHandledTickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->code }}</td>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>{{ $ticket->user?->username ?? '---' }}</td>
                                    <td>
                                        @if($ticket->status === 'resolved')
                                            <span class="status-badge status-resolved">Résolu</span>
                                        @else
                                            <span class="status-badge status-closed">Fermé</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ticket->status === 'closed' && $ticket->closed_at)
                                            {{ $ticket->closed_at->format('Y-m-d H:i') }}
                                        @elseif($ticket->resolved_at)
                                            {{ $ticket->resolved_at->format('Y-m-d H:i') }}
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="ticket-link">Voir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Aucun ticket traité pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>