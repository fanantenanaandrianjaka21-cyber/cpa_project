@extends('layouts.dynamique')

@section('content')
    <div class="col-lg-12">
        <div class="header">
            <i class="fa fa-home"></i>/ Tableau de Bord

        </div>
        <section>
            <!--Section 1 : Statistiques générales -->

            <h2></h2>
            <div class="row ">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-info rounded-3 d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-laptop fa-3x text-white "></i>
                        <div class="ms-3">
                            <h6 class="mb-2 text-end">TOTAL MATERIELS</h6>
                            <h6 class="mb-0 text-end">{{ $totalMateriels }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-success rounded-3 d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-check fa-3x text-white"></i>
                        <div class="ms-3">
                            <h6 class="mb-2 text-end">STOCK DISPONIBLE</h6>
                            <h6 class="mb-0 text-end">{{ $stockDispo }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-danger rounded-3 d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-bell fa-3x text-warning"></i>
                        <div class="ms-3">
                            <h6 class="mb-2 text-end">ARTICLE SOUS SEUIL</h6>
                            <h6 class="mb-0 text-end">{{ $articlesAlerte }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-secondary rounded-3 d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-cogs fa-3x text-warning"></i>
                        <div class="ms-3">
                            <h6 class="mb-2 text-end">MATERIELS EN PANNE</h6>
                            <h6 class="mb-0 text-end">{{ $ticketsOuverts }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4 pt-4">
                <div class="col-md-4">
                    <div class="card rounded-3 color-secondary">
                        <div class="body m-4">
                            <h7 class="text-primary ">REPARTITION DES MATERIELS PAR TYPE</h7>
                            <canvas id="repartitionType" class="mt-2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card rounded-3 color-secondary">
                        <div class="body m-4">
                            <h7 class=" text-primary">DISPONIBILITE DES MATERIELS</h7>
                            <canvas id="disponibiliteParc" class="mt-2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card rounded-3 color-secondary">
                        <div class="body m-4">
                            <h7 class=" text-primary">STATUT DES TICKETS</h7>
                            <canvas id="ticketsStatus" class="mt-2"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🧰 Section 2 : Utilisation et Affectation -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-3 color-secondary">
                        <div class="body m-4">
                            <h7 class=" text-primary">MATERIELS AFFECTÉS PAR SERVICE</h7>
                            <canvas id="repartitionService" class="mt-2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-3 color-secondary">
                        <div class="body m-4">
                            <h7 class="text-center text-primary">PRIORITE DES TICKETS</h7>
                            <canvas id="ticketsPriorite" class="mt-2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h7 class="text-primary">Durée de vie moyenne par type</h7>
                    <canvas id="vieMoyenneParType" class="mt-2"></canvas>
                </div>
                <div class="col-md-6">
                    <h7 class="text-primary">ÉVOLUTION DES TICKETS</h7>
                    <canvas id="ticketsMois" class="mt-2"></canvas>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h7 class="text-primary">Probabilité de panne par service</h7>
                    <canvas id="servicesRisque" class="mt-2"></canvas>
                </div>
                <div class="col-md-6">
                    <h7 class="text-primary">Prévision de la demande (6 prochains mois)</h7>
                    <canvas id="previsionDemandes" class="mt-2"></canvas>
                </div>

            </div>
            <div class="row text-primary mb-4">

                <div class="col-md-4">
                    <h6>Moyenne par utilisateur</h6>
                    <h2>{{ $moyenneMaterielParUser }}</h2>
                </div>
                <div class="col-md-4">
                    <h6>Durée de vie moyenne max</h6>
                    <h2>{{ $vieMoyenneParType->max() }} ans</h2>
                </div>
            </div>



            <!-- 🔧 Section 3 : Maintenance & Support Technique -->
            <h4 class="mt-5 mb-3">Maintenance & Support Technique</h4>
            <div class="row text-primary mb-4">
                <div class="col-md-4">
                    <h6>Tickets en cours</h6>
                    <h2>{{ $ticketsEncours }}</h2>
                </div>
                <div class="col-md-4">
                    <h6>Tickets résolus</h6>
                    <h2>{{ $ticketsResolus }}</h2>
                </div>
                <div class="col-md-4">
                    <h6>Taux de résolution</h6>
                    <h2>{{ $tauxResolution }}%</h2>
                </div>
            </div>


            <hr class="my-5">
            <h4 class="mt-5 mb-3">Statistiques prédictives et analytiques</h4>

            <div class="row text-primary mb-4">
                <div class="col-md-4">
                    <h6>Taux de panne prévisionnel</h6>
                    <h2>{{ $tauxPannePrevision }}%</h2>
                </div>

                <div class="col-md-4">
                    <h6>Service le plus à risque</h6>
                    <h2>{{ $servicesRisque->sortDesc()->keys()->first() }}</h2>
                </div>
            </div>



            <div class="row mt-5">

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
