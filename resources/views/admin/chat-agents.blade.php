<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat agents | Admin</title>

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
            box-shadow:4px 0 20px rgba(0, 0, 0, 0.08);
        }

        .sidebar-header{
            height:78px;
            display:flex;
            align-items:center;
            gap:14px;
            padding:0 22px;
            border-bottom:1px solid rgba(255,255,255,.08);
        }

        .logo-box{
            width:34px;
            height:34px;
            border-radius:8px;
            background:linear-gradient(135deg,#4a90e2,#7b97f3);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
            font-weight:800;
        }

        .brand{
            font-size:1.05rem;
            font-weight:800;
            letter-spacing:.4px;
        }

        .sidebar-section-title{
            padding:18px 22px 10px;
            font-size:.78rem;
            color:rgba(255,255,255,.65);
            text-transform:uppercase;
            letter-spacing:.7px;
        }

        .menu{
            display:flex;
            flex-direction:column;
            gap:4px;
            padding:0 10px 20px;
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
            transition:.2s ease;
        }

        .menu-item:hover{background:rgba(255,255,255,.06);}
        .menu-item.active{background:rgba(0,0,0,.22);color:#fff;}
        .menu-icon{
            width:22px;height:22px;
            display:inline-flex;align-items:center;justify-content:center;
            font-size:1.05rem;filter:grayscale(100%) brightness(300%);
            opacity:.95;flex-shrink:0;
        }
        .menu-item.active .menu-icon{opacity:1;filter:grayscale(100%) brightness(360%);}
        .badge{
            margin-left:auto;
            min-width:28px;height:22px;border-radius:999px;
            background:rgba(255,255,255,.14);color:#fff;
            display:inline-flex;align-items:center;justify-content:center;
            font-size:.78rem;font-weight:800;padding:0 8px;
        }

        .main{flex:1;display:flex;flex-direction:column;min-width:0}
        .topbar{
            height:78px;background:#fff;border-bottom:1px solid #e6ebf3;
            display:flex;align-items:center;justify-content:space-between;padding:0 26px;
        }
        .topbar-title{font-size:1.1rem;font-weight:700;color:#2a3756;}
        .avatar{
            width:38px;height:38px;border-radius:50%;
            background:linear-gradient(135deg,#233a70,#f0b16d);
            display:flex;align-items:center;justify-content:center;color:#fff;
            font-size:.9rem;font-weight:700;
        }

        .content{padding:28px 24px}
        .chat-shell{
            background:#fff;
            border-radius:22px;
            border:1px solid #e8edf5;
            box-shadow:0 8px 26px rgba(31,42,68,.04);
            overflow:hidden;
            display:grid;
            grid-template-columns:340px 1fr;
            min-height:calc(100vh - 150px);
        }

        .contacts-panel{
            border-right:1px solid #edf2f8;
            background:#fbfcff;
            display:flex;
            flex-direction:column;
            min-width:0;
        }

        .contacts-head{
            padding:18px 18px 16px;
            border-bottom:1px solid #edf2f8;
        }

        .contacts-title{
            font-size:1.2rem;
            font-weight:800;
            color:#23345d;
            margin-bottom:6px;
        }

        .contacts-text{
            color:#7b88a5;
            font-size:.9rem;
            line-height:1.6;
        }

        .contacts-list{
            overflow-y:auto;
            flex:1;
            padding:10px;
        }

        .contact-item{
            display:flex;
            gap:12px;
            align-items:flex-start;
            padding:14px 12px;
            border-radius:16px;
            text-decoration:none;
            color:inherit;
            transition:.2s ease;
            margin-bottom:8px;
            background:#fff;
            border:1px solid transparent;
        }

        .contact-item:hover{
            background:#f8fbff;
            border-color:#e4ebf7;
        }

        .contact-item.active{
            background:#eef5ff;
            border-color:#d6e4ff;
        }

        .contact-avatar{
            width:46px;height:46px;border-radius:50%;
            background:linear-gradient(135deg,#233a70,#f0b16d);
            color:#fff;display:flex;align-items:center;justify-content:center;
            font-weight:800;flex-shrink:0;
        }

        .contact-body{min-width:0;flex:1;}
        .contact-top{
            display:flex;justify-content:space-between;gap:10px;
            margin-bottom:4px;align-items:center;
        }
        .contact-name{
            font-size:.96rem;font-weight:800;color:#23345d;
            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
        }
        .contact-time{
            font-size:.78rem;color:#7b88a5;flex-shrink:0;
        }
        .contact-sub{
            font-size:.84rem;color:#7b88a5;margin-bottom:6px;
            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
        }
        .contact-preview{
            display:flex;justify-content:space-between;gap:10px;align-items:center;
        }
        .contact-preview-text{
            font-size:.84rem;color:#42526e;
            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
        }
        .contact-unread{
            min-width:22px;height:22px;border-radius:999px;
            background:#2f89d9;color:#fff;
            display:inline-flex;align-items:center;justify-content:center;
            font-size:.74rem;font-weight:800;padding:0 6px;flex-shrink:0;
        }

        .conversation-panel{
            display:flex;
            flex-direction:column;
            min-width:0;
            background:#fff;
        }

        .conversation-head{
            min-height:78px;
            padding:16px 20px;
            border-bottom:1px solid #edf2f8;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:14px;
            background:#ffffff;
        }

        .conversation-user{
            display:flex;
            align-items:center;
            gap:12px;
            min-width:0;
        }

        .conversation-avatar{
            width:48px;height:48px;border-radius:50%;
            background:linear-gradient(135deg,#233a70,#f0b16d);
            color:#fff;display:flex;align-items:center;justify-content:center;
            font-weight:800;flex-shrink:0;
        }

        .conversation-name{
            font-size:1rem;font-weight:800;color:#23345d;margin-bottom:4px;
        }

        .conversation-sub{
            font-size:.88rem;color:#7b88a5;
            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
        }

        .conversation-body{
            flex:1;
            overflow-y:auto;
            padding:20px;
            background:#f6f8fc;
        }

        .message-row{display:flex;margin-bottom:14px;}
        .message-row.mine{justify-content:flex-end;}
        .message-row.other{justify-content:flex-start;}

        .message-bubble{
            max-width:72%;
            padding:12px 14px;
            border-radius:18px;
            line-height:1.7;
            box-shadow:0 6px 18px rgba(31,42,68,.05);
        }

        .message-bubble.mine{
            background:#2f89d9;color:#fff;border-bottom-right-radius:6px;
        }

        .message-bubble.other{
            background:#fff;color:#23345d;border:1px solid #e4ebf7;border-bottom-left-radius:6px;
        }

        .message-meta{
            font-size:.78rem;font-weight:700;margin-bottom:5px;opacity:.88;
        }

        .conversation-empty{
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            color:#7b88a5;
            padding:24px;
        }

        .composer{
            padding:16px;
            border-top:1px solid #edf2f8;
            background:#fff;
        }

        .composer-form{
            display:flex;
            gap:12px;
            align-items:flex-end;
        }

        .composer-textarea{
            flex:1;
            min-height:54px;
            max-height:140px;
            border:1px solid #d7dfec;
            border-radius:16px;
            padding:14px 16px;
            resize:vertical;
            outline:none;
            font-size:.95rem;
            background:#f8fbff;
        }

        .composer-textarea:focus{
            border-color:#2f89d9;
            box-shadow:0 0 0 3px rgba(47,137,217,.10);
            background:#fff;
        }

        .composer-btn{
            min-width:120px;
            height:54px;
            border:none;
            border-radius:16px;
            background:#2f89d9;
            color:#fff;
            font-weight:800;
            cursor:pointer;
            padding:0 18px;
        }

        .form-error{
            margin-top:10px;
            color:#b42318;
            font-size:.86rem;
            font-weight:700;
        }

        .empty-contact{
            padding:24px;
            text-align:center;
            color:#7b88a5;
            font-size:.95rem;
        }

        @media(max-width:1200px){
            .chat-shell{grid-template-columns:300px 1fr;}
        }

        @media(max-width:900px){
            .dashboard{flex-direction:column}
            .sidebar{width:100%}
            .content{padding:18px}
            .topbar{padding:0 18px}
            .chat-shell{
                grid-template-columns:1fr;
                min-height:auto;
            }
            .contacts-panel{
                max-height:320px;
                border-right:none;
                border-bottom:1px solid #edf2f8;
            }
            .conversation-body{min-height:360px;}
            .message-bubble{max-width:88%;}
            .composer-form{flex-direction:column;align-items:stretch;}
            .composer-btn{width:100%;}
        }
    </style>
</head>
<body>
@php
    $agentChatUnreadCount = \App\Models\AdminAgentMessage::where('receiver_id', session('user_id'))
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

            <a href="{{ route('admin.chat.index') }}" class="menu-item active">
                <span class="menu-icon">✉</span>
                <span>Chat agents</span>
                <span class="badge">{{ $agentChatUnreadCount }}</span>
            </a>
        </nav>

        <div class="sidebar-section-title">Account</div>
        <nav class="menu">
            <a href="{{ route('admin.accounts') }}" class="menu-item">
                <span class="menu-icon">👤</span>
                <span>Liste des Accounts</span>
            </a>

          @php
    $adminNotificationsCount = \App\Models\UserNotification::where('user_id', session('user_id'))
        ->where('is_read', false)
        ->count();
@endphp

<a href="{{ route('admin.notifications') }}" class="menu-item {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
    <span class="menu-icon">🔔</span>
    <span>Notifications</span>
    <span class="badge">{{ $adminNotificationsCount }}</span>
</a>

            <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
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
            <div class="topbar-title">Chat agents</div>
            <div class="avatar">{{ strtoupper(substr($admin->username ?? 'A', 0, 1)) }}</div>
        </header>

        <section class="content">
            <div class="chat-shell">
                <aside class="contacts-panel">
                    <div class="contacts-head">
                        <div class="contacts-title">Agents</div>
                        <div class="contacts-text">
                            Choisissez un agent pour démarrer ou continuer la conversation.
                        </div>
                    </div>

                    <div class="contacts-list">
                        @forelse ($contacts as $item)
                            @php
                                $contact = $item['contact'];
                                $lastMessage = $item['lastMessage'];
                                $isActive = $selectedAgent && $selectedAgent->id === $contact->id;
                            @endphp

                            <a href="{{ route('admin.chat.index', ['agentUser' => $contact->id]) }}" class="contact-item {{ $isActive ? 'active' : '' }}">
                                <div class="contact-avatar">{{ strtoupper(substr($contact->username, 0, 1)) }}</div>

                                <div class="contact-body">
                                    <div class="contact-top">
                                        <div class="contact-name">{{ $contact->username }}</div>
                                        <div class="contact-time">
                                            {{ $lastMessage?->created_at?->format('H:i') ?? '' }}
                                        </div>
                                    </div>

                                    <div class="contact-sub">
                                        {{ $contact->email }}
                                        @if (!empty($contact->speciality))
                                            · {{ $contact->speciality }}
                                        @endif
                                    </div>

                                    <div class="contact-preview">
                                        <div class="contact-preview-text">
                                            @if ($lastMessage)
                                                @if ($lastMessage->sender_id === $admin->id)
                                                    Vous:
                                                @endif
                                                {{ \Illuminate\Support\Str::limit($lastMessage->message, 36) }}
                                            @else
                                                Aucune conversation pour le moment.
                                            @endif
                                        </div>

                                        @if ($item['unreadCount'] > 0)
                                            <span class="contact-unread">{{ $item['unreadCount'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="empty-contact">
                                Aucun agent actif disponible.
                            </div>
                        @endforelse
                    </div>
                </aside>

                <section class="conversation-panel">
                    @if ($selectedAgent)
                        <div class="conversation-head">
                            <div class="conversation-user">
                                <div class="conversation-avatar">{{ strtoupper(substr($selectedAgent->username, 0, 1)) }}</div>

                                <div style="min-width:0;">
                                    <div class="conversation-name">{{ $selectedAgent->username }}</div>
                                    <div class="conversation-sub">
                                        {{ $selectedAgent->email }}
                                        @if (!empty($selectedAgent->speciality))
                                            · {{ $selectedAgent->speciality }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="conversation-body" id="conversationBody">
                            @forelse ($messages as $message)
                                @php
                                    $isMine = (int) $message->sender_id === (int) $admin->id;
                                @endphp

                                <div class="message-row {{ $isMine ? 'mine' : 'other' }}">
                                    <div class="message-bubble {{ $isMine ? 'mine' : 'other' }}">
                                        <div class="message-meta">
                                            {{ $isMine ? 'Vous' : ($message->sender?->username ?? 'Agent') }}
                                            ·
                                            {{ $message->created_at?->format('Y-m-d H:i') }}
                                        </div>

                                        <div>{{ $message->message }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="conversation-empty">
                                    Aucun message pour le moment. Commencez la conversation avec cet agent.
                                </div>
                            @endforelse
                        </div>

                        <div class="composer">
                            <form method="POST" action="{{ route('admin.chat.send', ['agentUser' => $selectedAgent->id]) }}" class="composer-form">
                                @csrf

                                <textarea
                                    name="message"
                                    class="composer-textarea"
                                    placeholder="Écrivez votre message..."
                                    required
                                >{{ old('message') }}</textarea>

                                <button type="submit" class="composer-btn">Envoyer</button>
                            </form>

                            @error('message')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <div class="conversation-empty">
                            Sélectionnez un agent dans la liste de gauche pour afficher la conversation.
                        </div>
                    @endif
                </section>
            </div>
        </section>
    </main>
</div>

<script>
    const conversationBody = document.getElementById('conversationBody');
    if (conversationBody) {
        conversationBody.scrollTop = conversationBody.scrollHeight;
    }
</script>
</body>
</html>