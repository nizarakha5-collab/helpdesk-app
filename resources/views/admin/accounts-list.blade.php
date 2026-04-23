<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Accounts</title>
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
        }

        .sidebar-section-title {
            padding: 18px 22px 10px;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.65);
            text-transform: uppercase;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 0 10px 20px;
        }

        .menu-item,
        .menu-item:link,
        .menu-item:visited {
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
            background: transparent;
            transition: 0.2s ease;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }

        .menu-item.active {
            background: rgba(0, 0, 0, 0.22);
            color: #ffffff !important;
        }

        .menu-icon {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.05rem;
            flex-shrink: 0;
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

        .page-card,
        .list-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
        }

        .page-card {
            padding: 24px;
            margin-bottom: 22px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #23345d;
            margin-bottom: 8px;
        }

        .page-text {
            color: #6f7d99;
            line-height: 1.7;
        }

        .alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .alert-success {
            background: #e9f9ef;
            color: #1f7a3f;
            border: 1px solid #bfe7cb;
        }

        .alert-danger {
            background: #fff1f1;
            color: #b42318;
            border: 1px solid #f3c2c2;
        }

        .list-card {
            overflow: hidden;
        }

        .list-header {
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f8;
            font-size: 1rem;
            font-weight: 700;
            color: #2a3756;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #edf2f8;
            font-size: 0.94rem;
        }

        th {
            background: #f8fbff;
            color: #50607e;
            font-weight: 700;
        }

        .role-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .role-admin {
            background: #e8f1ff;
            color: #2456a6;
        }

        .role-agent {
            background: #fff5e8;
            color: #b26a00;
        }

        .role-user {
            background: #eef8f1;
            color: #1f7a3f;
        }

        .delete-btn {
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .delete-btn:hover {
            background: #c0392b;
        }

        @media (max-width: 900px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 18px;
            }
        }
         .menu-item,
.menu-item:link,
.menu-item:visited {
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
    background: transparent;
}

.menu-item:hover {
    background: rgba(255, 255, 255, 0.06);
    color: #ffffff;
}

.menu-item.active {
    background: rgba(0, 0, 0, 0.22);
    color: #ffffff !important;
}

.menu-icon {
    width: 22px;
    height: 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    flex-shrink: 0;
    color: #ffffff;
    filter: grayscale(100%) brightness(300%);
    opacity: 0.95;
}

.menu-item.active .menu-icon {
    filter: grayscale(100%) brightness(360%);
    opacity: 1;
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
            <a href="{{ route('admin.dashboard') }}"
               class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="menu-icon">◔</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.confirmations') }}"
               class="menu-item {{ request()->routeIs('admin.confirmations') ? 'active' : '' }}">
                <span class="menu-icon">☰</span>
                <span>Confirmations</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <span class="menu-icon">⌘</span>
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.users') }}"
               class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
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
            <a href="{{ route('admin.accounts') }}"
               class="menu-item {{ request()->routeIs('admin.accounts') ? 'active' : '' }}">
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
            <div class="topbar-title">Liste des Accounts</div>
            <div class="avatar">AD</div>
        </header>

        <section class="content">
            <div class="page-card">
                <h1 class="page-title">Liste des comptes</h1>
                <p class="page-text">
                    Cette page affiche tous les comptes du système : <strong>Admin</strong>, <strong>Agent</strong> et <strong>User</strong>.
                </p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="list-card">
                <div class="list-header">Tous les comptes</div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>{{ $account->username }}</td>
                                <td>{{ $account->email }}</td>
                                <td>
                                    @if($account->role === 'admin')
                                        <span class="role-badge role-admin">admin</span>
                                    @elseif($account->role === 'agent')
                                        <span class="role-badge role-agent">agent</span>
                                    @else
                                        <span class="role-badge role-user">user</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.accounts.delete', $account->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce compte ?');">
                                        @csrf
                                        <button type="submit" class="delete-btn">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Aucun compte trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
</body>
</html>