@extends('layouts.dynamique')

@section('content')
    <div class="header">
        <i class="fa fa-home"></i>/ Inventaire / Nouveau Inventaire

    </div>
    <div class="w3-panel">
        <h4 class="w3-start w3-animate-right">
            Etat Materiels
        </h4>
    </div>

    <div class="card ">
        <div class="card-body bg-primary text-white">
            <p class="text-black">Sélectionnez un fichier Excel (.xlsx) contenant une liste des "etat materiels".</p>
<div class="d-flex align-items-center gap-4">

    <!-- Formulaire Import -->
    <div class="d-flex align-items-center gap-2">
        <form method="POST" action="{{ route('etatmaterielexcel.import') }}" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="fichier" class="form-control">
            <button type="submit" class="btn btn-success">Importer</button>
        </form>
    </div>

    <!-- Formulaire Export -->
    <div class="d-flex align-items-center gap-2">
        <form method="POST" action="{{ route('inventaireexcel.export') }}" class="d-flex align-items-center gap-2">
            @csrf
            <button type="submit" class="btn btn-success">Export Excel</button>

            <select name="extension" class="form-select" style="width: auto;">
                <option value="xlsx">.xlsx</option>
                <option value="csv">.csv</option>
            </select>
        </form>
    </div>

</div>


           
            <div id="filters" class="row mb-3"></div>
            <table id="bootstrap-data-table-export" class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Materiel</th>
                        <th>Utilisateur</th>
                        <th>Code inventaire</th>
                        {{-- <th>Marque</th> --}}
                        {{-- <th>Etat General</th> --}}
                        <th>Vérification physique</th>
                        {{-- @foreach ($colonnes as $colonne)
                            <th>{{ $colonne }}</th>
                        @endforeach --}}
                        {{-- <th>Localisation</th>
                                <th>status</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{ dd($detail_materiel ) }} --}}
                    @foreach ($detail_materiel as $materiel)
                        <tr data-row-id="{{ $materiel['id'] }}">
                            <td>{{ $materiel['id'] }}</td>
                            {{-- <td class="text-center"><img class="card-img-top"
                                            style="background-size: cover;min-height: 100px; max-height: 100px;max-width:150px"src="{{ asset('storage/' . $materiel['image']) }}"><br>{{ $materiel['type'] }}
                                    </td> --}}
                            <td class="text-center">
                                {{ $materiel['type'] }}
                            </td>
                            {{-- <td class="text-center">{{ $materiel['marque'] ?? '--' }}</td> --}}
                            <td class="text-center">{{ $materiel['nom_utilisateur'] ?? '--' }}
                                {{ $materiel['prenom_utilisateur'] ?? '--' }}</td>
                            {{-- <td>
                                {{ $materiel['Etat'] }}
                            </td> --}}
                            <td>
                                {{ $materiel['code_interne'] }}
                            </td>
                           
                            @if ($materiel['Verification_physique'] == 'true')
                                <td class="text-success">
                                    Terminer <i class="fa fa-check"></i>
                                </td>
                            @else
                             {{-- {{ dd($materiel['Verification_physique']) }} --}}
                                <td class="text-danger">
                                    Non valide <i class="fa fa-close"></i>
                                </td>
                            @endif


                            <td>
                                <div class="text-center">
                                    <a href="{{ route('caracteristique.voir', ['id'=>$materiel['id'],'page'=>'inventaire']) }}"
                                        class="btn btn-outline-info btn-xs">Voir Etat Dans la Base</a>
                                    {{-- <a href="{{ route('materiel.edit', $materiel['id']) }}"
                                        class="btn btn-outline-secondary btn-xs" data-toggle="tooltip" data-placement="top"
                                        title="Modifier"><i class="fa fa-pencil"></i></a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- <h5 id="nom"></h5>
        <div id="details"></div>
        <div id="materiel-info" style="margin-top:20px;"></div>
        <div class="card-body bg-primary text-white">
            <div class="row mb-3">
                <label for="nom_utilisateur" class="col-md-4 col-form-label text-md-end">Nom de l'utilisateur
                    :</label>

                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" id="nom_utilisateur" class="form-control" placeholder="Recherche" required>
                        <button class="btn btn-success" onclick="scan(nom_utilisateur.value);"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>


            <div id="Etat"></div>
            <div id="Processeur"></div>
            <div id="Ram"></div>


            @foreach ($colonnes as $index => $colonnes)
                <div id="{{ $index }}"></div>
            @endforeach

            <input id="composant_manquant" type="hidden"
                class="form-control @error('composant_manquant') is-invalid @enderror" required autofocus>
            <input id="composant_non_enregistre" type="hidden"
                class="form-control @error('composant_non_enregistre') is-invalid @enderror" required autofocus>
            <div class="row mb-3">
                <label for="etatgeneral" class="col-md-4 col-form-label text-md-end">{{ __('État general :') }}</label>

                <div class="col-md-6">
                    <select id="etatgeneral" class="form-select">
                        <option value="Neuf">Neuf</option>
                        <option value="Bon">Bon</option>
                        <option value="Moyen">Moyen</option>
                        <option value="Mauvais">Mauvais</option>
                    </select>

                    @error('etatgeneral')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="observation" class="col-md-4 col-form-label text-md-end">{{ __('Observation :') }}</label>

                <div class="col-md-6">
                    <input id="observation" type="text" class="form-control @error('observation') is-invalid @enderror"
                        required autofocus>

                    @error('observation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button id="save" class="btn btn-success">
                        {{ __('Enregistrer l\'inventaire') }}
                    </button>
                </div>
            </div>
        </div> --}}
    </div>




    {{-- <script src="https://unpkg.com/html5-qrcode"></script> --}}

    <script>
        let currentId = null;

        // function onScanSuccess(decodedText, decodedResult) {
        //     fetch('/inventaire/scan/' + encodeURIComponent(decodedText))
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.error) {

        //                 document.getElementById("nom").innerText = ``;
        //                 document.getElementById("details").innerText = ``;
        //                 // Nettoyer toutes les colonnes avant
        //                 var col = data.colonnes;
        //                 for (let x in col) {
        //                     document.getElementById(x).innerText = "";
        //                 }
        //                 // ou
        //                 //                       col.forEach(x => {
        //                 //     const elem = document.getElementById(x);
        //                 //     if (elem) elem.innerText = "";
        //                 // });
        //                 alert(data.error);
        //                 return;
        //             }
        //             currentId = data.id;


        //             document.getElementById("nom").innerText = `${data.type} (${data.nom_utilisateur})`;
        //             document.getElementById("details").innerText =
        //                 `Marque : ${data.marque}, Model : ${data.model}, Numero de serie : ${data.num_serie}, Status : ${data.status} `;


        //             // Nettoyer toutes les colonnes avant
        //             var col = data.colonnes;
        //             for (let x in col) {
        //                 document.getElementById(x).innerText = "";
        //             }

        //             //  Remplir uniquement celles qui existent
        //             for (let x in col) {
        //                 if (data[col[x]] && data[col[x]] != '-') {
        //                     document.getElementById(x).innerHTML = `                        <div class="row mb-3">
    //                 <label for="${col[x]}"
    //                     class="col-md-4 col-form-label text-md-end">${col[x]}</label>

    //                 <div class="col-md-6">
    //                     <input id="${col[x]}" type="text"
    //                         class="form-control @error('${col[x]}') is-invalid @enderror"
    //                         value="${data[col[x]]}" required autocomplete="${col[x]}" autofocus>

    //                     @error('${col[x]}')
    //                         <span class="invalid-feedback" role="alert">
    //                             <strong>{{ $message }}</strong>
    //                         </span>
    //                     @enderror
    //                 </div>
    //             </div>`;

        //                     // ${col[x]} : ${data[col[x]]}
        //                 }
        //             }
        //         });
        // }
        function scan(nom_utilisateur) {
            // alert(nom_utilisateur);
            fetch('/inventaire/scan/' + encodeURIComponent(nom_utilisateur))
                .then(response => response.json())
                .then(data => {
                    if (data.error) {

                        document.getElementById("nom").innerText = ``;
                        document.getElementById("details").innerText = ``;
                        // Nettoyer toutes les colonnes avant
                        var col = data.colonnes;
                        for (let x in col) {
                            document.getElementById(x).innerText = "";
                        }
                        // ou
                        //                       col.forEach(x => {
                        //     const elem = document.getElementById(x);
                        //     if (elem) elem.innerText = "";
                        // });
                        alert(data.error);
                        return;
                    }
                    currentId = data.id;


                    document.getElementById("nom").innerText = `${data.type} (${data.nom_utilisateur})`;
                    document.getElementById("details").innerText =
                        `Marque : ${data.marque}, Model : ${data.model}, Numero de serie : ${data.num_serie}, Status : ${data.status} `;


                    // Nettoyer toutes les colonnes avant
                    var col = data.colonnes;

                    for (let x in col) {
                        document.getElementById(x).innerText = "";
                    }
                    document.getElementById('Etat').innerHTML = `                        <div class="row mb-3">
                            <label for="Etat"
                                class="col-md-4 col-form-label text-md-end">Etat</label>

                            <div class="col-md-6">
                                <input id="Etat" type="text"
                                    class="form-control @error('Etat') is-invalid @enderror"
                                    value="${data['Etat']}" required autocomplete="Etat" autofocus>

                                @error('Etat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>`;
                    document.getElementById('Processeur').innerHTML = `                        <div class="row mb-3">
                            <label for="Processeur"
                                class="col-md-4 col-form-label text-md-end">Processeur</label>

                            <div class="col-md-6">
                                <input id="Processeur" type="text"
                                    class="form-control @error('Processeur') is-invalid @enderror"
                                    value="${data['Processeur']}" required autocomplete="Processeur" autofocus>

                                @error('Processeur')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>`;
                    document.getElementById('Ram').innerHTML = `                        <div class="row mb-3">
                            <label for="Ram"
                                class="col-md-4 col-form-label text-md-end">Ram</label>

                            <div class="col-md-6">
                                <input id="Ram" type="text"
                                    class="form-control @error('Ram') is-invalid @enderror"
                                    value="${data['Ram']}" required autocomplete="Ram" autofocus>

                                @error('Ram')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>`;
                    //  Remplir uniquement celles qui existent
                    for (let x in col) {
                        if (data[col[x]] && data[col[x]] != '-') {
                            // alert(col);

                            document.getElementById(x).innerHTML = `                        <div class="row mb-3">
                            <label for="${col[x]}"
                                class="col-md-4 col-form-label text-md-end">${col[x]}</label>

                            <div class="col-md-6">
                                <input id="${col[x]}" type="text"
                                    class="form-control @error('${col[x]}') is-invalid @enderror"
                                    value="${data[col[x]]}" required autocomplete="${col[x]}" autofocus>

                                @error('${col[x]}')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>`;

                            // ${col[x]} : ${data[col[x]]}
                        }
                    }
                });
        }

        // var html5QrcodeScanner = new Html5QrcodeScanner(
        //     "reader", {
        //         fps: 10,
        //         qrbox: 250
        //     });
        // html5QrcodeScanner.render(onScanSuccess);


        document.getElementById("save").addEventListener("click", function() {
            fetch('/inventaire/getColonnes/' + encodeURIComponent(currentId))
                .then(response => response.json())
                .then(data => {
                    // if (data.error) {

                    //     alert(data.error);
                    //     return;
                    // }
                    // alert(data.id);

                    // Nettoyer toutes les colonnes avant
                    var col = data.colonnes;
                    var valeur = [];
                    document.getElementById("nom").innerText = "";
                    document.getElementById("details").innerText = "";
                    // il faut que tu ajoute le reset scanner ici
                    for (let x in col) {
                        // document.getElementById(x).innerText = "";
                        valeur[x] = document.getElementById(`${col[x]}`).value;
                        // alert(col[x]+'valeur '+valeur[x]);
                    }

                    fetch('/inventaire/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id_materiel: currentId,
                                composant_manquant: document.getElementById("composant_manquant")
                                    .value,
                                composant_non_enregistre: document.getElementById(
                                        "composant_non_enregistre")
                                    .value,
                                etat: document.getElementById("Etat").value,
                                observation: document.getElementById("observation").value,
                                anciencle: col,
                                valeur: valeur,

                            })
                        })
                        .then(async res => {
                            let data = await res.json();

                            if (res.ok) {
                                alert("inventaire enregistré avec succès !");
                            } else if (res.status === 422) {
                                // ⚠️ Erreur de validation Laravel
                                if (data.errors && data.errors.id_materiel) {
                                    alert("⚠️ " + data.errors.id_materiel[0]);
                                } else {
                                    alert("⚠️" + data.error);
                                    // alert("ancien cle :" + data.anciencle);
                                    // alert("valeur :" + data.valeur);
                                }
                            } else {


                                alert("Erreur serveur : " + (data.message || "inconnue"));
                            }
                        })
                        .catch(err => {
                            alert("❌ Erreur réseau : " + err);
                        });

                });

        });



        document.getElementById("resetBtn").addEventListener("click", function() {
            html5QrcodeScanner.clear()
                .then(() => {
                    alert("Scanner réinitialisé");
                    html5QrcodeScanner.render(onScanSuccess);
                })
                .catch(err => console.error("Erreur lors du reset:", err));
        });
    </script>
@endsection
