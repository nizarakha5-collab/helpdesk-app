<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Accounts</title>
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
        .form-card {
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
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
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

        .forms-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-card {
            padding: 22px;
        }

        .form-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #23345d;
            margin-bottom: 18px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #2a3756;
        }

        .form-control {
            width: 100%;
            height: 46px;
            border: 1px solid #d7dfec;
            border-radius: 12px;
            padding: 0 14px;
            font-size: 0.95rem;
            outline: none;
        }

        .btn {
            min-width: 150px;
            height: 46px;
            border: none;
            border-radius: 12px;
            background: #2f89d9;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
        }

        @media (max-width: 1100px) {
            .forms-grid {
                grid-template-columns: 1fr;
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
            <div class="topbar-title">Create Accounts</div>
            <div class="avatar">AD</div>
        </header>

        <section class="content">
            <div class="page-card">
                <h1 class="page-title">Créer des comptes</h1>
                <p class="page-text">
                    Depuis cette page, l’administrateur peut créer un compte <strong>Admin</strong> ou <strong>Agent du support</strong>.
                </p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-left: 18px;">
                        @foreach($errors->all() as $error)
                            <li style="margin-bottom: 6px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="forms-grid">
                <div class="form-card">
                    <div class="form-title">Create Admin Account</div>
                    <form action="{{ route('admin.users.storeAdmin') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn">Create Admin</button>
                    </form>
                </div>

                <div class="form-card">
                    <div class="form-title">Create Support Agent</div>
                    <form action="{{ route('admin.users.storeAgent') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn">Create Agent</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>