@php
    $dashboardUrl = Route::has('user.dashboard') ? route('user.dashboard') : '#';
    $createTicketUrl = Route::has('user.tickets.create') ? route('user.tickets.create') : '#';
    $myTicketsUrl = Route::has('user.tickets.index') ? route('user.tickets.index') : '#';
    $historyUrl = Route::has('user.tickets.history') ? route('user.tickets.history') : '#';
    $profileUrl = Route::has('user.profile') ? route('user.profile') : '#';
    $logoutUrl = Route::has('logout') ? route('logout') : '#';

    $displayName = $user->username ?? session('user_name', 'Utilisateur');
    $displayEmail = $user->email ?? session('user_email', '-');

    $birthDate = '-';
    if (!empty($user->date_naissance)) {
        try {
            $birthDate = \Carbon\Carbon::parse($user->date_naissance)->format('Y-m-d');
        } catch (\Throwable $e) {
            $birthDate = $user->date_naissance;
        }
    }
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord utilisateur</title>

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
            padding: 0 10px 18px;
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
            position: relative;
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
            position: relative;
        }

        .top-btn {
            height: 46px;
            padding: 0 20px;
            border: 1px solid #d7dfec;
            background: #ffffff;
            border-radius: 12px;
            color: #344563;
            font-size: 0.94rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .top-btn.primary {
            background: #2f89d9;
            border-color: #2f89d9;
            color: #ffffff;
        }

        .avatar-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 0;
            padding: 0;
            cursor: pointer;
            overflow: hidden;
            background: transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-fallback {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #233a70, #f0b16d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .avatar-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            display: block;
        }

        .profile-dropdown {
            position: absolute;
            top: 58px;
            right: 0;
            width: 320px;
            background: #ffffff;
            border: 1px solid #e6ebf3;
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(31, 42, 68, 0.12);
            padding: 16px;
            display: none;
            z-index: 50;
        }

        .profile-dropdown.open {
            display: block;
        }

        .pd-head {
            display: flex;
            gap: 12px;
            align-items: center;
            padding-bottom: 12px;
            border-bottom: 1px solid #edf2f8;
            margin-bottom: 12px;
        }

        .pd-photo {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #edf2f8;
            background: #f8fbff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pd-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .pd-name {
            font-weight: 800;
            color: #23345d;
            font-size: 1rem;
            line-height: 1.2;
        }

        .pd-email {
            color: #7b88a5;
            font-size: .9rem;
            margin-top: 2px;
        }

        .pd-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .pd-item {
            background: #f8fbff;
            border: 1px solid #e4ebf7;
            border-radius: 14px;
            padding: 10px 12px;
            min-height: 54px;
        }

        .pd-label {
            font-size: .78rem;
            color: #7b88a5;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .pd-value {
            font-size: .93rem;
            color: #23345d;
            font-weight: 700;
            word-break: break-word;
        }

        .pd-actions {
            margin-top: 12px;
            display: flex;
            gap: 10px;
        }

        .pd-link {
            flex: 1;
            height: 40px;
            border-radius: 12px;
            border: 1px solid #d7dfec;
            background: #ffffff;
            color: #344563;
            font-weight: 800;
            font-size: .9rem;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pd-link.primary {
            background: #2f89d9;
            border-color: #2f89d9;
            color: #fff;
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
            .profile-dropdown { right: 0; width: 92vw; max-width: 360px; }
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

        <div class="sidebar-section-title">Général</div>
        <nav class="menu">
            <a href="{{ $dashboardUrl }}" class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <span class="menu-icon">◔</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ $createTicketUrl }}" class="menu-item {{ request()->routeIs('user.tickets.create') ? 'active' : '' }}">
                <span class="menu-icon">＋</span>
                <span>Créer un ticket</span>
            </a>

            <a href="{{ $myTicketsUrl }}" class="menu-item {{ request()->routeIs('user.tickets.index') ? 'active' : '' }}">
                <span class="menu-icon">☰</span>
                <span>Mes tickets</span>
            </a>

            <a href="{{ $historyUrl }}" class="menu-item {{ request()->routeIs('user.tickets.history') ? 'active' : '' }}">
                <span class="menu-icon">🕘</span>
                <span>Historique</span>
            </a>
        </nav>

        <div class="sidebar-section-title">Compte</div>
        <nav class="menu">
            <a href="#" class="menu-item">
                <span class="menu-icon">🔔</span>
                <span>Notifications</span>
                <span class="badge">0</span>
            </a>

            <a href="{{ $profileUrl }}" class="menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                <span class="menu-icon">👤</span>
                <span>Profil</span>
            </a>

            <a href="#" class="menu-item">
                <span class="menu-icon">⚙</span>
                <span>Paramètres</span>
            </a>

            <a href="{{ $logoutUrl }}" class="menu-item">
                <span class="menu-icon">⇦</span>
                <span>Déconnexion</span>
            </a>
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-title">Tableau de bord utilisateur</div>

            <div class="topbar-right">
                <a href="{{ $createTicketUrl }}" class="top-btn primary">Créer un ticket</a>

                <div style="position:relative;">
                    <button class="avatar-btn" id="avatarBtn" type="button" aria-label="Open profile">
                        @if (!empty($user->avatar_path))
                            <img class="avatar-img" src="{{ asset('storage/' . $user->avatar_path) }}" alt="Avatar">
                        @else
                            <div class="avatar-fallback">
                                {{ strtoupper(substr($displayName, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="pd-head">
                            <div class="pd-photo">
                                @if (!empty($user->avatar_path))
                                    <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="Avatar">
                                @else
                                    <span style="font-weight:900;color:#23345d;">
                                        {{ strtoupper(substr($displayName, 0, 1)) }}
                                    </span>
                                @endif
                            </div>

                            <div>
                                <div class="pd-name">{{ $displayName }}</div>
                                <div class="pd-email">{{ $displayEmail }}</div>
                            </div>
                        </div>

                        <div class="pd-grid">
                            <div class="pd-item">
                                <div class="pd-label">Téléphone</div>
                                <div class="pd-value">{{ $user->phone ?? '-' }}</div>
                            </div>

                            <div class="pd-item">
                                <div class="pd-label">Type</div>
                                <div class="pd-value">{{ $user->type ?? '-' }}</div>
                            </div>

                            <div class="pd-item">
                                <div class="pd-label">CIN</div>
                                <div class="pd-value">{{ $user->cin ?? '-' }}</div>
                            </div>

                            <div class="pd-item">
                                <div class="pd-label">CNE</div>
                                <div class="pd-value">{{ $user->cne ?? '-' }}</div>
                            </div>

                            <div class="pd-item">
                                <div class="pd-label">Date de naissance</div>
                                <div class="pd-value">{{ $birthDate }}</div>
                            </div>

                            <div class="pd-item">
                                <div class="pd-label">
                                    @if (($user->type ?? null) === 'prof')
                                        Département
                                    @elseif (($user->type ?? null) === 'etudiant')
                                        Filière / Année
                                    @else
                                        Info
                                    @endif
                                </div>

                                <div class="pd-value">
                                    @if (($user->type ?? null) === 'prof')
                                        {{ $user->departement ?? '-' }}
                                    @elseif (($user->type ?? null) === 'etudiant')
                                        {{ ($user->filiere ?? '-') . ' / ' . ($user->annee ?? '-') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="pd-actions">
                            <a class="pd-link primary" href="{{ $profileUrl }}">Voir profil</a>
                            <a class="pd-link" href="{{ $logoutUrl }}">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="content">
            <div class="welcome-card">
                <h1 class="welcome-title">Bienvenue, {{ $displayName }}</h1>
                <p class="welcome-text" style="margin-top: 10px;">
                    <strong>E-mail :</strong> {{ $displayEmail }}
                </p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Tickets ouverts</div>
                    <div class="stat-value">{{ $openTickets ?? 0 }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Tickets en attente</div>
                    <div class="stat-value">{{ $pendingTickets ?? 0 }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Tickets résolus</div>
                    <div class="stat-value">{{ $resolvedTickets ?? 0 }}</div>
                </div>
            </div>

            <div class="quick-card">
                <div class="quick-header">
                    <div class="quick-title">Accès rapide</div>
                </div>

                <div class="quick-links">
                    <a href="{{ $createTicketUrl }}" class="quick-link">
                        <div class="quick-link-title">Créer un ticket</div>
                        <div class="quick-link-text">Créer une nouvelle demande d’assistance.</div>
                    </a>

                    <a href="{{ $myTicketsUrl }}" class="quick-link">
                        <div class="quick-link-title">Mes tickets</div>
                        <div class="quick-link-text">Consulter la liste de vos tickets.</div>
                    </a>

                    <a href="{{ $historyUrl }}" class="quick-link">
                        <div class="quick-link-title">Historique</div>
                        <div class="quick-link-text">Voir les tickets résolus et archivés.</div>
                    </a>

                    <a href="#" class="quick-link">
                        <div class="quick-link-title">Notifications</div>
                        <div class="quick-link-text">Voir les réponses et mises à jour récentes.</div>
                    </a>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    const avatarBtn = document.getElementById('avatarBtn');
    const dropdown = document.getElementById('profileDropdown');

    function closeDropdown() {
        dropdown?.classList.remove('open');
    }

    avatarBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown?.classList.toggle('open');
    });

    document.addEventListener('click', () => {
        closeDropdown();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDropdown();
        }
    });

    dropdown?.addEventListener('click', (e) => {
        e.stopPropagation();
    });
</script>
</body>
</html>