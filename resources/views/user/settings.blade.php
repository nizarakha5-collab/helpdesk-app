@extends('user.layouts.tickets')

@section('title', 'Paramètres')
@section('topbar_title', 'Paramètres du compte')
@section('top_button_text', 'Tableau de bord')
@section('top_button_link', route('user.dashboard'))

@section('content')
    <style>
        .settings-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
            padding: 22px;
            margin-bottom: 22px;
        }

        .settings-title {
            font-size: 2rem;
            font-weight: 800;
            color: #23345d;
            margin-bottom: 12px;
        }

        .settings-text {
            font-size: 0.96rem;
            color: #6f7d99;
            line-height: 1.7;
        }

        .settings-success-message {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #eaf8ee;
            color: #166534;
            border: 1px solid #bde7c9;
            font-size: .94rem;
        }

        .settings-error-message {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #fff1f1;
            color: #b42318;
            border: 1px solid #f3c3c3;
            font-size: .94rem;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .settings-item {
            background: #f8fbff;
            border: 1px solid #e4ebf7;
            border-radius: 14px;
            padding: 14px 16px;
        }

        .settings-label {
            font-size: .82rem;
            color: #7b88a5;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .settings-value {
            font-size: .95rem;
            color: #23345d;
            font-weight: 700;
            word-break: break-word;
        }

        .password-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
            padding: 22px;
        }

        .password-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #23345d;
            margin-bottom: 10px;
        }

        .password-text {
            font-size: .95rem;
            color: #6f7d99;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .password-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .password-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 14px;
        }

        .password-field.full {
            grid-column: 1 / -1;
        }

        .password-field label {
            font-weight: 800;
            color: #23345d;
            font-size: .92rem;
        }

        .password-field input {
            height: 44px;
            border: 1px solid #d7dfec;
            border-radius: 12px;
            padding: 0 12px;
            font-size: .95rem;
            outline: none;
            background: #fff;
        }

        .password-btn {
            height: 46px;
            border-radius: 12px;
            border: none;
            padding: 0 18px;
            font-weight: 800;
            cursor: pointer;
            background: #2f89d9;
            color: #fff;
        }

        .password-note {
            background: #eef5ff;
            border: 1px solid #d6e4ff;
            color: #2a4c88;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 18px;
            line-height: 1.7;
            font-size: .94rem;
        }

        @media(max-width:1000px) {
            .settings-grid,
            .password-grid {
                grid-template-columns: 1fr;
            }

            .password-field.full {
                grid-column: auto;
            }
        }
    </style>

    <div class="settings-card">
        <div class="settings-title">Paramètres du compte</div>
        <p class="settings-text">
            Gérez ici la sécurité de votre compte et votre mot de passe.
        </p>
    </div>

    <div class="settings-card">
        <div class="settings-title" style="font-size:1.3rem;">Informations du compte</div>

        <div class="settings-grid">
            <div class="settings-item">
                <div class="settings-label">Adresse e-mail</div>
                <div class="settings-value">{{ $user->email }}</div>
            </div>

            <div class="settings-item">
                <div class="settings-label">Mode de connexion</div>
                <div class="settings-value">
                    @if ($user->auth_provider === 'google')
                        Google
                    @else
                        Compte local
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="password-card">
        @if (session('success'))
            <div class="settings-success-message">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="settings-error-message">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($mustCreatePassword)
            <div class="password-title">Créer un mot de passe</div>

            <div class="password-note">
                Vous vous connectez actuellement avec Google.  
                Créez un mot de passe pour pouvoir aussi vous connecter avec votre e-mail et votre mot de passe.
            </div>

            <form method="POST" action="{{ route('user.settings.password.update') }}">
                @csrf

                <div class="password-grid">
                    <div class="password-field">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="password-field">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="password-btn">Créer un mot de passe</button>
            </form>
        @else
            <div class="password-title">Changer le mot de passe</div>
            <p class="password-text">
                Modifiez votre mot de passe pour sécuriser davantage votre compte.
            </p>

            <form method="POST" action="{{ route('user.settings.password.update') }}">
                @csrf

                <div class="password-grid">
                    <div class="password-field full">
                        <label for="current_password">Mot de passe actuel</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>

                    <div class="password-field">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="password-field">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="password-btn">Changer le mot de passe</button>
            </form>
        @endif
    </div>
@endsection