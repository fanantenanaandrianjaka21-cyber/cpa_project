<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Alerte de stock</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
            text-align: center;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            color: white;
        }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: black; }
        .bg-danger  { background-color: #dc3545; }
        .bg-secondary { background-color: #6c757d; }
    </style>
</head>
<body>

    
    <h2>📊 Rapport d’alerte de stock du <?php echo now();?></h2>
    Bonjour,
    <p>Voici la situation actuelle des matériels par type et par centre :</p>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Matériel</th>
                <th colspan="4">Quantité disponible</th>
            </tr>
            <tr>
                <th colspan="2">Non Distribué</th>
                <th colspan="2">Distribué</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materielpartype as $materiel)
                <tr>
                    <td>{{ $materiel['type'] }}</td>
                    <td colspan="2" style="text-align:center;">
                        {{ $materiel['non_distribue'] }}
                    </td>
                    <td style="text-align:center;">
                        Total en stock : {{ $materiel['quantite'] }}
                    </td>
                    <td>
                        @foreach ($materiel['materielemplacement'] as $materielemplacement)
                            @php
                                $alerteCorrespondante = collect($alert)->firstWhere(
                                    'type_materiel',
                                    $materielemplacement['emplacement'][0]['type'],
                                );
                            @endphp
                            <div style="border-bottom: 1px solid #ccc; padding: 5px;">
                                {{ $materielemplacement['nom_emplacement'] }} :
                                @if ($alerteCorrespondante)
                                    @if ($materielemplacement['quantite'] > 0 && $materielemplacement['quantite'] <= $alerteCorrespondante->niveau_seuil)
                                        <span class="badge bg-danger">{{ $materielemplacement['quantite'] }}</span>
                                    @elseif ($materielemplacement['quantite'] > $alerteCorrespondante->niveau_seuil && $materielemplacement['quantite'] <= $alerteCorrespondante->niveau_critique)
                                        <span class="badge bg-warning">{{ $materielemplacement['quantite'] }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $materielemplacement['quantite'] }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">{{ $materielemplacement['quantite'] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2>📊 Rapport du Mouvement de stock</h2>
                        <table id="bootstrap-data-table-export"
                        class="table table-striped table-striped-bg-default table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Materiel</th>
                                <th>Quantite</th>
                                <th>Mouvement</th>
                                <th>Source</th>
                                <th>Destination</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail_mouvements as $mouvement)
                                <tr>
                                    <td>{{ $mouvement['id'] }}</td>
                                    <td class="text-center ">
                                        {{-- <img class="card-img-top"
                                            style="background-size: cover;min-height: 50px; max-height: 50px;max-width:100px"src="{{ asset('storage/' . $mouvement['image']) }}"><br> --}}
                                        {{ $mouvement['type'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $mouvement['quantite'] }}
                                    </td>
                                    @if ($mouvement['type_mouvement'] == 'entree')
                                        <td class="text-center w3-text-green">{{ $mouvement['type_mouvement'] }}</td>
                                    @else
                                        <td class="text-center" style="color: rgba(255, 0, 0, 0.7)">
                                            {{ $mouvement['type_mouvement'] }}</td>
                                    @endif

                                    <td>
                                        @if (empty($mouvement['source']))
                                            Achat
                                        @else
                                            {{ $mouvement['source'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($mouvement['type_mouvement'] == 'sortie')
                                            {{ $mouvement['email'] }}
                                        @else
                                            {{ $mouvement['destination'] }}
                                            {{-- soloina ny emplacement dans emplacements --}}
                                        @endif
                                    </td>
                                    <td>{{ $mouvement['date_mouvement'] }}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
    <p style="margin-top:20px;">Merci,<br><strong>{{ config('app.name') }}</strong></p>
</body>
</html>
