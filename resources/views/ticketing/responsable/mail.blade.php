<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Bonjour ,</p>

<p>Un nouveau ticket d'assistance a été déposé dans le système et nécessite une action.</p>

<p>Synthèse des Informations :</p>

    <p>Numéro du Ticket : {{ $ticket->id }}</p>

    <p>Priorité : {{ $ticket->priorite }}</p>

    <p>Demandeur : {{ $demandeur->nom_utilisateur }}</p>

    <p>Sujet : {{ $ticket->objet }}</p>

<p>Ce ticket est en attente d'une évaluation et d'une assignation. Merci de le prendre en charge dès que possible.</p>

<a href="{{ route('ticketAassigner.ticket', $ticket->id) }}" class="btn"></a>

<p>Cordialement,</p>

<p>Le Système de Notification</p>


</body>
</html>