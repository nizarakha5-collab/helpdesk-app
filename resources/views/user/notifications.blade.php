@extends('user.layouts.tickets')

@section('title', 'Notifications')
@section('topbar_title', 'Notifications')
@section('top_button_text', 'Tableau de bord')
@section('top_button_link', route('user.dashboard'))

@section('content')
    <style>
        .notifications-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
            padding: 22px;
            margin-bottom: 22px;
        }

        .notifications-title {
            font-size: 2rem;
            font-weight: 800;
            color: #23345d;
            margin-bottom: 10px;
        }

        .notifications-text {
            font-size: .96rem;
            color: #6f7d99;
            line-height: 1.7;
        }

        .notifications-success {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #eaf8ee;
            color: #166534;
            border: 1px solid #bde7c9;
            font-size: .94rem;
        }

        .notifications-list {
            display: grid;
            gap: 16px;
        }

        .notification-item {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
            padding: 20px;
        }

        .notification-item.unread {
            border-left: 5px solid #2f89d9;
            background: #fbfdff;
        }

        .notification-head {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .notification-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #23345d;
            margin-bottom: 4px;
        }

        .notification-meta {
            font-size: .85rem;
            color: #7b88a5;
            font-weight: 600;
        }

        .notification-message {
            font-size: .95rem;
            color: #42526e;
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .notification-btn,
        .notification-link {
            height: 40px;
            border-radius: 12px;
            padding: 0 16px;
            font-size: .9rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
        }

        .notification-btn {
            border: none;
            background: #2f89d9;
            color: #fff;
        }

        .notification-link {
            border: 1px solid #d7dfec;
            background: #fff;
            color: #344563;
        }

        .notification-badge {
            min-width: 92px;
            height: 34px;
            border-radius: 999px;
            padding: 0 12px;
            font-size: .82rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .notification-badge.unread {
            background: #e8f2ff;
            color: #2563eb;
        }

        .notification-badge.read {
            background: #eef2f7;
            color: #475569;
        }

        .notifications-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .notifications-empty {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
            padding: 26px;
            color: #7b88a5;
            font-size: .96rem;
        }

        @media(max-width:900px) {
            .notification-head {
                flex-direction: column;
            }
        }
    </style>

    <div class="notifications-card">
        <div class="notifications-title">Notifications</div>
        <p class="notifications-text">
            Consultez ici toutes les mises à jour liées à vos tickets.
        </p>
    </div>

    @if (session('success'))
        <div class="notifications-success">{{ session('success') }}</div>
    @endif

    <div class="notifications-toolbar">
        <div class="notifications-text">
            Notifications non lues : <strong>{{ $unreadCount }}</strong>
        </div>

        @if ($unreadCount > 0)
            <form method="POST" action="{{ route('user.notifications.readAll') }}">
                @csrf
                <button type="submit" class="notification-btn">Tout marquer comme lu</button>
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
                            <form method="POST" action="{{ route('user.notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="notification-btn">Marquer comme lu</button>
                            </form>
                        @endif

                        @if ($notification->ticket_id && Route::has('user.tickets.show'))
                            <a href="{{ route('user.tickets.show', $notification->ticket_id) }}" class="notification-link">
                                Voir le ticket
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
        <div class="notifications-empty">
            Aucune notification pour le moment.
        </div>
    @endif
@endsection