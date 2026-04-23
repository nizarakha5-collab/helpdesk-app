<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres agent</title>

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
        .avatar{
            width:38px;height:38px;border-radius:50%;
            background:linear-gradient(135deg,#233a70,#f0b16d);
            display:flex;align-items:center;justify-content:center;color:#fff;
            font-size:.9rem;font-weight:700
        }

        .content{padding:28px 24px}

        .page-card,
        .password-card{
            background:#fff;border-radius:18px;border:1px solid #e8edf5;
            box-shadow:0 8px 26px rgba(31,42,68,.04);
            padding:22px;
            margin-bottom:22px;
        }

        .page-title{
            font-size:2rem;
            font-weight:800;
            color:#23345d;
            margin-bottom:10px
        }

        .page-text{
            font-size:.96rem;
            color:#6f7d99;
            line-height:1.7
        }

        .success-message{
            margin-bottom:16px;padding:12px 14px;border-radius:12px;
            background:#eaf8ee;color:#166534;border:1px solid #bde7c9;font-size:.94rem
        }

        .error-message{
            margin-bottom:16px;padding:12px 14px;border-radius:12px;
            background:#fff1f1;color:#b42318;border:1px solid #f3c3c3;font-size:.94rem
        }

        .section-title{
            font-size:1.3rem;
            font-weight:800;
            color:#23345d;
            margin-bottom:10px
        }

        .section-text{
            font-size:.95rem;
            color:#6f7d99;
            line-height:1.7;
            margin-bottom:18px
        }

        .info-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:16px;
            margin-top:10px;
        }

        .info-item{
            background:#f8fbff;
            border:1px solid #e4ebf7;
            border-radius:14px;
            padding:14px 16px;
        }

        .info-label{
            font-size:.82rem;
            color:#7b88a5;
            font-weight:700;
            margin-bottom:6px;
        }

        .info-value{
            font-size:.95rem;
            color:#23345d;
            font-weight:700;
            word-break:break-word;
        }

        .form-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:16px;
        }

        .field{
            display:flex;
            flex-direction:column;
            gap:6px;
            margin-bottom:14px;
        }

        .field.full{
            grid-column:1 / -1;
        }

        .field label{
            font-weight:800;
            color:#23345d;
            font-size:.92rem;
        }

        .field input{
            height:44px;
            border:1px solid #d7dfec;
            border-radius:12px;
            padding:0 12px;
            font-size:.95rem;
            outline:none;
            background:#fff;
        }

        .btn{
            height:46px;
            border-radius:12px;
            border:none;
            padding:0 18px;
            font-weight:800;
            cursor:pointer;
            background:#2f89d9;
            color:#fff
        }

        @media(max-width:1000px){
            .info-grid,
            .form-grid{
                grid-template-columns:1fr
            }

            .field.full{
                grid-column:auto
            }

            .sidebar{width:230px}
        }

        @media(max-width:900px){
            .dashboard{flex-direction:column}
            .sidebar{width:100%}
            .content{padding:18px}
            .topbar{padding:0 18px}
        }
    </style>
</head>
<body>
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

<a href="{{ route('agent.reports') }}" class="menu-item {{ request()->routeIs('agent.reports') ? 'active' : '' }}">
    <span class="menu-icon">📊</span>
    <span>Rapports</span>
</a>
        </nav>

        <div class="sidebar-section-title">Compte</div>
        <nav class="menu">
           <a href="{{ route('agent.notifications') }}" class="menu-item {{ request()->routeIs('agent.notifications') ? 'active' : '' }}">
    <span class="menu-icon">🔔</span>
    <span>Notifications</span>
    <span class="badge">{{ \App\Models\UserNotification::where('user_id', session('user_id'))->where('is_read', false)->count() }}</span>
            </a>

            <a href="{{ route('agent.profile') }}" class="menu-item">
                <span class="menu-icon">👤</span>
                <span>Profil</span>
            </a>

            <a href="{{ route('agent.settings') }}" class="menu-item active">
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
            <div class="topbar-title">Paramètres agent</div>
            <div class="avatar">{{ strtoupper(substr($agent->username ?? 'A', 0, 1)) }}</div>
        </header>

        <section class="content">
            <div class="page-card">
                <div class="page-title">Paramètres du compte</div>
                <p class="page-text">
                    Gérez ici la sécurité de votre compte et modifiez votre mot de passe.
                </p>
            </div>

            <div class="page-card">
                <div class="section-title">Informations du compte</div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Adresse e-mail</div>
                        <div class="info-value">{{ $agent->email }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Type de compte</div>
                        <div class="info-value">Agent</div>
                    </div>
                </div>
            </div>

            <div class="password-card">
                @if (session('success'))
                    <div class="success-message">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="error-message">
                        <ul style="margin:0;padding-left:18px;">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="section-title">Changer le mot de passe</div>
                <p class="section-text">
                    Saisissez votre mot de passe actuel puis choisissez un nouveau mot de passe.
                </p>

                <form method="POST" action="{{ route('agent.settings.password.update') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="field full">
                            <label for="current_password">Mot de passe actuel</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>

                        <div class="field">
                            <label for="password">Nouveau mot de passe</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <div class="field">
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <button class="btn" type="submit">Changer le mot de passe</button>
                </form>
            </div>
        </section>
    </main>
</div>
</body>
</html>