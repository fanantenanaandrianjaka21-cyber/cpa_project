@extends('layouts.dynamique')

@section('content')
    <header id="head">

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">



                <!--  row -->
                <!-- COMPLEX TO DO LIST -->




                <div class="row mt">
                    <div class="col-lg-12">
                        <div class="form-panel">
                            <div class=" form">


                                <div class="row mt">
                                    <div class="col-md-12">
                                        <section class="task-panel tasks-widget">
                                            <h1>{{ $emplacement->emplacement }}</h1>
                                            <div class="panel-body">
                                                <div class="task-content">




                                                    {{-- <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull">
            
            
            <img class="sary1" src="{{asset('storage/'.$emplacement->id)}}" title="Profil" alt="" />
        </div>
        <div class="pull-right">
            <a href="" class="label label-primary pull-right"> Retourner</a>
        </div>
    </div>
</div> --}}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Emplacement:</strong>
                                                                {{ $emplacement->emplacement }}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Code emplacement:</strong>
                                                                {{ $emplacement->code_emplacement }}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Code final:</strong>
                                                                {{ $emplacement->code_final }}
                                                            </div>
                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <!-- /col-md-12-->
                                </div>

                                <!-- /row -->
                                <!-- Liste des clients -->


                            </div>
                        </div>
                    </div>
                    <!-- /col-lg-12 -->
                </div>
                <!-- /row -->
            </section>
            <!-- /wrapper -->
        </section>
    </header>
@endsection
