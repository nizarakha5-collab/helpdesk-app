<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des tickets</title>

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
        .filters-card,
        .table-card,
        .stat-card,
        .quick-card{
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

        .stats-grid{
            display:grid;
            grid-template-columns:repeat(5,1fr);
            gap:18px;
            margin-bottom:22px
        }
        .stat-card{padding:22px}
        .stat-label{font-size:.9rem;color:#7b88a5;margin-bottom:10px;font-weight:600}
        .stat-value{font-size:2rem;font-weight:800;color:#23345d}

        .filters-card{
            padding:20px;
            margin-bottom:22px;
        }
        .filters-title{
            font-size:1rem;
            font-weight:700;
            color:#2a3756;
            margin-bottom:16px;
        }
        .filters-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:14px;
            align-items:end;
        }
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
            height:54px;
            border:none;
            border-radius:14px;
            padding:0 22px;
            cursor:pointer;
            font-weight:700;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-size:.95rem;
        }
        .btn-primary{background:#2f89d9;color:#fff}
        .btn-light{background:#eef3ff;color:#2f6fd9}

        .table-card{
            overflow:hidden;
            margin-bottom:22px;
        }
        .section-header,
        .table-head{
            display:flex;align-items:center;justify-content:space-between;
            padding:18px 20px;border-bottom:1px solid #edf2f8
        }
        .section-title,
        .table-title{font-size:1rem;font-weight:700;color:#2a3756}
        .table-wrap{overflow:auto}
        table{width:100%;border-collapse:collapse}
        th,td{padding:16px 18px;text-align:left;border-bottom:1px solid #edf2f8;font-size:.95rem}
        th{background:#f8fbff;color:#60708f;font-weight:700}
        td{color:#23345d}

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

        .ticket-link{
            color:#2f6fd9;
            font-weight:700;
            text-decoration:none;
        }

        .quick-card{
            overflow:hidden;
        }
        .quick-header{
            display:flex;align-items:center;justify-content:space-between;
            padding:18px 20px;border-bottom:1px solid #edf2f8
        }
        .quick-title{font-size:1rem;font-weight:700;color:#2a3756}
        .quick-links{
            display:grid;grid-template-columns:repeat(2,1fr);gap:16px;padding:20px
        }
        .quick-link{
            display:block;text-decoration:none;background:#f8fbff;border:1px solid #e4ebf7;
            border-radius:16px;padding:18px;transition:.2s ease
        }
        .quick-link:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(47,137,217,.08)}
        .quick-link-title{font-size:1rem;font-weight:700;color:#23345d;margin-bottom:8px}
        .quick-link-text{font-size:.9rem;color:#7b88a5;line-height:1.6}

        .alert-success{
            background:#ecfdf5;
            border:1px solid #a7f3d0;
            color:#065f46;
            padding:14px 16px;
            border-radius:12px;
            margin-bottom:18px;
            font-weight:600;
        }

        @media(max-width:1300px){
            .stats-grid{grid-template-columns:repeat(2,1fr)}
        }
        @media(max-width:1100px){
            .sidebar{width:230px}
            .filters-grid{grid-template-columns:1fr 1fr}
            .quick-links{grid-template-columns:1fr}
        }
        @media(max-width:900px){
            .dashboard{flex-direction:column}
            .sidebar{width:100%}
            .content{padding:18px}
            .topbar{padding:0 18px}
            .filters-grid{grid-template-columns:1fr}
            .stats-grid{grid-template-columns:1fr}
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

    $activeTicketsCount = $stats['open'] + $stats['pending'] + $stats['in_progress'];
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
            <div class="topbar-title">Liste des tickets</div>

            <div class="topbar-right">
                <a href="{{ route('agent.tickets.index', ['status' => 'open']) }}" class="top-btn primary">
                    Tickets ouverts
                </a>
                <div class="avatar">{{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}</div>
            </div>
        </header>

        <section class="content">
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <div class="welcome-card">
                <h1 class="welcome-title">Gestion des tickets</h1>

                <p class="welcome-text">
                    <strong>Agent :</strong> {{ session('user_name') }}
                </p>

                <p class="welcome-text" style="margin-top:8px;">
                    <strong>Tickets actifs :</strong> {{ $activeTicketsCount }}
                </p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total</div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Ouverts</div>
                    <div class="stat-value">{{ $stats['open'] }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">En attente</div>
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">En cours</div>
                    <div class="stat-value">{{ $stats['in_progress'] }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Résolus / fermés</div>
                    <div class="stat-value">{{ $stats['resolved'] }}</div>
                </div>
            </div>

            <div class="filters-card">
                <div class="filters-title">Filtres</div>

                <form method="GET" action="{{ route('agent.tickets.index') }}">
                    <div class="filters-grid">
                        <div class="field">
                            <label>Statut</label>
                            <select name="status">
                                <option value="">Tous</option>
                                <option value="open" {{ ($filters['status'] ?? '') === 'open' ? 'selected' : '' }}>Ouvert</option>
                                <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="in_progress" {{ ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="resolved" {{ ($filters['status'] ?? '') === 'resolved' ? 'selected' : '' }}>Résolu</option>
                                <option value="closed" {{ ($filters['status'] ?? '') === 'closed' ? 'selected' : '' }}>Fermé</option>
                            </select>
                        </div>

                        <div class="field">
                            <label>Priorité</label>
                            <select name="priority">
                                <option value="">Toutes</option>
                                <option value="low" {{ ($filters['priority'] ?? '') === 'low' ? 'selected' : '' }}>Faible</option>
                                <option value="medium" {{ ($filters['priority'] ?? '') === 'medium' ? 'selected' : '' }}>Moyenne</option>
                                <option value="high" {{ ($filters['priority'] ?? '') === 'high' ? 'selected' : '' }}>Élevée</option>
                                <option value="urgent" {{ ($filters['priority'] ?? '') === 'urgent' ? 'selected' : '' }}>Urgente</option>
                            </select>
                        </div>

                        <div class="field">
                            <label>Catégorie</label>
                            <select name="category">
                                <option value="">Toutes</option>
                                @foreach($availableCategories as $category)
                                    <option value="{{ $category }}" {{ ($filters['category'] ?? '') === $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div style="display:flex;gap:10px;">
                            <button type="submit" class="btn btn-primary">Appliquer</button>
                            <a href="{{ route('agent.tickets.index') }}" class="btn btn-light">Réinitialiser</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-card">
                <div class="table-head">
                    <div class="table-title">Liste complète</div>
                    <a href="{{ route('agent.dashboard') }}" class="top-btn">Retour au tableau de bord</a>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Sujet</th>
                                <th>Utilisateur</th>
                                <th>Catégorie</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Attribué à</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->code }}</td>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>{{ $ticket->user?->username ?? '---' }}</td>
                                    <td>{{ $ticket->category }}</td>
                                    <td>
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
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>{{ $ticket->agent?->username ?? 'Non attribué' }}</td>
                                    <td>
                                        <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="ticket-link">
                                            Voir
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Aucun ticket trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="quick-card">
                <div class="quick-header">
                    <div class="quick-title">Accès rapide</div>
                </div>

                <div class="quick-links">
                    <a href="{{ route('agent.tickets.index', ['status' => 'open']) }}" class="quick-link">
                        <div class="quick-link-title">Tickets ouverts</div>
                        <div class="quick-link-text">Affiche uniquement les tickets ouverts qui attendent une prise en charge.</div>
                    </a>

                    <a href="{{ route('agent.tickets.index', ['status' => 'in_progress']) }}" class="quick-link">
                        <div class="quick-link-title">Tickets en cours</div>
                        <div class="quick-link-text">Retrouve rapidement les tickets déjà pris en charge.</div>
                    </a>

                    <a href="{{ route('agent.tickets.index', ['status' => 'resolved']) }}" class="quick-link">
                        <div class="quick-link-title">Tickets résolus</div>
                        <div class="quick-link-text">Consulte les tickets terminés et prêts pour l’historique.</div>
                    </a>

                    <a href="{{ route('agent.dashboard') }}" class="quick-link">
                        <div class="quick-link-title">Tableau de bord</div>
                        <div class="quick-link-text">Retourne au tableau de bord principal de l’agent.</div>
                    </a>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>