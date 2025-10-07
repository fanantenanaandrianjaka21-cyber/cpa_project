@extends('layouts.dynamique')

@section('content')
    <div class="header">
        <i class="fa fa-home"></i>/ Inventaire / Nouveau Inventaire

    </div>
    <div style="text-align: right;">
        <a href="#" data-bs-toggle="collapse" data-bs-target="#avancement">Avancement de l'inventaire</a>
    </div>
    <div style="width: 165vh;" id="avancement" class="collapse">
        <div class="text-center">
            <h4>Avancement de l'inventaire</h4>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <strong>Clavier :</strong><br>
                Quantite physique effectué: 25/100

                <div class="progress mb-3">

                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
            </div>
            <div class="col-lg-3">
                <strong>Ecran plat : </strong><br>
                Quantite physique effectué: 50/400
                <div class="progress mb-3">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-lg-3">
                <strong>Souris :</strong><br>
                Quantite physique effectué: 53/500
                <div class="progress mb-3">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-lg-3">
                <strong>Swich : </strong><br>
                Quantite physique effectué: 3/67
                <div class="progress mb-3">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>




    <div class="card">
        <div class="card-header">
            <h7>Enregistrement nouveau inventaire</h7>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-4">
                    <div id="reader"></div>

                </div>
                <div class="col-lg-8">
                    <h4>Formulaire d'Inventaire</h4>

                    <h5 id="nom"></h5>
                    <div id="details"></div>

                    <br>
                    <div id="materiel-info" style="margin-top:20px;">


                        @foreach ($colonnes as $index => $colonnes)
                            <div id="{{ $index }}"></div>
                        @endforeach
                        <div class="row mb-3">
                            <label for="composant_manquant"
                                class="col-md-4 col-form-label text-md-end">{{ __('Composant manquant:') }}</label>

                            <div class="col-md-6">
                                <input id="composant_manquant" type="text"
                                    class="form-control @error('composant_manquant') is-invalid @enderror"
                                     required autofocus>

                                @error('composant_manquant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">

                            <label for="composant_non_enregistre"
                                class="col-md-4 col-form-label text-md-end">{{ __('Composant non enregistré :') }}</label>

                            <div class="col-md-6">
                                <input id="composant_non_enregistre" type="text"
                                    class="form-control @error('composant_non_enregistre') is-invalid @enderror"
                                     required  autofocus>

                                @error('composant_non_enregistre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="etat" class="col-md-4 col-form-label text-md-end">{{ __('État :') }}</label>

                            <div class="col-md-6">
                                <select id="etat" class="form-select">
                                    <option value="Neuf">Neuf</option>
                                    <option value="Bon">Bon</option>
                                    <option value="Moyen">Moyen</option>
                                    <option value="Mauvais">Mauvais</option>
                                </select>

                                @error('etat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="observation"
                                class="col-md-4 col-form-label text-md-end">{{ __('Observation :') }}</label>

                            <div class="col-md-6">
                                <input id="observation" type="text"
                                    class="form-control @error('observation') is-invalid @enderror"
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
                                <button id="save" class="btn btn-primary">
                                    {{ __('Enregistrer') }}
                                </button>
                                <button id="resetBtn" class="btn btn-secondary"><i class="fa fa-rotate-right"></i>
                                    Réinitialiser le scanner</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        {{-- <script src="https://unpkg.com/html5-qrcode"></script> --}}

        <script>
            let currentId = null;

            function onScanSuccess(decodedText, decodedResult) {
                fetch('/inventaire/scan/' + encodeURIComponent(decodedText))
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


                        document.getElementById("nom").innerText = `${data.type} (${data.code_interne})`;
                        document.getElementById("details").innerText =
                            `Marque : ${data.marque}, Model : ${data.model}, Numero de serie : ${data.num_serie}, Status : ${data.status} `;


                        // Nettoyer toutes les colonnes avant
                        var col = data.colonnes;
                        for (let x in col) {
                            document.getElementById(x).innerText = "";
                        }

                        //  Remplir uniquement celles qui existent
                        for (let x in col) {
                            if (data[col[x]] && data[col[x]] != '-') {
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


            var html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: 250
                });
            html5QrcodeScanner.render(onScanSuccess);


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
                        var valeur=[];
                        document.getElementById("nom").innerText = "";
                        document.getElementById("details").innerText = "";
                        // il faut que tu ajoute le reset scanner ici
                        for (let x in col) {
                            // document.getElementById(x).innerText = "";
                            valeur[x]=document.getElementById(`${col[x]}`).value;
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
                            composant_manquant: document.getElementById("composant_manquant").value,
                            composant_non_enregistre: document.getElementById("composant_non_enregistre")
                                .value,
                            etat: document.getElementById("etat").value,
                            observation: document.getElementById("observation").value,
                            anciencle:col,
                            valeur:valeur,

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
