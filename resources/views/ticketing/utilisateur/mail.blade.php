<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <p>Bonjour,</p>
        <p>Nous vous confirmons que votre demande d'assistance a été enregistrée avec succès.</p>

            <p>Numéro de votre ticket : {{ $ticket->id }}</p>

            <p>Sujet de la demande : {{ $ticket->objet }}</p>

            <p>Priorité estimée : {{ $ticket->priorite }}</p>

        <p>Votre ticket a été transmis à notre équipe d'assistance technique. Nous vous tiendrons informé de son avancement et de toute mise à jour.</p>

        <p>Nous vous remercions de votre patience.</p>

        <p>Cordialement,</p>

        <p>L'équipe Support</p>
    </div>
</body>
</html>