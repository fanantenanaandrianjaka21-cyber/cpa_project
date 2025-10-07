<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Liste des Utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($utilisateurs as $user)
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['nom'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>
                        <a href="" title="Détails">
                            <i class="fa-solid fa-eye" style="color: #3490dc; margin-right: 10px;"></i>
                        </a>
                    </td>
                    <td>
                        <a href="" title="Modifier">
                            <i class="fa-solid fa-pen-to-square" style="color: #38c172; margin-right: 10px;"></i>
                        </a>
                    </td>
                    <td>
                        <button type="submit" title="Supprimer" onclick="return confirm('Confirmer la suppression ?')"
                            style="border: none; background: none; padding: 0;">
                            <i class="fa-solid fa-trash" style="color: #e3342f;"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
