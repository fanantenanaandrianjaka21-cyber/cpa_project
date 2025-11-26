<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Code de vérification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .code {
            font-size: 28px;
            font-weight: bold;
            color: #2d3748;
            background-color: #e2e8f0;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
            margin: 10px 0;
        }
        .footer {
            font-size: 12px;
            color: #718096;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Bonjour {{ $nom_utilisateur }},</h2>

        <p>Voici votre code de vérification :</p>

        <div class="code">{{ $code }}</div>

        <p>Ce code expire dans <strong>15 minutes</strong>.</p>

        <p>Veuillez ne pas partager ce code avec qui que ce soit.</p>

        <div class="footer">
            Merci,<br>
            L’équipe de GPTic CPA
        </div>
    </div>
</body>
</html>
