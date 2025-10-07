@extends('layouts.dynamique')
@section('content')


    @if (!empty($detail_materiel))
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="section-title mb-4">{{ $detail_materiel['model'] }}</h4>
                </div>
                <div class="card-body" style="background-color:rgba(11, 5, 22, 0.137);">

                    <div class="row">
                        <div class="col-lg-3 mb-5 mb-lg-0">
                            <div class="imgs-materiel">
                                <div class="images"><img src="{{ asset('storage/' . $detail_materiel['image']) }}"
                                        style="   border-radius: 20px; max-width: 225px;" alt="Untree.co"></div>
                            </div>
                        </div>
                        <div class="col-lg-5 ps-lg-3">
                            <h3>
                                <str style="color:rgba(0, 47, 255, 0.712);">Information du materiel</str>
                            </h3>
                            <strong>Id :</strong> {{ $detail_materiel['id'] }},

                            <strong>Type : </strong>{{ $detail_materiel['type'] }},
                            <strong>Marque : </strong>{{ $detail_materiel['marque'] }},
                            <strong>Model : </strong>{{ $detail_materiel['model'] }},
                            <strong>Numero de Serie : </strong>{{ $detail_materiel['num_serie'] }},

                            @foreach ($colonnes as $colonnes)
                                @if ($detail_materiel[$colonnes] != '-')
                                    <strong>{{ $colonnes }} : </strong> {{ $detail_materiel[$colonnes] ?? '-' }},
                                @endif
                            @endforeach
                            <br>
                            <br>

                            <strong>Status : </strong>
                            @if ($detail_materiel['status'] == 'disponible')
                                <span
                                    style="background-color:rgba(0, 128, 0, 0.603);color:white;border-radius:10px;padding:5px">{{ $detail_materiel['status'] }}</span>
                            @elseif ($detail_materiel['status'] == 'utiliser')
                                <span
                                    style="background-color:rgba(35, 240, 213, 0.74);color:white;border-radius:10px;padding:5px">{{ $detail_materiel['status'] }}</span>
                                par <a href="#" data-bs-toggle="collapse"
                                    data-bs-target="#infoutilisateur">{{ $detail_materiel['nom_utilisateur'] }}</a>
                            @else
                                <span
                                    style="background-color:rgba(240, 192, 35, 0.74);color:white;border-radius:10px;padding:5px">{{ $detail_materiel['status'] }}</span>
                            @endif
                            <div id="infoutilisateur" class="collapse">
                                <h4>
                                    <str style="color:rgba(0, 47, 255, 0.712);">Apropos de l'utilisateur</str>
                                </h4>
                                <strong>Nom : </strong>{{ $detail_materiel['nom_utilisateur'] }} <br>
                                <strong>Prenom : </strong>{{ $detail_materiel['prenom_utilisateur'] }} <br>
                                <strong>Société : </strong>{{ $detail_materiel['societe'] }} <br>
                                <strong>Equipe : </strong>{{ $detail_materiel['equipe'] }} <br>
                                <strong><i class="fa fa-envelope me-3"></i> </strong>{{ $detail_materiel['email'] }}

                            </div>





                        </div>
                        <div class="col-lg-4 ps-lg-2">
                            <h3>
                                <str style="color:rgba(0, 47, 255, 0.712);">Localisation</str>
                            </h3>
                            <strong>Code emplacement : </strong>{{ $detail_materiel['code_emplacement'] }} <br>
                            <strong>Emplacement : </strong>{{ $detail_materiel['emplacement'] }} <br>
                            <strong>Code final : </strong>{{ $detail_materiel['code_final'] }} <br><br><br>


                        </div>
                        <div>

                        </div>
                        <div class="text-center">
                            <a href="/affectation/{{ $detail_materiel['id'] }}" class="btn btn-info  btn-sm m-2">Affecter
                                vers un utilisateur</a>
                            <button type="button" class="btn btn-sm btn-primary m-2" disabled>Affecter dans une
                                centre</button>
                            <a href="#" class="btn btn-secondary" data-bs-toggle="collapse"
                                data-bs-target="#affichagelog">Voir Log</a>

                        </div>

                    </div>
                </div>

            </div>

        </div>

        <div id="affichagelog" class="collapse">
            <div class="col-lg-12">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Description</th>
                            <th>Type du matériel</th>
                            <th>Modèle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $activity->created_at }}</td>
                                <td>{{ optional($activity->causer)->nom_utilisateur ?? 'Système' }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->properties['attributes']['type'] ?? '-' }}</td>
                                <td>{{ $activity->properties['attributes']['model'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @else
        <h1>hafa</h1>
    @endif
@endsection
