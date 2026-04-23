<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe réinitialisé | Helpdesk</title>

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
            text-align: center;
        }
        .title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 12px;
        }
        .text {
            font-size: 1rem;
            color: #6f7d99;
            line-height: 1.8;
            margin-bottom: 24px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(180deg, #7397f0 0%, #688ce8 100%);
            color: white;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="card">
            <h1 class="title">Mot de passe mis à jour</h1>
            <p class="text">
                Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.
            </p>

            <a href="{{ route('auth') }}" class="btn">Retour à la connexion</a>
        </section>
    </main>
</body>
</html>