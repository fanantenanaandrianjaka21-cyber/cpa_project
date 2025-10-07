@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row ">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-globe text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Capacity</p>
                                    <p class="card-title">150GB
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            Update Now
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Revenue</p>
                                    <p class="card-title">$ 1,345
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar-o"></i>
                            Last day
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-vector text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Errors</p>
                                    <p class="card-title">23
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i>
                            In the last hour
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row ">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-refresh"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Followers</p>
                                    <p class="card-title">+45K
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            Update now
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--  --}}
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
