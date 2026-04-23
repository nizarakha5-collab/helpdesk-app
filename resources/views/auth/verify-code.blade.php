<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérifier le code</title>
    <link rel="stylesheet" href="{{ asset('auth.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Montserrat", sans-serif;
            background: #dfe4f2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .verify-wrapper {
            width: 100%;
            max-width: 760px;
        }

        .verify-card {
            width: 100%;
            min-height: 460px;
            background: #ffffff;
            border-radius: 28px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            box-shadow: 0 10px 26px rgba(0, 0, 0, 0.05);
        }

        .verify-left {
            padding: 34px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .verify-right {
            background: linear-gradient(135deg, #7b97f3, #6d8ceb);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 26px;
            border-top-left-radius: 70px;
            border-bottom-left-radius: 70px;
        }

        .verify-title {
            margin: 0 0 14px;
            font-size: 2.2rem;
            line-height: 1.05;
            font-weight: 800;
            color: #13224a;
        }

        .verify-text {
            margin: 0 0 14px;
            font-size: 0.95rem;
            line-height: 1.6;
            color: #23345d;
            max-width: 320px;
        }

        .verify-email {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #eef3ff;
            color: #23345d;
            font-size: 0.9rem;
            line-height: 1.5;
            word-break: break-word;
        }

        .verify-email strong {
            font-weight: 700;
        }

        .field {
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #13224a;
        }

        .field input {
            width: 100%;
            height: 50px;
            border: 1px solid #d6deef;
            border-radius: 12px;
            padding: 0 14px;
            font-size: 0.95rem;
            color: #23345d;
            background: #eef3ff;
            outline: none;
        }

        .field input:focus {
            border-color: #7b97f3;
            box-shadow: 0 0 0 3px rgba(123, 151, 243, 0.12);
        }

        .submit-btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #7b97f3, #6d8ceb);
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 2px;
        }

        .submit-btn:hover {
            opacity: 0.96;
        }

        .error-message {
            margin-bottom: 14px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 0.88rem;
            line-height: 1.5;
            background: #fff1f1;
            color: #b42318;
            border: 1px solid #f3c3c3;
        }

        .error-message ul {
            margin: 0;
            padding-left: 18px;
        }

        .verify-note {
            margin-top: 12px;
            font-size: 0.83rem;
            line-height: 1.55;
            color: #52617f;
        }

        .verify-right h2 {
            margin: 0 0 12px;
            font-size: 2rem;
            line-height: 1.1;
            font-weight: 800;
        }

        .verify-right p {
            margin: 0 auto;
            max-width: 230px;
            font-size: 0.92rem;
            line-height: 1.7;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            height: 46px;
            margin-top: 20px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            text-decoration: none;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .back-btn:hover {
            background: #ffffff;
            color: #6d8ceb;
        }

        @media (max-width: 800px) {
            .verify-wrapper {
                max-width: 430px;
            }

            .verify-card {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .verify-right {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                padding: 28px 20px;
            }

            .verify-left {
                padding: 28px 22px;
            }

            .verify-title {
                font-size: 1.9rem;
            }

            .verify-right h2 {
                font-size: 1.7rem;
            }
            .success-message {
    margin-bottom: 14px;
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 0.88rem;
    line-height: 1.5;
    background: #eaf8ee;
    color: #166534;
    border: 1px solid #bde7c9;
}
        }
    </style>
</head>
<body>
    <div class="verify-wrapper">
        <section class="verify-card">
            <div class="verify-left">
                <h1 class="verify-title">Vérifier le code</h1>

                <p class="verify-text">
                    Saisissez le code envoyé par e-mail pour confirmer votre compte.
                </p>
                @if (!empty($verified) && $verified)
                <div class="success-message">
                     Email vérifié , en attente de validation par l’administrateur.
                </div>
                @endif
                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="verify-email">
                    E-mail : <strong>{{ $email }}</strong>
                </div>

                <form method="POST" action="{{ route('verify.code.check') }}">
                    @csrf

                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="field">
                        <label for="code">Code de vérification</label>
                        <input
                            type="text"
                            id="code"
                            name="code"
                            maxlength="6"
                            value="{{ old('code') }}"
                            placeholder="Entrez le code à 6 chiffres"
                            required
                        >
                    </div>

                    <button type="submit" class="submit-btn">Vérifier le compte</button>
                </form>

                
            </div>

            <div class="verify-right">
                <div>
                    <h2>Presque fini !</h2>

                    <p>
                        Après cette étape, votre compte sera en attente de validation
                        par l’administrateur.
                    </p>

                    <a href="{{ url('/auth') }}" class="back-btn">Retour</a>
                </div>
            </div>
        </section>
    </div>
</body>
</html>