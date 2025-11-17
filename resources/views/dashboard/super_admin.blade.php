
@extends('layouts.dynamique')

@section('content')

    <div class="col-lg-12">
        <div class="header">
            <i class="fa fa-home"></i>/ Tableau de Bord

        </div>
        <section class="w3-animate-zoom">
            @if (session('notification'))
                <div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <i class='fa fa-close'></i>
                    </button>
                    <span>
                        <b><i class='fa fa-bell'></i> Success - </b>{{ session('notification') }}
                    </span>
                </div>
            @endif
            <div id="ticket-notification" style="display:none;" class="alert alert-info">
                🔔 Vous avez <span id="ticket-count"></span> nouveau(x) ticket(s) !
                <a href="{{ route('listTicketAdmin') }}"onclick="localStorage.setItem('ticket_non_vu', 0);">Voir les
                    tickets</a>
            </div>
            <h2></h2>
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card rounded-3 color-semi-secondary ">
                        <div class="body m-4 d-flex">
                            <div class="p-2 bg-white bg-opacity-10 border-start border-5 border-success w-330px mr-4">
                                <i class="fa fa-check-circle" style="color: #4caf50; font-size: 24px;"></i>
                                <div style="font-size: 14px; font-weight: bold;">86%</div>
                                <div>Tickets résolus</div>
                            </div>
                            <div class="p-2 bg-white bg-opacity-10 border-start border-5 border-warning w-330px mr-4">
                                <i class="fa fa-exclamation-triangle" style="color: #ff9800; font-size: 24px;"></i>
                                <div style="font-size: 14px; font-weight: bold;">12%</div>
                                <div>Stock critique</div>
                            </div>
                            <div class="p-2 bg-white bg-opacity-10 border-start border-5 border-danger w-330px ">
                                <i class="fa fa-bell" style="color: #f44336; font-size: 24px;"></i>
                                <div style="font-size: 14px; font-weight: bold;">37</div>
                                <div>Alertes non résolues</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-3 color-semi-secondary mb-2">
                        <div class="body m-3">
                            <h7 class=" text-primary">Résumé Global</h7>
                            <div class="row p-2">
                                <div class="col-lg-7">
                                    <div
                                        class="bg-primary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-user fa-2x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Total Utilisateurs</h7>
                                            <h7 class="mb-0 text-end">{{ $total_utilisateurs }}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div
                                        class="bg-primary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-building fa-2x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Sites</h7>
                                            <h7 class="mb-0 text-end">{{ $total_locales }}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div
                                        class="bg-info rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-laptop fa-2x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Materiels</h7>
                                            <h7 class="mb-0 text-end">{{ $total_materiels }}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div
                                        class="bg-info rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-ticket fa-2x text-danger "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Tickets</h7>
                                            <h7 class="mb-0 text-end">{{ $total_tickets }}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="bg-info rounded-3 align-items-center justify-content-between p-2">
                                        {{-- <i class="fa fa-laptop fa-3x text-white "></i> --}}
                                        <h7 class="mb-2 text-end d-flex ">Taux d'utilisation du stock :
                                            {{ $taux_utilisation_stock }} %</h7>
                                        @if ($taux_utilisation_stock != '-')
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $taux_utilisation_stock }}%"
                                                    aria-valuenow="{{ $taux_utilisation_stock }}" aria-valuemin="0"
                                                    aria-valuemax="100">{{ $taux_utilisation_stock }} %
                                                </div>
                                            </div>
                                        @else
                                            Aucun ressource disponible
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-3 color-semi-secondary mb-2">
                        <div class="body m-3">
                            <h7 class="text-center text-primary">Surveillance de sécurité et des accès</h7>
                            <div class="row p-2">
                                <div class="col-lg-12">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-clock-o fa-2x text-white "></i>
                                        <div class="ms-3 ">
                                            <h7 class="mb-2 text-end">DERNIERES CONNEXIONS</h7>
                                            <h7 class="mb-0 text-end">{{ 5 }}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div
                                        class="bg-warning rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-ban fa-2x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">TENTATIVES ECHOUEES</h7>
                                            <h7 class="mb-0 text-end">6</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="bg-danger rounded-3 d-flex align-items-center justify-content-between p-2">
                                        <i class="fa fa-cogs fa-2x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">ALERTE DE PERMISSIONS MODIFIEES</h7>
                                            <h7 class="mb-0 text-end">{{ 5 }}</h7>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-3 color-semi-secondary mb-2">
                        <div class="body m-3">
                            <h7 class=" text-primary">Activité récente</h7>
                            <div class="row p-2">
                                <div class="col-lg-12 pb-2">
                                    <div class="bg-info rounded-3 d-flex align-items-center p-2">
                                        <i class="fa fa-edit fa-2x text-white ml-4 mr-3"></i>
                                        <h7>Action d'Administration</h7>
                                    </div>
                                </div>
                                <div class="col-lg-12 pb-2">
                                    <div class="bg-info rounded-3 d-flex align-items-center p-2">
                                        <i class="fa fa-edit fa-2x text-white ml-4 mr-3"></i>
                                        <h7>Action Technicien</h7>
                                    </div>
                                </div>
                                <div class="col-lg-12 pb-2">
                                    <div class="bg-info rounded-3 d-flex align-items-center p-2">
                                        <i class="fa fa-edit fa-2x text-white ml-4 mr-3"></i>
                                        <h7>Action Responsable</h7>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-3 color-semi-secondary mb-2">
                        <div class="body m-3">
                            <h7 class="text-center text-primary">Gestion rapide</h7>
                            <div class="row p-2">
                                <div class="col-md-6 pb-2">
                                    <div class="bg-secondary rounded-3 d-flex align-items-center p-2">
                                        <i class="fa fa-user fa-2x text-white ml-4 mr-3"></i>
                                        <h7>Gerer rôles</h7>
                                    </div>
                                </div>
                                <div class="col-md-6 pb-2">
                                    <a href="#"data-bs-toggle="modal" data-bs-target="#modal-creer-admin">
                                        <div class="bg-secondary rounded-3 d-flex align-items-center p-2">
                                            <i class="fa fa-plus fa-2x text-white ml-4 mr-3"></i>
                                            <h7>Créer admin</h7>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-12 pb-2">
                                    <a href="{{ route('alertes.index') }}">
                                        <div class="bg-secondary rounded-3 d-flex align-items-center p-2">
                                            <i class="fa fa-cog fa-2x text-white ml-4 mr-3"></i>
                                            <h7>Configurer notifications</h7>

                                        </div>
                                    </a>
                                </div>
                                {{-- <div class="col-lg-12 pb-2">
                                    <a href="#"data-bs-toggle="modal" data-bs-target="#modal-configuration-alert">
                                        <div class="bg-secondary rounded-3 d-flex align-items-center p-2">
                                            <i class="fa fa-cog fa-2x text-white ml-4 mr-3"></i>
                                            <h7>Configurer notifications</h7>

                                        </div>
                                    </a>
                                </div> --}}
                                <div class="col-lg-12 pb-2">
                                    <div class="bg-secondary rounded-3 d-flex align-items-center p-2">
                                        <i class="fa fa-download fa-2x text-white ml-4 mr-3"></i>
                                        <h7>Exporter rapports</h7>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
    <!-- modal configuration alert -->
    <div class="modal fade" id="modal-configuration-alert">
        <div class="modal-dialog modal-lg">
            <div class="modal-content info">
                <div class="modal-header ">
                    <h4 class="modal-title text-primary">Configuration Alert Automatique</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body bg-primary text-white">
                    <form method="POST" action="{{ route('configureAlert') }}" id="register-form"
                        enctype="multipart/form-data" onsubmit="return validateForm()" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="row mb-3">
                            <label for="email_destinataire"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Destinataire :') }}</label>
                            <div class="col-md-7">
                                <input id="email_destinataire" type="email"
                                    class="form-control @error('email_destinataire') is-invalid @enderror"
                                    name="email_destinataire" value="{{ $alert->email_destinataire }}" required
                                    autocomplete="email_destinataire" autofocus>
                                <div class="invalid-feedback">Email invalide.</div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <label>Materiel Min :</label>
                                        <input type="number" name="materiel_min" value="{{ $alert->niveau_seuil }}"
                                            class="form-control
                                            border-0 @error('materiel_min') is-invalid @enderror"
                                            id="materiel_min" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Materiel Critique :</label>
                                        <input type="number" name="materiel_critique"
                                            value="{{ $alert->niveau_critique }}"
                                            class="form-control border-0 @error('materiel_critique') is-invalid @enderror"
                                            id="materiel_critique" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <label>Consommable Min :</label>
                                        <input type="number" name="consommable_min"
                                            class="form-control  border-0 @error('consommable_min') is-invalid @enderror"
                                            id="consommable_min" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Consommable Critique :</label>
                                        <input type="number" name="consommable_critique" id="consommable_critique"
                                            class="form-control border-0 @error('consommable_critique') is-invalid @enderror"
                                            required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="type_materiel" value="default">

                        <div class="row mb-3">
                            <label for="par_jour"
                                class="col-md-8 col-form-label text-md-end">{{ __('Etat alert automatique par jour :') }}</label>

                            <div class="col-md-2">
                                <div class="form-check form-switch">
                                    @if ($alert->par_jour == 'true')
                                        <input class="form-check-input mt-2" type="checkbox" role="switch"
                                            id="par_jour" name="par_jour" checked>
                                    @else
                                        <input class="form-check-input mt-2" type="checkbox" role="switch"
                                            id="par_jour" name="par_jour">
                                    @endif
                                </div>

                                <div class="invalid-feedback">Champ obligatoire.</div>

                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="heure_envoie_par_jour" class="col-md-4 col-form-label text-md-end">Choisir
                                heure d'envoie :</label>
                            <div class="col-md-7">
                                <input id="heure_envoie_par_jour" type="time"
                                    class="form-control @error('heure_envoie_par_jour') is-invalid @enderror"
                                    name="heure_envoie_par_jour" value="{{ $alert->heure_envoie_par_jour }}" required
                                    autocomplete="heure_envoie_par_jour">
                                <div class="invalid-feedback">Champ obligatoire.</div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hebdomadaire"
                                class="col-md-8 col-form-label text-md-end">{{ __('Alert automatique hebdomadaire :') }}</label>

                            <div class="col-md-2">
                                <div class="form-check form-switch mt-2">
                                    @if ($alert->hebdomadaire == true)
                                        <input class="form-check-input" type="checkbox" role="switch" id="hebdomadaire"
                                            name="hebdomadaire" checked>
                                    @else
                                        <input class="form-check-input" type="checkbox" role="switch" id="hebdomadaire"
                                            name="hebdomadaire">
                                    @endif


                                </div>
                                <div class="invalid-feedback">Champ obligatoire.</div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jour_du_semaine" id="jour_du_semaine"
                                class="col-md-4 col-form-label text-md-right">Jour d'envoie : </label>
                            <div class="col-md-7">
                                <select class="form-select" aria-label="Default select example" name="jour_du_semaine"
                                    required>
                                    <option value="{{ $alert->jour_du_semaine }}">{{ $alert->jour_du_semaine }}
                                    </option>
                                    <option value="Lundi">Lundi</option>
                                    <option value="Mardi">Mardi</option>
                                    <option value="Mercredi">Mercredi</option>
                                    <option value="Jeudi">Jeudi</option>
                                    <option value="Vendredi">Vendredi</option>
                                    <option value="Samedi">Samedi</option>
                                    <option value="Dimanche">Dimanche</option>
                                </select>
                                <div class="invalid-feedback">Veuillez selectionner un jour.</div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="heure_envoie_par_semaine" class="col-md-4 col-form-label text-md-end">Choisir
                                heure d'envoie :</label>
                            <div class="col-md-7">
                                <input id="heure_envoie_par_semaine" type="time"
                                    class="form-control @error('heure_envoie_par_semaine') is-invalid @enderror"
                                    name="heure_envoie_par_semaine" value="{{ $alert->heure_envoie_par_semaine }}"
                                    required autocomplete="heure_envoie_par_semaine">
                                <div class="invalid-feedback">Champ obligatoire.</div>

                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-outline-success">Enregistrer</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal configuration alert -->
    {{-- <div class="modal fade" id="modal-configuration-alert">
        <div class="modal-dialog modal-lg">
            <div class="modal-content info">
                <div class="modal-header ">
                    <h4 class="modal-title text-primary">Configuration Alert Automatique</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('configureAlert') }}" id="register-form"
                    enctype="multipart/form-data" onsubmit="return validateForm()" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body color-semi-secondary text-white">
                        <div class="row mb-3">
                            <label for="email_destinataire"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Destinataire :') }}</label>
                            <div class="col-md-7">
                                <input id="email_destinataire" type="email"
                                    class="form-control @error('email_destinataire') is-invalid @enderror"
                                    name="email_destinataire" value="{{ $alert->email_destinataire }}" required
                                    autocomplete="email_destinataire" autofocus>
                                <div class="invalid-feedback">Email invalide.</div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <label>Materiel Min :</label>
                                        <input type="number" name="materiel_min" value="{{ $alert->niveau_seuil }}" class="form-control
                                            border-0 @error('materiel_min') is-invalid @enderror" id="materiel_min" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Materiel Critique :</label>
                                        <input type="number" 
                                            name="materiel_critique"
                                            value="{{ $alert->niveau_critique }}" class="form-control border-0 @error('materiel_critique') is-invalid @enderror"
                                            id="materiel_critique" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <label>Consommable Min :</label>
                                        <input type="number" 
                                            name="consommable_min" class="form-control  border-0 @error('consommable_min') is-invalid @enderror" id="consommable_min"
                                            required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Consommable Critique :</label>
                                        <input type="number" 
                                            name="consommable_critique" id="consommable_critique"
                                            class="form-control border-0 @error('consommable_critique') is-invalid @enderror" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="type_materiel" value="default">

                        <div class="row mb-3">
                            <label for="par_jour"
                                class="col-md-8 col-form-label text-md-end">{{ __('Etat alert automatique par jour :') }}</label>

                            <div class="col-md-2">
                                <div class="form-check form-switch">
                                    @if ($alert->par_jour == 'true')
                                        <input class="form-check-input mt-2" type="checkbox" role="switch"
                                            id="par_jour" name="par_jour" checked>
                                    @else
                                        <input class="form-check-input mt-2" type="checkbox" role="switch"
                                            id="par_jour" name="par_jour">
                                    @endif
                                </div>

                                <div class="invalid-feedback">Champ obligatoire.</div>

                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="heure_envoie_par_jour" class="col-md-4 col-form-label text-md-end">Choisir
                                heure d'envoie :</label>
                            <div class="col-md-7">
                                <input id="heure_envoie_par_jour" type="time"
                                    class="form-control @error('heure_envoie_par_jour') is-invalid @enderror"
                                    name="heure_envoie_par_jour" value="{{ $alert->heure_envoie_par_jour }}" required
                                    autocomplete="heure_envoie_par_jour">
                                <div class="invalid-feedback">Champ obligatoire.</div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hebdomadaire"
                                class="col-md-8 col-form-label text-md-end">{{ __('Alert automatique hebdomadaire :') }}</label>

                            <div class="col-md-2">
                                <div class="form-check form-switch mt-2">
                                    @if ($alert->hebdomadaire == true)
                                        <input class="form-check-input" type="checkbox" role="switch" id="hebdomadaire"
                                            name="hebdomadaire" checked>
                                    @else
                                        <input class="form-check-input" type="checkbox" role="switch" id="hebdomadaire"
                                            name="hebdomadaire">
                                    @endif


                                </div>
                                <div class="invalid-feedback">Champ obligatoire.</div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jour_du_semaine" id="jour_du_semaine"
                                class="col-md-4 col-form-label text-md-right">Jour d'envoie : </label>
                            <div class="col-md-7">
                                <select class="form-select" aria-label="Default select example" name="jour_du_semaine"
                                    required>
                                    <option value="{{ $alert->jour_du_semaine }}">{{ $alert->jour_du_semaine }}</option>
                                    <option value="Lundi">Lundi</option>
                                    <option value="Mardi">Mardi</option>
                                    <option value="Mercredi">Mercredi</option>
                                    <option value="Jeudi">Jeudi</option>
                                    <option value="Vendredi">Vendredi</option>
                                    <option value="Samedi">Samedi</option>
                                    <option value="Dimanche">Dimanche</option>
                                </select>
                                <div class="invalid-feedback">Veuillez selectionner un jour.</div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="heure_envoie_par_semaine" class="col-md-4 col-form-label text-md-end">Choisir
                                heure d'envoie :</label>
                            <div class="col-md-7">
                                <input id="heure_envoie_par_semaine" type="time"
                                    class="form-control @error('heure_envoie_par_semaine') is-invalid @enderror"
                                    name="heure_envoie_par_semaine" value="{{ $alert->heure_envoie_par_semaine }}"
                                    required autocomplete="heure_envoie_par_semaine">
                                <div class="invalid-feedback">Champ obligatoire.</div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center color-semi-secondary">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-outline-success">Enregistrer</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> --}}

    {{-- creer Admin --}}

    <div class="modal fade" id="modal-creer-admin">
        <div class="modal-dialog modal-lg">
            <div class="modal-content info">
                <div class="modal-header ">
                    <h4 class="modal-title text-primary">Ajout Admin</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-primary text-white">
                    <form method="POST" action="/ajoutUser" id="register-form" enctype="multipart/form-data"
                        onsubmit="return validateForm()" class="needs-validation" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <label for="nom_utilisateur"
                                class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="nom_utilisateur" type="text"
                                    class="form-control @error('nom_utilisateur') is-invalid @enderror"
                                    name="nom_utilisateur" value="{{ old('nom_utilisateur') }}" required
                                    autocomplete="nom_utilisateur" autofocus>

                                @error('nom_utilisateur')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="prenom_utilisateur"
                                class="col-md-4 col-form-label text-md-end">{{ __('Prenom') }}</label>

                            <div class="col-md-6">
                                <input id="prenom_utilisateur" type="text"
                                    class="form-control @error('prenom_utilisateur') is-invalid @enderror"
                                    name="prenom_utilisateur" value="{{ old('prenom_utilisateur') }}" required
                                    autocomplete="prenom_utilisateur" autofocus>

                                @error('prenom_utilisateur')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="id"
                                class="col-md-4 col-form-label text-md-end">{{ __('Matricule ') }}</label>

                            <div class="col-md-6">
                                <input id="id" type="number"
                                    class="form-control @error('id') is-invalid @enderror" name="id"
                                    value="{{ old('id') }}"
                                    placeholder="nouveau matricule:{{ $utilisateur->id + 1 }}" required autocomplete="id"
                                    autofocus>

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Contact') }}</label>
                            <div class="col-md-6">
                                <!-- Champ visuel -->
                                <input id="phone" type="tel"
                                    class="form-control @error('contact_utilisateur') is-invalid @enderror"
                                    name="contact_utilisateur" placeholder="Entrez le numéro">
                                @error('contact_utilisateur')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="equipe"
                                class="col-md-4 col-form-label text-md-right">{{ __('Equipe') }}</label>
                            <div class="col-md-6">
                                <select class="form-select" name="equipe">
                                    <option value="Administration">Administration</option>
                                    <option value="ADV">ADV</option>
                                    <option value="Audit">Audit</option>
                                    <option value="Call Adv">Call ADV</option>
                                    <option value="ComptaStar">ComptaStar</option>
                                    <option value="Formation">Formation</option>
                                    <option value="Informatique">Informatique</option>
                                    <option value="my">my</option>
                                    <option value="MyU">MyU</option>
                                    <option value="Recci">Recci</option>
                                    <option value="Serveur">Serveur</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="societe"
                                class="col-md-4 col-form-label text-md-right">{{ __('Societe') }}</label>
                            <div class="col-md-6">
                                <select class="form-select" name="societe">
                                    <option value="ADV">CPA</option>
                                    <option value="Audit">Expert CPA</option>
                                    <option value="ComptaStar">RFC</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="id_emplacement"
                                class="col-md-4 col-form-label text-md-right">{{ __('Emplacement') }}</label>
                            <div class="col-md-6">
                                <select class="form-select" name="id_emplacement">
                                    @if (Auth::user()->role == 'Super Admin' or Auth::user()->role == 'Admin IT')
                                        @foreach ($emplacement as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($emplacement as $emp)
                                            @if ($emp->id == Auth::User()->id_emplacement)
                                                <option value="{{ $emp->id }}">{{ $emp->emplacement }}</option>
                                            @endif
                                        @endforeach

                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role"
                                class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                            <div class="col-md-6">
                                <select class="form-select" name="role">
                                    {{-- <option value="Utilisateur">Utilisateur</option> --}}
                                    @if (Auth::User()->role == 'Super Admin')
                                        {{-- <option value="Technicien IT">Technicien IT</option>
                                            <option value="Responsable Site">Responsable Site</option> --}}
                                        <option value="Admin IT">Admin IT</option>
                                        <option value="Super Admin">Super Admin</option>
                                    @endif

                                </select>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>La confirmation du mot de passe est incorrecte</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- asina etoil en rouge ny champ obligatoir -->
                        <div class="row mb-3">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-end">{{ __('Confirmation du mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-outline-danger"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enregistrer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- <script>
    function checkNewTickets() {

        $.ajax({
            url: "/check-new-tickets",
            method: "GET",
            success: function(response) {
                const count = response.new_tickets;
                // alert('executer'+count);

                if (count > 0) {
                if (parseInt(localStorage.getItem("ticket_non_vu")) == count) {
                    alert('efa egal'+localStorage.getItem("ticket_non_vu"));
                


            }else{
                            var content = {};

                        content.message = 'Notification en bas<h1>test<h1/>';
                        content.icon = 'fa fa-bell';
                        // content.url = 'index.html';
                        // content.target = '_blank';

                        $.notify(content, {
                            // type: 'success',
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                            // time: 5000,
                            timer: 8000,
                        });
                alert('hAFA'+localStorage.getItem("ticket_non_vu"));
                localStorage.setItem("ticket_non_vu", count.toString());
            }

                    $('#ticket-count').text(count);
                    $('#ticket-notification').fadeIn();
                    
                } else {
                    $('#ticket-notification').fadeOut();
                }
            },
            error: function(xhr) {
                console.error("Erreur AJAX :", xhr);
            }
        });
    }

    // Vérifie toutes les 30 secondes
    setInterval(checkNewTickets, 10000);
    // Appel initial immédiat au chargement
    checkNewTickets();

</script> --}}

@endsection
