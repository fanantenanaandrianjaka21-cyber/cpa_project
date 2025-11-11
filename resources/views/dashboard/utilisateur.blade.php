@extends('layouts.dynamique')

@section('content')
    <div class="col-lg-12">
        <div class="header">
            <i class="fa fa-home"></i>/ Tableau de Bord

        </div>
        <section>
            <!--Section 1 : Statistiques générales -->

            <h2></h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-3 color-secondary mb-2">
                        <div class="body m-3">
                            <h7 class=" text-primary">Résumé Global</h7>
                            <div class="row p-2">
                                <div class="col-lg-7">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-user fa-3x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Total Utilisateurs</h7>
                                            <h7 class="mb-0 text-end">{{ 5}}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-building fa-3x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Sites</h7>
                                            <h7 class="mb-0 text-end">6</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-laptop fa-3x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Materiels</h7>
                                            <h7 class="mb-0 text-end">{{ 5}}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-ticket fa-3x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Tickets</h7>
                                            <h7 class="mb-0 text-end">{{ 5 }}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="bg-secondary rounded-3 align-items-center justify-content-between p-2">
                                        {{-- <i class="fa fa-laptop fa-3x text-white "></i> --}}
                                        <h7 class="mb-2 text-end d-flex ">Taux d'utilisation du stock</h7>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-3 color-secondary mb-2">
                        <div class="body m-3">
                            <h7 class="text-center text-primary">Surveillance de sécurité et des accès</h7>
                            <div class="row p-2">
                                <div class="col-lg-12">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-laptop fa-3x text-white "></i>
                                        <div class="ms-3 ">
                                            <h7 class="mb-2 text-end">DERNIERES CONNEXIONS</h7>
                                            <h7 class="mb-0 text-end">{{ 5 }}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-laptop fa-3x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">TENTATIVES ECHOUEES</h7>
                                            <h7 class="mb-0 text-end">6</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2">
                                        <i class="fa fa-laptop fa-3x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">ALERTE DE PERMISSIONS MODIFIEES</h7>
                                            <h7 class="mb-0 text-end">{{ 5}}</h7>
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
                    <div class="card rounded-3 color-secondary mb-2">
                        <div class="body m-3">
                            <h7 class=" text-primary">Activité récente</h7>
                            <div class="row p-2">
                                <div class="col-lg-12">
                                    <div class="bg-secondary rounded-3 align-items-center justify-content-between p-4">
                                        <h7 class="mb-2 text-end d-flex ">Activité récente</h7>
                                        <ul>
                                            <li>
                                                <a href="#">Action d'administrateur</a>
                                            </li>
                                            <li>
                                                <a href="#">Action de technicien</a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-3 color-secondary mb-2">
                        <div class="body m-3">
                            <h7 class="text-center text-primary">Gestion rapide</h7>
                            <div class="row p-2">
                                <div class="col-lg-12 pb-2">
                                    <div class="bg-secondary rounded-3 d-flex align-items-center p-2">
                                        <i class="fa fa-user fa-2x text-white ml-4 mr-3"></i>
                                        <h7>Gerer rôles</h7>
                                    </div>
                                </div>
                                <div class="col-lg-12 pb-2">
                                    <div class="bg-secondary rounded-3 d-flex align-items-center p-2">
                                        <i class="fa fa-plus fa-2x text-white ml-4 mr-3"></i>
                                        <h7>Créer admin</h7>
                                    </div>
                                </div>
                                <div class="col-lg-12 pb-2">
                                    <div class="bg-secondary rounded-3 d-flex align-items-center p-2">
                                        <i class="fa fa-cog fa-2x text-white ml-4 mr-3"></i>
                                        <h7>Configurer notifications</h7>
                                    </div>
                                </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card rounded-3 color-secondary ">
                        <div class="body m-4 d-flex">
                            <div class="p-4 bg-white bg-opacity-10 border-start border-5 border-success w-330px mr-4">
                                <i class="fa fa-check-circle" style="color: #4caf50; font-size: 24px;"></i>
                                <div style="font-size: 24px; font-weight: bold;">86%</div>
                                <div>Tickets résolus</div>
                            </div>
                            <div class="p-4 bg-white bg-opacity-10 border-start border-5 border-warning w-330px mr-4">
                                <i class="fa fa-exclamation-triangle" style="color: #ff9800; font-size: 24px;"></i>
                                <div style="font-size: 24px; font-weight: bold;">12%</div>
                                <div>Stock critique</div>
                            </div>
                            <div class="p-4 bg-white bg-opacity-10 border-start border-5 border-danger w-330px ">
                                <i class="fa fa-bell" style="color: #f44336; font-size: 24px;"></i>
                                <div style="font-size: 24px; font-weight: bold;">37</div>
                                <div>Alertes non résolues</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection