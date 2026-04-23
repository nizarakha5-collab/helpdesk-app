<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Montserrat", Arial, sans-serif;
        }

        body {
            background: #f4f7fb;
            color: #1f2a44;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1b2434 0%, #243247 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
        }

        .sidebar-header {
            height: 78px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logo-box {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, #4a90e2, #7b97f3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
        }

        .brand {
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: 0.4px;
        }

        .sidebar-section-title {
            padding: 18px 22px 10px;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.65);
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 0 10px 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 50px;
            padding: 0 14px;
            border-radius: 12px;
            text-decoration: none;
            color: #dce6f8;
            font-size: 0.98rem;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .menu-item.active {
            background: rgba(0, 0, 0, 0.22);
            color: #ffffff;
        }

        .menu-icon {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            filter: grayscale(100%) brightness(300%);
            opacity: 0.95;
            flex-shrink: 0;
        }

        .menu-item.active .menu-icon {
            opacity: 1;
            filter: grayscale(100%) brightness(360%);
        }

        .badge {
            margin-left: auto;
            min-width: 28px;
            height: 22px;
            border-radius: 999px;
            background: rgba(255,255,255,0.14);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 800;
            padding: 0 8px;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            height: 78px;
            background: #ffffff;
            border-bottom: 1px solid #e6ebf3;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 26px;
        }

        .topbar-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2a3756;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .top-btn {
            height: 42px;
            padding: 0 18px;
            border: 1px solid #d7dfec;
            background: #ffffff;
            border-radius: 10px;
            color: #344563;
            font-size: 0.94rem;
            font-weight: 600;
            cursor: pointer;
        }

        .top-btn.primary {
            background: #2f89d9;
            border-color: #2f89d9;
            color: #ffffff;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #233a70, #f0b16d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .content {
            padding: 28px 24px;
        }

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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            padding: 22px;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
        }

        .stat-label {
            font-size: 0.9rem;
            color: #7b88a5;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #23345d;
        }

        .quick-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            overflow: hidden;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
        }

        .quick-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f8;
        }

        .quick-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2a3756;
        }

        .quick-links {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            padding: 20px;
        }

        .quick-link {
            display: block;
            text-decoration: none;
            background: #f8fbff;
            border: 1px solid #e4ebf7;
            border-radius: 16px;
            padding: 18px;
            transition: 0.2s ease;
        }

        .quick-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(47, 137, 217, 0.08);
        }

        .quick-link-title {
            font-size: 1rem;
            font-weight: 700;
            color: #23345d;
            margin-bottom: 8px;
        }

        .quick-link-text {
            font-size: 0.9rem;
            color: #7b88a5;
            line-height: 1.6;
        }

        @media (max-width: 1100px) {
            .sidebar { width: 230px; }
            .stats-grid { grid-template-columns: 1fr; }
            .quick-links { grid-template-columns: 1fr; }
        }

        @media (max-width: 900px) {
            .dashboard { flex-direction: column; }
            .sidebar { width: 100%; }
            .content { padding: 18px; }
            .topbar { padding: 0 18px; }
        }
    </style>
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">L</div>
            <div class="brand">HELPDESK</div>
        </div>

        <div class="sidebar-section-title">General</div>
        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item active">
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

           @php
    $agentChatUnreadCount = \App\Models\AdminAgentMessage::where('receiver_id', session('user_id'))
        ->where('is_read', false)
        ->whereHas('sender', function ($query) {
            $query->where('role', 'agent');
        })
        ->count();
@endphp

<a href="{{ route('admin.chat.index') }}" class="menu-item {{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">
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
            <div class="topbar-title">Admin Dashboard</div>

            <div class="topbar-right">
                
       
                <div class="avatar">AD</div>
            </div>
        </header>

        <section class="content">
            <div class="welcome-card">
                <h1 class="welcome-title">Bienvenue, Admin</h1>
               
                <p class="welcome-text" style="margin-top:10px;">
                    <strong>Rôle :</strong> Administrateur
                </p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Pending Confirmations</div>
                    <div class="stat-value">{{ $pendingCount }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Active Users</div>
                    <div class="stat-value">{{ $activeCount }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Rejected Accounts</div>
                    <div class="stat-value">{{ $rejectedCount }}</div>
                </div>
            </div>

            <div class="quick-card">
                <div class="quick-header">
                    <div class="quick-title">Quick Access</div>
                </div>

                <div class="quick-links">
                    <a href="{{ route('admin.confirmations') }}" class="quick-link">
                        <div class="quick-link-title">Account Confirmations</div>
                        <div class="quick-link-text">Valider ou refuser les nouveaux comptes.</div>
                    </a>

                    <a href="{{ route('admin.users') }}" class="quick-link">
                        <div class="quick-link-title">Create Accounts</div>
                        <div class="quick-link-text">Créer des comptes Admin et Support Agent.</div>
                    </a>

                    <a href="#" class="quick-link">
                        <div class="quick-link-title">Categories</div>
                        <div class="quick-link-text">Créer et organiser les catégories des tickets.</div>
                    </a>

                    <a href="#" class="quick-link">
                        <div class="quick-link-title">Notifications</div>
                        <div class="quick-link-text">Voir les dernières alertes et mises à jour.</div>
                    </a>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>