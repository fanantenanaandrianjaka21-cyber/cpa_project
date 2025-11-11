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
                                            <h7 class="mb-0 text-end">{{ $totalMateriels }}</h7>
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
                                            <h7 class="mb-0 text-end">{{ $totalMateriels }}</h7>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div
                                        class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-2 mb-2">
                                        <i class="fa fa-ticket fa-3x text-white "></i>
                                        <div class="ms-3">
                                            <h7 class="mb-2 text-end">Tickets</h7>
                                            <h7 class="mb-0 text-end">{{ $totalMateriels }}</h7>
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
                                            <h7 class="mb-0 text-end">{{ $totalMateriels }}</h7>
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
                                            <h7 class="mb-0 text-end">{{ $totalMateriels }}</h7>
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




    <script>
        // --- Prévision demande matériel ---
        new Chart(document.getElementById('previsionDemandes'), {
            type: 'line',
            data: {
                labels: {!! json_encode($previsionDemandes->keys()) !!},
                datasets: [{
                    label: 'Demande estimée',
                    data: {!! json_encode($previsionDemandes->values()) !!},
                    borderColor: '#36A2EB',
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // --- Durée de vie moyenne ---
        new Chart(document.getElementById('vieMoyenneParType'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($vieMoyenneParType->keys()) !!},
                datasets: [{
                    label: 'Durée de vie (ans)',
                    data: {!! json_encode($vieMoyenneParType->values()) !!},
                    backgroundColor: '#FFCE56'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // --- Risque de panne par service ---
        new Chart(document.getElementById('servicesRisque'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($servicesRisque->keys()) !!},
                datasets: [{
                    label: 'Probabilité de panne',
                    data: {!! json_encode($servicesRisque->values()) !!},
                    backgroundColor: '#FF6384'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            callback: value => value * 100 + '%'
                        }
                    }
                }
            }
        });
    </script>


    <!-- Chart.js local -->
    {{-- <script src="{{ asset('js/chart.js') }}"></script> --}}

    <script>
        // --- Section 1 : Parc & Stock ---
        new Chart(document.getElementById('repartitionType'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($repartitionType->keys()) !!},
                datasets: [{
                    data: {!! json_encode($repartitionType->values()) !!},
                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0']
                }]
            }
        });
        new Chart(document.getElementById('ticketsStatus'), {
            type: 'pie',
            data: {
                labels: ['Ouverts', 'En cours', 'Fermés'],
                datasets: [{
                    data: [{{ $ticketsOuverts }}, {{ $ticketsEncours }}, {{ $ticketsResolus }}],
                    backgroundColor: ['#FF6384', '#FF9F40', '#4BC0C0']
                }]
            }
        });

        // --- Section 2 : Affectation ---
        new Chart(document.getElementById('repartitionService'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($repartitionService->keys()) !!},
                datasets: [{
                    label: 'Matériels par service',
                    data: {!! json_encode($repartitionService->values()) !!},
                    backgroundColor: '#36A2EB'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        new Chart(document.getElementById('disponibiliteParc'), {
            type: 'doughnut',
            data: {
                labels: ['Affectés', 'Disponibles'],
                datasets: [{
                    data: [{{ $materielsAffectes }}, {{ $materielsDisponibles }}],
                    backgroundColor: ['#4BC0C0', '#FFCE56']
                }]
            }
        });

        // --- Section 3 : Maintenance ---
        new Chart(document.getElementById('ticketsPriorite'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($ticketsParPriorite->keys()) !!},
                datasets: [{
                    label: 'Tickets',
                    data: {!! json_encode($ticketsParPriorite->values()) !!},
                    backgroundColor: ['#FF6384', '#FFCE56', '#36A2EB']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        new Chart(document.getElementById('ticketsMois'), {
            type: 'line',
            data: {
                labels: {!! json_encode($ticketsParMois->keys()) !!},
                datasets: [{
                    label: 'Tickets par mois',
                    data: {!! json_encode($ticketsParMois->values()) !!},
                    borderColor: '#36A2EB',
                    fill: false,
                    tension: 0.3
                }]
            }
        });
    </script>
@endsection
