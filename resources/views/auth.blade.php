@php
    $submittedAction = old('auth_action');
    $showLoginErrors = $errors->has('login') || $submittedAction === 'login';
    $showRegisterErrors = $submittedAction === 'register';
    $initialMode = $showRegisterErrors ? 'register' : 'login';

    $schoolLogoExists = file_exists(public_path('images/logo-ecole.png'));
    $universityLogoExists = file_exists(public_path('images/logo-universite.png'));
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Authentification | Helpdesk</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('auth.css') }}">
    <script src="{{ asset('auth.js') }}" defer></script>
</head>
<body>
    <main class="auth-page">
        <section class="auth-shell">
            <div class="brand-header">
                <div class="brand-logos">
                    <div class="brand-logo-box">
                        @if ($schoolLogoExists)
                            <img src="{{ asset('images/logo-ecole.png') }}" alt="Logo de l'école" class="brand-logo">
                        @else
                            <span class="brand-logo-placeholder">Logo école</span>
                        @endif
                    </div>

                    <div class="brand-logo-box">
                        @if ($universityLogoExists)
                            <img src="{{ asset('images/logo-universite.png') }}" alt="Logo de l'université" class="brand-logo">
                        @else
                            <span class="brand-logo-placeholder">Logo université</span>
                        @endif
                    </div>
                </div>

                
            </div>

            <section class="auth-card {{ $initialMode }}-mode" id="authCard" data-initial-mode="{{ $initialMode }}">
                <div class="state-panel">
                    <!-- visible en login-mode -->
                    <div class="state-content state-login">
                        <h2>Bienvenue !</h2>
                        <p>Vous n'avez pas encore de compte ?</p>
                        <button type="button" class="panel-btn" data-mode="register">Inscription</button>
                    </div>

                    <!-- visible en register-mode -->
                    <div class="state-content state-register">
                        <h2>Bon retour !</h2>
                        <p>Vous avez déjà un compte ?</p>
                        <button type="button" class="panel-btn" data-mode="login">Connexion</button>
                    </div>
                </div>

                <div class="form-panel">
                    <section class="form-view form-login">
                        <h1 class="form-title">Connexion</h1>

                        @if ($showLoginErrors && $errors->any())
                            <div class="error-message">
                                @if ($errors->has('login'))
                                    {{ $errors->first('login') }}
                                @else
                                    <ul style="margin: 0; padding-left: 18px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif

                        <form id="loginForm" method="POST" action="{{ route('login.store') }}" novalidate>
                            @csrf
                            <input type="hidden" name="auth_action" value="login">

                            <div class="field">
                                <label for="loginEmail">Adresse e-mail</label>
                                <input
                                    type="email"
                                    id="loginEmail"
                                    name="email"
                                    value="{{ old('auth_action') === 'login' ? old('email') : '' }}"
                                    placeholder="Entrez votre adresse e-mail"
                                    required
                                >
                            </div>

                            <div class="field">
                                <div class="label-row">
                                    <label for="loginPassword">Mot de passe</label>
                                    <a href="{{ route('password.forgot.form') }}" class="forgot-link">Mot de passe oublié ?</a>
                                </div>
                                <input
                                    type="password"
                                    id="loginPassword"
                                    name="password"
                                    placeholder="Entrez votre mot de passe"
                                    required
                                >
                            </div>

                            <button type="submit" class="submit-btn">Se connecter</button>
                        </form>

                        <div class="divider">
                            <span>OU</span>
                        </div>

                        <a href="{{ route('google.redirect') }}" class="google-btn">
                            <span class="google-icon">G</span>
                            <span>Continuer avec Google</span>
                        </a>
                    </section>

                    <section class="form-view form-register">
                        <h1 class="form-title">Inscription</h1>

                        @if ($showRegisterErrors && $errors->any())
                            <div class="error-message">
                                <ul style="margin: 0; padding-left: 18px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="success-message">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form id="registerForm" method="POST" action="{{ route('register.store') }}" novalidate>
                            @csrf
                            <input type="hidden" name="auth_action" value="register">

                            <div class="field">
                                <label for="registerName">Nom complet</label>
                                <input
                                    type="text"
                                    id="registerName"
                                    name="username"
                                    value="{{ old('auth_action') === 'register' ? old('username') : '' }}"
                                    placeholder="Entrez votre nom complet"
                                    required
                                >
                            </div>

                            <div class="field">
                                <label for="registerEmail">Adresse e-mail</label>
                                <input
                                    type="email"
                                    id="registerEmail"
                                    name="email"
                                    value="{{ old('auth_action') === 'register' ? old('email') : '' }}"
                                    placeholder="Entrez votre adresse e-mail"
                                    required
                                >
                            </div>

                            <div class="field">
                                <label for="registerPassword">Mot de passe</label>
                                <input
                                    type="password"
                                    id="registerPassword"
                                    name="password"
                                    placeholder="Créez votre mot de passe"
                                    required
                                >
                            </div>

                            <button type="submit" class="submit-btn">Créer un compte</button>
                        </form>

                        <div class="divider">
                            <span>OU</span>
                        </div>

                        <a href="{{ route('google.redirect') }}" class="google-btn">
                            <span class="google-icon">G</span>
                            <span>Continuer avec Google</span>
                        </a>
                    </section>
                </div>
            </section>
        </section>
    </main>
</body>
</html>