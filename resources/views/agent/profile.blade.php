<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil agent</title>

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

        .card{
            background:#fff;border-radius:18px;border:1px solid #e8edf5;
            box-shadow:0 8px 26px rgba(31,42,68,.04);padding:22px
        }

        .title{
            font-size:2rem;font-weight:800;color:#23345d;margin-bottom:16px
        }

        .success-message{
            margin-bottom:16px;padding:12px 14px;border-radius:12px;
            background:#eaf8ee;color:#166534;border:1px solid #bde7c9;font-size:.94rem
        }

        .error-message{
            margin-bottom:16px;padding:12px 14px;border-radius:12px;
            background:#fff1f1;color:#b42318;border:1px solid #f3c3c3;font-size:.94rem
        }

        .grid{
            display:grid;grid-template-columns:1fr 1fr;gap:16px
        }

        .field{
            display:flex;flex-direction:column;gap:6px;margin-bottom:14px
        }

        .field label{
            font-weight:800;color:#23345d;font-size:.92rem
        }

        .field input{
            height:44px;border:1px solid #d7dfec;border-radius:12px;
            padding:0 12px;font-size:.95rem;outline:none;background:#fff
        }

        .field input[type="file"]{
            height:auto;
            padding:10px;
        }

        .row{
            display:flex;
            gap:16px;
            align-items:flex-start;
            margin-bottom:18px;
        }

        .avatar-box{
            width:120px;
            height:120px;
            border-radius:16px;
            border:1px dashed #d7dfec;
            background:#f8fbff;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            flex-shrink:0;
        }

        .avatar-box img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .avatar-empty{
            color:#7b88a5;
            font-size:.92rem;
            text-align:center;
            line-height:1.4;
            padding:10px;
        }

        .hint{
            color:#7b88a5;
            font-size:.88rem;
            line-height:1.6;
        }

        .btn{
            height:46px;border-radius:12px;border:none;padding:0 18px;font-weight:800;
            cursor:pointer;background:#2f89d9;color:#fff
        }

        @media(max-width:1000px){
            .grid{grid-template-columns:1fr}
            .row{flex-direction:column}
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

            <a href="{{ route('agent.profile') }}" class="menu-item active">
                <span class="menu-icon">👤</span>
                <span>Profil</span>
            </a>

            <a href="{{ route('agent.settings') }}" class="menu-item {{ request()->routeIs('agent.settings') ? 'active' : '' }}">
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
            <div class="topbar-title">Profil agent</div>
            <div class="avatar">{{ strtoupper(substr($agent->username ?? 'A', 0, 1)) }}</div>
        </header>

        <section class="content">
            <div class="card">
                <div class="title">Mon profil</div>

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

                <form method="POST" action="{{ route('agent.profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="avatar-box">
                            @if ($agent->avatar_path)
                                <img src="{{ asset('storage/' . $agent->avatar_path) }}" alt="Avatar">
                            @else
                                <div class="avatar-empty">No photo</div>
                            @endif
                        </div>

                        <div style="flex:1;">
                            <div class="field">
                                <label>Photo / Avatar</label>
                                <input type="file" name="avatar" accept="image/*">
                                <div class="hint">Formats acceptés : jpg, jpeg, png, webp. Taille max : 2 Mo.</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="field">
                            <label>Nom complet</label>
                            <input type="text" name="username" value="{{ old('username', $agent->username) }}" required>
                        </div>

                        <div class="field">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $agent->email) }}" required>
                        </div>

                        <div class="field">
                            <label>Téléphone</label>
                            <input type="text" name="phone" value="{{ old('phone', $agent->phone) }}" placeholder="06...">
                        </div>

                        <div class="field">
                            <label>Spécialité</label>
                            <input type="text" name="speciality" value="{{ old('speciality', $agent->speciality) }}" placeholder="Réseau, matériel, logiciels...">
                        </div>

                        <div class="field">
                            <label>CIN</label>
                            <input type="text" name="cin" value="{{ old('cin', $agent->cin) }}">
                        </div>

                        <div class="field">
                            <label>CNE</label>
                            <input type="text" name="cne" value="{{ old('cne', $agent->cne) }}">
                        </div>

                        <div class="field">
                            <label>Date de naissance</label>
                            <input type="date" name="date_naissance" value="{{ old('date_naissance', $agent->date_naissance?->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div style="margin-top:18px;">
                        <button class="btn" type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>
</body>
</html>