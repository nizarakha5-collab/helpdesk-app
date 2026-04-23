<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notifications</title>

    <style>
        *{box-sizing:border-box;margin:0;padding:0;font-family:"Montserrat",Arial,sans-serif}
        body{background:#f4f7fb;color:#1f2a44}
        .dashboard{display:flex;min-height:100vh}

        .sidebar{
            width:280px;
            background:linear-gradient(180deg,#1b2434 0%,#243247 100%);
            color:#ffffff;
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

        .menu{
            display:flex;
            flex-direction:column;
            gap:4px;
            padding:0 10px 20px
        }

        .menu-item{
            display:flex;
            align-items:center;
            gap:12px;
            min-height:50px;
            padding:0 14px;
            border-radius:12px;
            text-decoration:none;
            color:#dce6f8;
            font-size:.98rem;
            font-weight:600;
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
            background:rgba(255,255,255,.14);color:#fff;
            display:inline-flex;align-items:center;justify-content:center;
            font-size:.78rem;font-weight:800;padding:0 8px
        }

        .main{flex:1;display:flex;flex-direction:column;min-width:0}

        .topbar{
            height:78px;background:#fff;border-bottom:1px solid #e6ebf3;
            display:flex;align-items:center;justify-content:space-between;padding:0 26px
        }

        .topbar-title{font-size:1.1rem;font-weight:700;color:#2a3756}

        .avatar{
            width:38px;height:38px;border-radius:50%;
            background:linear-gradient(135deg,#233a70,#f0b16d);
            display:flex;align-items:center;justify-content:center;color:#fff;
            font-size:.9rem;font-weight:700
        }

        .content{padding:28px 24px}

        .page-card,.notification-item{
            background:#fff;border-radius:18px;border:1px solid #e8edf5;
            box-shadow:0 8px 26px rgba(31,42,68,.04)
        }

        .page-card{padding:22px;margin-bottom:22px}
        .page-title{font-size:2rem;font-weight:800;color:#23345d;margin-bottom:10px}
        .page-text{font-size:.96rem;color:#6f7d99;line-height:1.7}

        .success-message{
            margin-bottom:16px;padding:12px 14px;border-radius:12px;
            background:#eaf8ee;color:#166534;border:1px solid #bde7c9;font-size:.94rem
        }

        .toolbar{
            display:flex;justify-content:space-between;align-items:center;
            gap:12px;flex-wrap:wrap;margin-bottom:18px
        }

        .toolbar-text{font-size:.95rem;color:#6f7d99}
        .toolbar-btn{
            height:42px;border:none;border-radius:12px;padding:0 16px;
            background:#2f89d9;color:#fff;font-weight:800;cursor:pointer
        }

        .notifications-list{display:grid;gap:16px}

        .notification-item{padding:20px}
        .notification-item.unread{
            border-left:5px solid #2f89d9;
            background:#fbfdff;
        }

        .notification-head{
            display:flex;justify-content:space-between;gap:16px;align-items:flex-start;
            margin-bottom:10px
        }

        .notification-title{
            font-size:1.05rem;font-weight:800;color:#23345d;margin-bottom:4px
        }

        .notification-meta{
            font-size:.85rem;color:#7b88a5;font-weight:600
        }

        .notification-message{
            font-size:.95rem;color:#42526e;line-height:1.7;margin-bottom:14px
        }

        .notification-actions{
            display:flex;gap:10px;flex-wrap:wrap
        }

        .notification-btn,
        .notification-link{
            height:40px;border-radius:12px;padding:0 16px;font-size:.9rem;
            font-weight:800;display:inline-flex;align-items:center;justify-content:center;
            text-decoration:none;cursor:pointer
        }

        .notification-btn{
            border:none;background:#2f89d9;color:#fff
        }

        .notification-link{
            border:1px solid #d7dfec;background:#fff;color:#344563
        }

        .notification-badge{
            min-width:92px;height:34px;border-radius:999px;padding:0 12px;
            font-size:.82rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center
        }

        .notification-badge.unread{background:#e8f2ff;color:#2563eb}
        .notification-badge.read{background:#eef2f7;color:#475569}

        .empty-state{
            background:#fff;border-radius:18px;border:1px solid #e8edf5;
            box-shadow:0 8px 26px rgba(31,42,68,.04);
            padding:26px;color:#7b88a5;font-size:.96rem
        }

        @media(max-width:900px){
            .dashboard{flex-direction:column}
            .sidebar{width:100%}
            .content{padding:18px}
            .topbar{padding:0 18px}
            .notification-head{flex-direction:column}
        }
    </style>
</head>
<body>
@php
    $adminChatUnreadCount = \App\Models\AdminAgentMessage::where('receiver_id', session('user_id'))
        ->where('is_read', false)
        ->whereHas('sender', function ($query) {
            $query->where('role', 'agent');
        })
        ->count();
@endphp

<div class="dashboard">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">L</div>
            <div class="brand">HELPDESK</div>
        </div>

        <div class="sidebar-section-title">General</div>
        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <span class="menu-icon">◔</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.confirmations') }}" class="menu-item">
                <span class="menu-icon">☰</span>
                <span>Confirmations</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="menu-item">
                <span class="menu-icon">⌘</span>
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.users') }}" class="menu-item">
                <span class="menu-icon">＋</span>
                <span>Create Accounts</span>
            </a>

            <a href="{{ route('admin.chat.index') }}" class="menu-item">
                <span class="menu-icon">✉</span>
                <span>Chat agents</span>
                <span class="badge">{{ $adminChatUnreadCount }}</span>
            </a>
        </nav>

        <div class="sidebar-section-title">Account</div>
        <nav class="menu">
            <a href="{{ route('admin.accounts') }}" class="menu-item">
                <span class="menu-icon">👤</span>
                <span>Liste des Accounts</span>
            </a>

            <a href="{{ route('admin.notifications') }}" class="menu-item active">
                <span class="menu-icon">🔔</span>
                <span>Notifications</span>
                <span class="badge">{{ $unreadCount }}</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="menu-item">
                <span class="menu-icon">⚙</span>
                <span>Settings</span>
            </a>

            <a href="{{ route('logout') }}" class="menu-item">
                <span class="menu-icon">⇦</span>
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-title">Admin Notifications</div>
            <div class="avatar">{{ strtoupper(substr($admin->username ?? 'A', 0, 1)) }}</div>
        </header>

        <section class="content">
            <div class="page-card">
                <div class="page-title">Notifications administrateur</div>
                <p class="page-text">
                    Consultez ici les nouveaux comptes en attente et les messages reçus des agents.
                </p>
            </div>

            @if (session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            <div class="toolbar">
                <div class="toolbar-text">
                    Notifications non lues : <strong>{{ $unreadCount }}</strong>
                </div>

                @if ($unreadCount > 0)
                    <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                        @csrf
                        <button type="submit" class="toolbar-btn">Tout marquer comme lu</button>
                    </form>
                @endif
            </div>

            @if ($notifications->count())
                <div class="notifications-list">
                    @foreach ($notifications as $notification)
                        <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">
                            <div class="notification-head">
                                <div>
                                    <div class="notification-title">{{ $notification->title }}</div>
                                    <div class="notification-meta">
                                        {{ $notification->created_at?->format('Y-m-d H:i') }}
                                    </div>
                                </div>

                                <div>
                                    @if ($notification->is_read)
                                        <span class="notification-badge read">Lue</span>
                                    @else
                                        <span class="notification-badge unread">Non lue</span>
                                    @endif
                                </div>
                            </div>

                            <div class="notification-message">
                                {{ $notification->message }}
                            </div>

                            <div class="notification-actions">
                                @if (!$notification->is_read)
                                    <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}">
                                        @csrf
                                        <button type="submit" class="notification-btn">Marquer comme lu</button>
                                    </form>
                                @endif

                                @if ($notification->type === 'pending_account')
                                    <a href="{{ route('admin.confirmations') }}" class="notification-link">
                                        Voir confirmations
                                    </a>
                                @elseif ($notification->type === 'agent_chat_message' && $notification->related_user_id)
                                    <a href="{{ route('admin.chat.index', ['agentUser' => $notification->related_user_id]) }}" class="notification-link">
                                        Ouvrir le chat
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:18px;">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="empty-state">
                    Aucune notification pour le moment.
                </div>
            @endif
        </section>
    </main>
</div>
</body>
</html>