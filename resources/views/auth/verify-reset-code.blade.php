<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérifier le code | Helpdesk</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "Poppins", sans-serif;
            background: #dfe4f4;
            color: #202533;
        }
        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            width: 100%;
            max-width: 520px;
            background: #fbfbfb;
            border-radius: 24px;
            box-shadow: 0 16px 32px rgba(33, 44, 84, 0.08);
            padding: 32px;
        }
        .title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        .text {
            font-size: 0.98rem;
            color: #6f7d99;
            line-height: 1.7;
            margin-bottom: 22px;
        }
        .success-message {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 0.95rem;
            line-height: 1.5;
            background: #eaf8ee;
            color: #166534;
            border: 1px solid #bde7c9;
        }
        .error-message {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 0.95rem;
            line-height: 1.5;
            background: #fff1f1;
            color: #b42318;
            border: 1px solid #f3c3c3;
        }
        .field { margin-bottom: 16px; }
        .field label {
            display: block;
            font-size: 0.92rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .field input {
            width: 100%;
            height: 48px;
            border: 1px solid #d8deea;
            border-radius: 12px;
            background: #edf2fb;
            padding: 0 14px;
            font-size: 0.95rem;
            outline: none;
        }
        .field input:focus {
            border-color: #93abef;
            box-shadow: 0 0 0 3px rgba(111, 146, 238, 0.1);
        }
        .btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(180deg, #7397f0 0%, #688ce8 100%);
            color: white;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: pointer;
        }
        .back-link {
            display: inline-block;
            margin-top: 16px;
            color: #6f92ee;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="card">
            <h1 class="title">Vérifier le code</h1>
            <p class="text">
                Entrez le code reçu sur votre adresse e-mail.
            </p>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.code.verify') }}">
                @csrf

                <div class="field">
                    <label for="email">Adresse e-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $email) }}"
                        readonly
                    >
                </div>

                <div class="field">
                    <label for="code">Code</label>
                    <input
                        type="text"
                        id="code"
                        name="code"
                        value="{{ old('code') }}"
                        placeholder="Entrez le code à 6 chiffres"
                        required
                    >
                </div>

                <button type="submit" class="btn">Vérifier le code</button>
            </form>

            <a href="{{ route('password.forgot.form') }}" class="back-link">Retour</a>
        </section>
    </main>
</body>
</html>