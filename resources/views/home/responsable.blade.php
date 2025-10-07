@extends('layouts.dynamique')

@section('content')

    <head>
        <script src="stylenet/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="stylenet/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE -->
        <script src="stylenet/dist/js/adminlte.js"></script>

        <!-- OPTIONAL SCRIPTS -->
        <script src="stylenet/plugins/chart.js/Chart.min.js"></script>
        <script src="stylenet/dist/js/demo.js"></script>
        <!--<script src="stylenet/dist/js/pages/dashboard3.js"></script>-->

        <!-- Template Stylesheet -->
        <link href="charttest/css/style.css" rel="stylesheet">
    </head>

    <div class="container position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->




        <!-- Content Start -->
        <div>
            <form>
                <input class="form-control border-1" type="search" placeholder="Recherche">
            </form>

            <div class="container-fluid">

                <div class="row">
                    <section class="col-lg-6 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h6 style="font-family:garamond,text-align:center;" class="card-title">
                                    <!-- <img  src="icon/eye.png"> -->
                                    Tendance du nombre des .... par ....à Madagascar
                                </h6>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <!-- debut sales-chart -->
                                <div class="col-lg-12">
                                    <div class="fond">

                                        <div class="card-body">
                                            <div class="d-flex">
                                                <p class="d-flex flex-column">
                                                    <span class="text-bold text-lg"> </span>
                                                    <span></span>
                                                </p>
                                                <p class="ml-auto d-flex flex-column text-right">

                                                    <span class="text-muted">Année : 2023</span>
                                                </p>
                                            </div>
                                            <!-- /.d-flex -->

                                            <div class="position-relative mb-4">
                                                <canvas id="visitors-chart"
                                                    height="250"style="background-color: white;"></canvas>
                                            </div>

                                            <div class="d-flex flex-row " style="font-size:20px">
                                                <span class="mr-2">
                                                    <strong style="color: #cc1515;"><i class="fa fa-square"
                                                            style="font-size:20px;"></i></strong><B style="">couleur
                                                        en Rouge &nbsp &nbsp</B>
                                                </span>

                                                <span>
                                                    <strong style="color: #0956e4;"><i class="fa fa-square"
                                                            style="font-size:20px;"></i> </strong> <B>couleur en Bleu</B>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- fin sales-chart #31EC56 #00ABE4  #0956e4; #cc1515;-->
                                </div>
                                <!-- /.card -->

                    </section>
                    <section class="col-lg-6 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h6 style="font-family:garamond,text-align:center;" class="card-title">
                                    <!-- <img  src="icon/eye.png"> -->
                                    Pourcentage des ...
                                </h6>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <!-- debut sales-chart -->
                                <div class="col-lg-12">
                                    <div class="fond">

                                        <div class="card-body">
                                            <div class="d-flex">
                                                <p class="d-flex flex-column">
                                                    <span class="text-bold text-lg"> </span>
                                                    <span></span>
                                                </p>
                                                <p class="ml-auto d-flex flex-column text-right">

                                                    <span class="text-muted">Année : 2023</span>
                                                </p>
                                            </div>
                                            <!-- /.d-flex -->

                                            <div class="position-relative mb-4">
                                                <canvas id="pieChart"
                                                    height="275"style="background-color: white;"></canvas>
                                            </div>

                                            <div class="d-flex flex-row" style="font-size:20px">
                                                <span class="mr-2">
                                                    <strong style="color: #cc1515;"><i class="fa fa-square"
                                                            style="font-size:20px;"></i></strong><B style=""> Couleur
                                                        en rouge</B>
                                                </span>

                                                <span>
                                                    <strong style="color: #0956e4;"><i class="fa fa-square"
                                                            style="font-size:20px;"></i></strong> <B>Couleur en Bleu</B>
                                                </span>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- fin sales-chart #31EC56 #00ABE4 #96C2DB-->
                                </div>
                                <!-- /.card antsirabe.0.iesav
                           -->
                    </section>
                </div>
            </div><!-- /.container-fluid -->




            <div class="card">
                <div class="card-header">
                    <h4 style="font-family:garamond,text-align:center;" class="card-title">
                        <!-- <img  src="icon/eye.png"> -->
                        Niveau de.. par ...
                    </h4>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <!-- debut sales-chart -->
                    <div class="col-lg-12">
                        <div class="fond">

                            <div class="card-body"style="margin-top: 20px;">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg"></span>
                                        <span></span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">

                                        <span class="text-muted">Année : 2023</span>
                                    </p>
                                </div>
                                <!-- /.d-flex -->

                                <div class="position-relative mb-4">
                                    <canvas id="sales-chart" height="240"style="background-color: white;"></canvas>
                                </div>
                                <div class="d-flex flex-row justify-content-end" style="font-size:20px">

                                    <span class="mr-2">
                                        <strong style="color: #0956e4;"><i class="fa fa-square"
                                                style="font-size:36px;"></i></strong><B style=""> Nombre
                                            d'utilisateurs </B>

                                    </span>

                                    <!-- <span >
                                    <strong style="color:rgb(228, 0, 0);"><i class="fa fa-square" style="font-size:36px;"></i></strong><B style=""> Nombre d'utilisateurs </B>
                                  </span> -->
                                </div>
                            </div>
                        </div>
                        <!-- fin sales-chart -->
                    </div>
                    <!-- /.card -->





                </div>
                <!-- Content End -->


                <!-- Back to Top
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>-->
            </div>

            <!-- Template Javascript -->
            <script src="charttest/js/main.js"></script>
            <script>
                $(function() {
                    'use strict'
                    var ticksStyle = {
                        fontColor: 'black',
                        fontStyle: 'bold'
                    }

                    var mode = 'index'
                    var intersect = true
                    //debut sales-chart
                    var $salesChart = $('#sales-chart')
                    var salesChart = new Chart($salesChart, {
                        type: 'bar',
                        data: {
                            labels: ['ANALAMANGA', 'BONGOLAVA', 'ITASY', 'VAKINANKARATRA', 'DIANA', 'SAVA',
                                'AMORON\'I MANIA', 'ATSIMO-ATSINANANA', 'HAUTE MATSIATRA', 'IHOROMBE',
                                'VATOVAVY', 'FITOVINANY', 'BETSIBOKA', 'BOENY', 'MELAKY', 'SOFIA',
                                'ALAOTRA-MANGORO', 'ANALANJIROFO', 'ATSINANANA', 'ANDROY', 'ANOSY',
                                'ATSIMO-ANDREFANA', 'MENABE'
                            ],
                            datasets: [{
                                    backgroundColor: ' #0956e4',
                                    borderColor: ' #007bff',
                                    data: [1500, 2300, 3000, 2100, 2800, 2000, 3000, 1500, 2300, 3000, 2100,
                                        2800, 2000, 3000, 2000, 3000, 1500, 2300, 3000, 2100, 2800, 2000,
                                        3000,
                                    ],
                                    pointHoverBackgroundColor: ' #cc1515',
                                    pointHoverBorderColor: ' #cc1515'
                                },
                                // afaka amina data hafa
                                // {
                                //   backgroundColor: 'black',
                                //   borderColor    : '#ced4da',
                                //   data           : [1400, 1900, 2700, 2900, 1950, 1200, 2600]
                                // }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: mode,
                                intersect: intersect
                            },
                            hover: {
                                mode: mode,
                                intersect: intersect
                            },
                            legend: {
                                display: false
                            },
                            scales: {
                                yAxes: [{
                                    // display: false,
                                    gridLines: {
                                        display: true,
                                        lineWidth: '4px',
                                        color: 'rgba(18, 184, 26, 0.2)',
                                        zeroLineColor: 'transparent'
                                    },
                                    ticks: $.extend({
                                        beginAtZero: true,

                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            if (value >= 1000) {


                                            }
                                            return value + " Utilisateur"
                                        }
                                    }, ticksStyle)
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: ticksStyle
                                }]
                            }
                        }
                    }) //fin sales-chart

                    //debut visitor chart
                    var $visitorsChart = $('#visitors-chart')
                    var visitorsChart = new Chart($visitorsChart, {
                        data: {
                            labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
                            datasets: [{
                                    type: 'line',
                                    data: [150, 100, 160, 148, 123, 147, 180],
                                    backgroundColor: 'transparent',
                                    borderColor: ' #cc1515',
                                    pointBorderColor: ' #cc1515',
                                    pointBackgroundColor: ' #cc1515',
                                    fill: false,
                                    pointHoverBackgroundColor: ' #cc1515',
                                    pointHoverBorderColor: ' #cc1515'
                                },

                                // ilay ovana
                                {
                                    type: 'line',
                                    data: [16, 70, 31, 69, 84, 72, 106],
                                    backgroundColor: 'tansparent',
                                    borderColor: ' #0956e4',
                                    pointBorderColor: ' #0956e4',
                                    pointBackgroundColor: ' #0956e4',
                                    fill: false,
                                    pointHoverBackgroundColor: '#0956e4',
                                    pointHoverBorderColor: '#0956e4'
                                }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: mode,
                                intersect: intersect
                            },
                            hover: {
                                mode: mode,
                                intersect: intersect
                            },
                            legend: {
                                display: false
                            },
                            scales: {
                                yAxes: [{
                                    // display: false,
                                    gridLines: {
                                        display: true,
                                        lineWidth: '4px',
                                        color: 'rgba(0, 0, 0, .2)',
                                        zeroLineColor: 'transparent'
                                    },
                                    ticks: $.extend({
                                        beginAtZero: true,
                                        suggestedMax: 200
                                    }, ticksStyle)
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: ticksStyle
                                }]
                            }
                        }
                    })
                    //fin visitor chart




                    //debut pieChart
                    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                    var pieData = {
                        labels: ["test", "test"],
                        datasets: [{
                            data: ["10", "42"],
                            backgroundColor: [" #cc1515", " #0956e4"],
                            pointHoverBackgroundColor: ' #0956e4',
                            pointHoverBorderColor: ' #0956e4'
                        }]
                    }
                    var pieOptions = {
                        legend: {
                            display: false
                        },
                    }
                    // Create pie or douhnut chart
                    // You can switch between pie and douhnut using the method below.
                    // eslint-disable-next-line no-unused-vars
                    var pieChart = new Chart(pieChartCanvas, {
                        type: 'doughnut',
                        data: pieData,
                        // options: pieOptions
                        options: {
                            tooltips: {
                                callbacks: {
                                    // title:function(){return "%"},
                                    label: (a, data) => data.datasets[0].data[a.index] + '%'
                                }
                            },
                            label: {
                                display: false
                            },
                            legend: {
                                display: false
                            },
                        }
                    })
                    //fin pieChart






                })
            </script>
        @endsection
