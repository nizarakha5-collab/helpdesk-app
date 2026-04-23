<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe | Helpdesk</title>

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
    </style>
</head>
<body>
    <main class="page">
        <section class="card">
            <h1 class="title">Nouveau mot de passe</h1>
            <p class="text">
                Entrez votre nouveau mot de passe pour le compte : <strong>{{ $email }}</strong>
            </p>

            @if ($errors->any())
                <div class="error-message">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.reset.update') }}">
                @csrf

                <div class="field">
                    <label for="password">Nouveau mot de passe</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Entrez le nouveau mot de passe"
                        required
                    >
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirmez le nouveau mot de passe"
                        required
                    >
                </div>

                <button type="submit" class="btn">Enregistrer le nouveau mot de passe</button>
            </form>
        </section>
    </main>
</body>
</html>