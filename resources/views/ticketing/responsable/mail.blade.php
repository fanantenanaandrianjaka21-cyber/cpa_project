<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Une nouvelle ticket vient d'etre créer</p>
    <a href="{{ route('ticketAassigner.ticket', $ticket->id) }}" class="btn">
    Voir et assigner le ticket
    </a>

</body>
</html>