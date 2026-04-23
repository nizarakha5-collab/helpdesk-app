<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Confirmations</title>
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

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: #23345d;
            margin-bottom: 18px;
        }

        .success-message {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #eaf8ee;
            color: #166534;
            border: 1px solid #bde7c9;
            font-size: 0.94rem;
        }

        .table-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            overflow: hidden;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f8;
            gap: 12px;
        }

        .table-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2a3756;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        thead th {
            background: #ffffff;
            color: #7d8cab;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            text-align: left;
            padding: 16px 18px;
            border-bottom: 1px solid #edf2f8;
            white-space: nowrap;
        }

        tbody td {
            padding: 18px;
            border-bottom: 1px solid #f1f4f9;
            vertical-align: middle;
            font-size: 0.95rem;
            color: #2b3856;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #203a75, #d9a86f);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .user-name {
            font-weight: 700;
            color: #1f2a44;
        }

        .user-email {
            color: #8a97b3;
            font-size: 0.9rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 110px;
            height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: #fff7e6;
            color: #a26a00;
            font-size: 0.82rem;
            font-weight: 700;
            border: 1px solid #ffe0a6;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .actions form {
            margin: 0;
        }

        .btn {
            min-width: 102px;
            height: 38px;
            border-radius: 10px;
            border: none;
            font-size: 0.86rem;
            font-weight: 700;
            cursor: pointer;
            padding: 0 14px;
        }

        .btn-accept {
            background: #eaf8ee;
            color: #166534;
            border: 1px solid #bde7c9;
        }

        .btn-reject {
            background: #fff1f1;
            color: #b42318;
            border: 1px solid #f3c3c3;
        }

        .empty-state {
            padding: 28px 20px;
            color: #7b88a5;
            font-size: 0.95rem;
        }

        @media (max-width: 1100px) {
            .sidebar {
                width: 230px;
            }
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

            .topbar {
                padding: 0 18px;
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
                <div class="topbar-title">Admin Dashboard</div>

                <div class="topbar-right">
                    <div class="avatar">AD</div>
                </div>
            </header>

            <section class="content">
                <h1 class="page-title">Account Confirmations</h1>

                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-card">
                    <div class="table-header">
                        <div class="table-title">Pending Accounts</div>
                    </div>

                    @if ($pendingUsers->isEmpty())
                        <div class="empty-state">
                            Aucun compte en attente pour le moment.
                        </div>
                    @else
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pendingUsers as $user)
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <div class="user-avatar">
                                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                                    </div>

                                                    <div class="user-info">
                                                        <span class="user-name">{{ $user->username }}</span>
                                                        <span class="user-email">Pending validation</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $user->email }}</td>

                                            <td>
                                                <span class="status-badge">{{ $user->status }}</span>
                                            </td>

                                            <td>
                                                {{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '-' }}
                                            </td>

                                            <td>
                                                <div class="actions">
                                                    <form method="POST" action="{{ route('admin.accept', $user->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-accept">Accept</button>
                                                    </form>

                                                    <form method="POST" action="{{ route('admin.reject', $user->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-reject">Reject</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>
</body>
</html>