@extends('layouts.dynamique')
@section('content')
    <div class="header d-none d-lg-block">
        <i class="fa fa-home"></i>/ Dashboard / Configuration alerte

    </div>
    <div class="w3-panel">
        <h4 class="w3-start w3-animate-right">
            Configuration alerte stock minimal et Envoie email automatique
        </h4>
    </div>
    <div class="card">
        <div class="card-body bg-primary text-black">

            <div class="row">
                <div class="col-12">
                    Email destinataire
                    <table id="bootstrap-data-table-expor" class="table table-hover table-responsive ">
                        <thead>
                            <tr>
                                <th>
                                    Materiel
                                </th>
                                <th>
                                    Stock minimal
                                </th>
                                <th>
                                    Stock critique
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($alerte as $alerte)
                                <tr>
                                    <td>{{ $alerte->type_materiel }}</td>

                                    <td>
                                        <div class=" w-25">
                                            <input type="number" name="materiel_min" value="{{ $alerte->niveau_seuil }}"
                                                class="form-control
                                            border-0 @error('materiel_min') is-invalid @enderror"
                                                id="materiel_min" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class=" w-25">
                                            <input type="number" name="materiel_min" value="{{ $alerte->niveau_critique }}"
                                                class="form-control
                                            border-0 @error('materiel_min') is-invalid @enderror"
                                                id="materiel_min" required>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-success modifier-btn" data-id="{{ $alerte->id }}">
                                            <i class="fa fa-check"></i> Modifier
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.modifier-btn').forEach(button => {
    button.addEventListener('click', async () => {
        const id = button.getAttribute('data-id');
        const row = button.closest('tr');
        const stockMinimal = row.querySelectorAll('input')[0].value;
        const stockCritique = row.querySelectorAll('input')[1].value;

        const res = await fetch(`/alerte/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                niveau_seuil: stockMinimal,
                niveau_critique: stockCritique
            })
        });

        const data = await res.json();
        if (res.ok) {
            alert("✅ Alerte mise à jour avec succès !");
        } else {
            alert("❌ Erreur : " + data.message);
        }
    });
});

    </script>
@endsection
