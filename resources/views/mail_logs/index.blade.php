@extends('layouts.dynamique')

@section('content')
<div class="container mt-4">
    <h3><i class="fa fa-envelope"></i> Historique des mails envoyés</h3>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-primary text-center">
            <tr>
                <th>Email destinataire</th>
                <th>Type matériel</th>
                <th>Seuil</th>
                <th>Critique</th>
                <th>Date et heure d’envoi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr class="text-center">
                    <td>{{ $log->email_destinataire }}</td>
                    <td>{{ $log->type_materiel }}</td>
                    <td>{{ $log->niveau_seuil }}</td>
                    <td>{{ $log->niveau_critique }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->envoye_le)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- 🔄 Option : Rafraîchissement automatique toutes les 30s --}}
<script>
    setTimeout(() => {
        window.location.reload();
    }, 30000); // 30 secondes
</script>
@endsection
